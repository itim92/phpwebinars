<?php


namespace App\FS;


class FS
{
    public function deleteDir($dir)
    {
        $systemLinks = [
            '.',
            '..',
        ];
        $files = scandir($dir);
        $files = array_diff($files, $systemLinks);
        foreach ($files as $file) {
            $filePath = "$dir/$file";
            if (is_dir($filePath)) {
                $this->deleteDir($filePath);
            } else {
                unlink($filePath);
            }
        }
        return rmdir($dir);
    }

    public function scanDir(string $dirname)
    {
        $list = scandir($dirname);

        $list = array_filter($list, function ($item) {
            return !in_array($item, ['.', '..']);
        });

        $filenames = [];

        foreach ($list as $fileItem) {
            $filePath = $dirname . '/' . $fileItem;

            if (!is_dir($filePath)) {
                $filenames[] = $filePath;
            } else {
                $filenames = array_merge($filenames, $this->scanDir($filePath));
            }
        }

        return $filenames;
    }
}