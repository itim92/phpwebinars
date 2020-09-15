<?php

namespace App\Data\Queue;

use App\Controller\AbstractController;
use App\Renderer\Renderer;
use App\Http\Request;
use App\Http\Response;
use App\TasksQueue;

class QueueController extends AbstractController
{


    public function list()
    {
        $tasks = TasksQueue::getTaskList();

        $smarty = Renderer::getSmarty();
        $smarty->assign('tasks', $tasks);
        $smarty->display('queue/list.tpl');
    }

    public function run(Request $request)
    {
        $id = $request->getIntFromGet('id');

        TasksQueue::runById($id);

        $this->redirect('/queue/list');
    }
}