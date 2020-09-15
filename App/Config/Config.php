<?php


namespace App\Config;


use App\Config\Exception\ConfigDirectoryNotFoundException;
use App\Config\Exception\ConfigFileNotFoundException;
use App\FS\FS;

use ArrayAccess;
use Iterator;

class Config implements ArrayAccess, Iterator
{

    private $data = [];

    private $dataKeys = [];

    public function __construct(array $config)
    {
        foreach ($config as $key => $value) {
            if (is_array($value)) {
                $value = new self($value);
            }

            $this->{$key} = $value;
        }
    }

    public function __get(string $key) {
        return $this->data[$key] ?? (new NullConfig());
    }

    public function __set(string $key, $value) {
        $this->data[$key] = $value;
        $this->dataKeys = array_keys($this->data);
    }

    public function offsetExists($offset)
    {
        return isset($this->data[$offset]);
    }

    public function offsetGet($offset)
    {
        return $this->data[$offset];
    }

    public function offsetSet($offset, $value)
    {
        $this->{$offset} = $value;
    }

    public function offsetUnset($offset)
    {
        unset($this->data[$offset]);
    }

    public function current()
    {
        $key = current($this->dataKeys);

        return $this[$key];
    }

    public function next()
    {
        $key = next($this->dataKeys);

        return $this[$key];
    }

    public function key()
    {
        return current($this->dataKeys);
    }

    public function valid()
    {
        return $this->key() !== false;
    }

    public function rewind()
    {
        reset($this->dataKeys);
    }


    public static function create(string $dirname)
    {
        $dirname = APP_DIR . '/' . $dirname;

        if (!file_exists($dirname) || !is_dir($dirname)) {
            throw new ConfigDirectoryNotFoundException($dirname);
        }

        $fs = new FS();
        $fileList = $fs->scanDir($dirname);

        $defaultConfigs = [];
        $appConfigs = [];

        foreach ($fileList as $fileConfig) {
            if (strpos($fileConfig, 'conf.d') !== false) {
                $config = static::parseConfigPath($fileConfig, $dirname . '/conf.d/');
                $namePath = $config['namePath'];
                $src = [$namePath => $config['src']];

                if (strpos($namePath, '/') !== false) {
                    $namePath = explode('/', $namePath);

                    $src = [];
                    $currentSrcItem = &$src;
                    foreach ($namePath as $key => $pathItem) {
                        if ($key == count($namePath) - 1) {
                            $currentSrcItem[$pathItem] = $config['src'];
                            break;
                        }

                        $currentSrcItem[$pathItem] = [];
                        $currentSrcItem = &$currentSrcItem[$pathItem];
                    }

                    unset($currentSrcItem);
                }

                $defaultConfigs = array_merge_recursive($defaultConfigs, $src);
                continue;
            }

            $config = static::parseConfigPath($fileConfig, $dirname . '/');
            $appConfigs = array_merge_recursive($appConfigs, $config['src']);
        }


        $config = array_replace_recursive($defaultConfigs, $appConfigs);


        return new self($config);
    }
    private static function parseConfigPath(string $configFilePath, string $replacedPart = '')
    {
        if (!file_exists($configFilePath)) {
            throw new ConfigFileNotFoundException($configFilePath);
        }

        $data = [];
        $data['src'] = include $configFilePath;
        $namePath = str_replace($replacedPart, '', $configFilePath);
        $data['namePath'] = str_replace('.php', '', $namePath);


        return $data;
    }
}