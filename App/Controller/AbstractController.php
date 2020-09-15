<?php

namespace App\Controller;

use App\Http\Response;
use App\Renderer\Renderer;
use App\Router\Route;

abstract class AbstractController
{

    /**
     * @var Renderer
     * @onInit(App\Renderer\Renderer)
     */
    protected $renderer;

    /**
     * @var Route
     * @onInit(App\Router\Route)
     */
    protected $route;

    /**
     * @var Response
     * @onInit(App\Http\Response)
     */
    protected $response;

    public function render(string $template, array $data = [])
    {
        $body = $this->renderer->render($template, $data);
        $this->response->setBody($body);

        return $this->response;
    }

    public function redirect(string $url) {
        return $this->response->setRedirectUrl($url);
    }
}