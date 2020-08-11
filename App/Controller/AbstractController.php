<?php

namespace App\Controller;

use App\Renderer;
use App\Router\Route;

abstract class AbstractController
{

    /**
     * @var Renderer
     */
    protected $renderer;

    /**
     * @var Route
     */
    protected $route;

    public function render(string $template, array $data = [])
    {
        $smarty = Renderer::getSmarty();

        foreach ($data as $key => $value) {
            $smarty->assign($key, $value);
        }

        return $smarty->display($template);
    }

    public function redirect(string $url) {

    }
}