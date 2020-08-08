<?php

use App\CategoryService;
use App\Renderer;
use App\Router\Dispatcher;

require_once 'config.php';

$categoryService = new CategoryService();
$categories = $categoryService->getList();
Renderer::getSmarty()->assign('categories_shared', $categories);

$dispatcher = new Dispatcher();
$dispatcher->dispatch();


