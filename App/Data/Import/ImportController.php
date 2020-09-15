<?php

namespace App\Data\Import;

use App\Controller\AbstractController;
use App\Data\Import;
use App\Renderer\Renderer;
use App\Data\TasksQueue;

class ImportController extends AbstractController
{

    public function index()
    {
        Renderer::getSmarty()->display('import/index.tpl');
    }

    public function upload()
    {
        $file = $_FILES['import_file'] ?? null;

        if (is_null($file) || empty($file['name'])) {
            die('not import file uploaded');
        }

        $uploadDir = APP_UPLOAD_DIR . '/import';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir);
        }

        $importFilename = 'i_' . time() . '.' . $file['name'];
        move_uploaded_file($file['tmp_name'], $uploadDir . '/' . $importFilename);

//$filename = 'i_1595657757.import.csv';
        $filepath = APP_UPLOAD_DIR . '/import/' . $importFilename;

        $taskName = 'Импорт товаров ' . $importFilename;
        $task = Import::class . '::productsFromFileTask';
        $taskParams = [
            'filename' => $importFilename,
        ];

        TasksQueue::addTask($taskName, $task, $taskParams);

        return $this->redirect('/queue/list');
        /**
         * 1. Загрузка файла с предварительными настройками
         * 2. Анализ файла на основе предварительных настроек
         * 3. Мы должны указать настройки разбора
         * 4. Разбор файла на основе настроек
         */
    }
}