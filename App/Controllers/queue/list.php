<?php


use App\TasksQueue;

$tasks = TasksQueue::getTaskList();

$smarty->assign('tasks', $tasks);
$smarty->display('queue/list.tpl');