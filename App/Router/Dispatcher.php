<?php

namespace App\Router;

use App\Category\CategoryController;
use App\DI\Container;
use App\Import\ImportController;
use App\Product\ProductController;
use App\Queue\QueueController;
use App\Renderer;
use App\Request;
use App\Router\Exception\MethodDoesNotExistException;
use App\Router\Exception\NotFoundException;

class Dispatcher
{
    protected $routes = [
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

    public function dispatch()
    {
        $request = new Request();
        $url = $request->getUrl();

        $route = new Route($url);

        foreach ($this->routes as $path => $controller) {
            if ($this->isValidPath($path, $route))
                break;
        }

        try {

//            $container = new Container();
            $controllerClass = $route->getController();

            if (is_null($controllerClass)) {
                throw new NotFoundException();
            }

            $controller = new $controllerClass($route);

            $controllerMethod = $route->getMethod();

            if (method_exists($controller, $controllerMethod)) {

                $reflectionClass = new \ReflectionClass($controllerClass);
                $reflectionMethod = $reflectionClass->getMethod($controllerMethod);
                
                $reflectionParamaters = $reflectionMethod->getParameters();

                $arguments = [];

                foreach ($reflectionParamaters as $parameter) {
                    /**
                     * @var \ReflectionParameter $parameter
                     */

                    $parameterName = $parameter->getName();
                    $parameterType = $parameter->getType();

                    assert($parameterType instanceof \ReflectionNamedType);
                    $className = $parameterType->getName();

                    if (class_exists($className)) {
                        $arguments[$parameterName] = new $className();
                    }
                }

                return call_user_func_array([$controller, $controllerMethod], $arguments);
//                return $controller->{$controllerMethod}();
            }


            throw new MethodDoesNotExistException();

//            $route->execute();
        } catch (NotFoundException | MethodDoesNotExistException $e) {
            $this->error404();
        }

    }

    public function isValidPath(string $path, Route $route)
    {
        $controller = $this->routes[$path];

        $isValidPath = $route->isValidPath($path);

        if ($isValidPath) {
            $route->setController($controller[0]);
            $route->setMethod($controller[1]);
        };

        return $isValidPath;
    }

    private function error404()
    {
        Renderer::getSmarty()->display('404.tpl');
        exit;
    }

}