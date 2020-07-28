<?php

namespace App;

use App\Db\Db;

class TasksQueue
{
    public static function addTask(string $name, string $task, array $params)
    {
        $taskMeta = explode('::', $task);

        $taskClassExist = class_exists($taskMeta[0]);
        $taskMethodExist = method_exists($taskMeta[0], $taskMeta[1]);

        if (!$taskClassExist || !$taskMethodExist) {
            return false;
        }

        return Db::insert('tasks_queue', [
            'name'       => $name,
            'task'       => $task,
            'params'     => json_encode($params),
            'created_at' => Db::expr('NOW()'),
        ]);
    }

    public static function getById(int $taskId)
    {
        $query = "SELECT * FROM tasks_queue WHERE id = $taskId";
        return Db::fetchRow($query);
    }

    public static function getTaskList()
    {
        $query = "SELECT * FROM tasks_queue ORDER BY created_at DESC";
        return Db::fetchAll($query);
    }

    public static function setStatus(int $taskId, string $status)
    {
        $availableStatuses = [
            'new',
            'in_process',
            'done',
            'error',
        ];

        if (!in_array($status, $availableStatuses)) {
            die('Status not valid ' . $status . ' for task ' . $taskId);
        }

        return Db::update('tasks_queue', [
            'status' => $status,
        ], 'id = ' . $taskId);
    }

    public static function runById(int $id)
    {
        $task = static::getById($id);

        return static::run($task);
    }

    public static function run(array $task)
    {
        $taskId = $task['id'] ?? null;

        if (empty($task) || is_null($taskId)) {
            return false;
        }

        $taskAction = $task['task'];

        $taskAction = explode('::', $taskAction);
        $taskClassExist = class_exists($taskAction[0]);
        $taskMethodExist = method_exists($taskAction[0], $taskAction[1]);

        if (!$taskClassExist || !$taskMethodExist) {
            static::setStatus($taskId, 'error');
            return false;
        }

        $taskParams = json_decode($task['params'], true);

        static::setStatus($taskId, 'in_process');
        call_user_func($taskAction, $taskParams);
        static::setStatus($taskId, 'done');

        return true;
    }

    public static function execute() {
        $query = "SELECT * FROM tasks_queue WHERE status = 'in_process' LIMIT 1";
        $inProcessTask = Db::fetchRow($query);

        if (!empty($inProcessTask)) {
            echo 'in process task found';
            return false;
        }

        $query = "SELECT * FROM tasks_queue WHERE status = 'new' ORDER BY created_at LIMIT 1";
        $newTaskProcess = Db::fetchRow($query);

        if (empty($newTaskProcess)) {
            echo 'new task not found';
            return false;
        }

        echo "new task found";
        return static::run($newTaskProcess);
    }

}