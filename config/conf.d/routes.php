<?php

use App\Data\Category\CategoryController;
use App\Data\Import\ImportController;
use App\Data\Product\ProductController;
use App\Data\Queue\QueueController;

return [
    '/products/'             => [ProductController::class, 'list'],
    '/products/edit'         => [ProductController::class, 'edit'],
    '/products/edit/{id}'    => [ProductController::class, 'edit'],
    '/products/add'          => [ProductController::class, 'add'],
    '/products/delete'       => [ProductController::class, 'delete'],
    '/products/delete_image' => [ProductController::class, 'deleteImage'],

    '/categories/'          => [CategoryController::class, 'list'],
    '/categories/add'       => [CategoryController::class, 'add'],
    '/categories/edit'      => [CategoryController::class, 'edit'],
    '/categories/edit/{id}' => [CategoryController::class, 'edit'],
    '/categories/delete'    => [CategoryController::class, 'delete'],
    '/categories/view'      => [CategoryController::class, 'view'],

    '/categories/view/{id}' => [CategoryController::class, 'view'],
    '/categories/{id}/view' => [CategoryController::class, 'view'],

    '/queue/list' => [QueueController::class, 'list'],
    '/queue/run'  => [QueueController::class, 'run'],

    '/import/index'  => [ImportController::class, 'index'],
    '/import/upload' => [ImportController::class, 'upload'],
];