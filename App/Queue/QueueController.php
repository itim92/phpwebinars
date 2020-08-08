<?php

namespace App\Queue;

use App\Renderer;
use App\Request;
use App\Response;
use App\TasksQueue;

class QueueController
{


    public function list()
    {
        $tasks = TasksQueue::getTaskList();

        $smarty = Renderer::getSmarty();
        $smarty->assign('tasks', $tasks);
        $smarty->display('queue/list.tpl');
    }

    public function run()
    {
        $id = Request::getIntFromGet('id');
        TasksQueue::runById($id);

        Response::redirect('/queue/list');
    }
}