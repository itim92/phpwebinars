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
use ReflectionClass;
use ReflectionException;
use ReflectionObject;
use ReflectionParameter;

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

    protected function getRoutes(): array
    {
        $routes = $this->routes;

//        $controllerFile = APP_DIR . '/App/Product/ProductController.php';

        $files = $this->scanDir(APP_DIR . '/App');

        foreach ($files as $filePath) {
            if (strpos($filePath, 'Controller.php') === false) {
                continue;
            }

            $controllerRoutes = $this->getRoutesByControllerFile($filePath);
            $routes = array_merge($routes, $controllerRoutes);
        }


        return $routes;
    }

    protected function scanDir(string $dirname)
    {
        $list = scandir($dirname);

        $list = array_filter($list, function ($item) {
            return !in_array($item, ['.', '..']);
        });

        $filenames = [];

        foreach ($list as $fileItem) {
            $filePath = $dirname . '/' . $fileItem;

            if (!is_dir($filePath)) {
                $filenames[] = $filePath;
            } else {
                $filenames = array_merge($filenames, $this->scanDir($filePath));
            }
        }

        return $filenames;
    }

    /**
     * @return mixed|null
     * @throws ReflectionException
     */
    public function dispatch()
    {
        $request = new Request();
        $url = $request->getUrl();

        $route = new Route($url);

        foreach ($this->getRoutes() as $path => $controller) {
            if ($this->isValidPath($path, $route))
                break;
        }

        try {
            $controllerClass = $route->getController();

            if (is_null($controllerClass)) {
                throw new NotFoundException();
            }

            $container = new Container();
            $controller = $container->getController($controllerClass);


            $renderer = $container->get(Renderer::class);
            $container->setProperty($controller, 'renderer', $renderer);
            $container->setProperty($controller, 'route', $route);

            $controllerMethod = $route->getMethod();

            if (method_exists($controller, $controllerMethod)) {
                return $container->call($controller, $controllerMethod);
            }

            throw new MethodDoesNotExistException();
        } catch (NotFoundException | MethodDoesNotExistException $e) {
            $this->error404();
        }

    }

    public function isValidPath(string $path, Route $route)
    {
        $routes = $this->getRoutes();
        $controller = $routes[$path];

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

    private function getRoutesByControllerFile(string $filePath)
    {
        $routes = [];

        $controllerClassName = str_replace([APP_DIR . '/', '.php'], '', $filePath);
        $controllerClassName = str_replace('/', '\\', $controllerClassName);

        $reflectionClass = new ReflectionClass($controllerClassName);
        $reflectionMethods = $reflectionClass->getMethods(\ReflectionMethod::IS_PUBLIC);

        foreach ($reflectionMethods as $reflectionMethod) {
            if ($reflectionMethod->isConstructor()) {
                continue;
            }

            $docComment = (string)$reflectionMethod->getDocComment();

            $docComment = str_replace(['/**', '*/'], '', $docComment);
            $docComment = trim($docComment);
            $docCommentArray = explode("\n", $docComment);

            $docCommentArray = array_map(function ($item) {
                $item = trim($item);

                $position = strpos($item, '*');
                if ($position === 0) {
                    $item = substr($item, 1);
                }

                return trim($item);
            }, $docCommentArray);


            foreach ($docCommentArray as $docString) {
                $isRoute = strpos($docString, '@route(') === 0;

                if (empty($docString) || !$isRoute) {
                    continue;
                }

                $url = str_replace(['@route("', '")'], '', $docString);
                $routes[$url] = [$controllerClassName, $reflectionMethod->getName()];
            }
        }

        return $routes;

    }

}