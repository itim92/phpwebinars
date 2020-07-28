<?php

use App\Request;
use App\Response;
use App\TasksQueue;

$id = Request::getIntFromGet('id');

$result = TasksQueue::runById($id);

Response::redirect('/queue/list');