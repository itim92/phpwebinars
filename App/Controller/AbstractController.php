<?php

namespace App\Controller;

use App\Renderer;
use App\Router\Route;

abstract class AbstractController
{

    /**
     * @var Renderer
     * @onInit(App\Renderer)
     */
    protected $renderer;

    /**
     * @var Route
     * @onInit(App\Router\Route)
     */
    protected $route;

    public function render(string $template, array $data = [])
    {
//        $smarty = Renderer::getSmarty();
//
//        foreach ($data as $key => $value) {
//            $smarty->assign($key, $value);
//        }
//
//        return $smarty->display($template);
        $this->renderer->render($template, $data);
    }

    public function redirect(string $url) {

    }
}