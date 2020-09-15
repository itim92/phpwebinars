<?php


namespace App\Router;


use App\Http\Request;

class Route
{

    /**
     * @var string|null
     */
    private $url;

    /**
     * @var string|null
     */
    private $controller = null;

    /**
     * @var string|null
     */
    private $method = null;

    /**
     * @var array
     */
    private $params = [];

    public function __construct(Request $request)
    {
        $this->url = $request->getUrl();
    }

    /**
     * @return string|null
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * @param string|null $url
     * @return Route
     */
    public function setUrl(?string $url): Route
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getController(): ?string
    {
        return $this->controller;
    }

    /**
     * @param string|null $controller
     * @return Route
     */
    public function setController(?string $controller): Route
    {
        $this->controller = $controller;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getMethod(): ?string
    {
        return $this->method;
    }

    /**
     * @param string|null $method
     * @return Route
     */
    public function setMethod(?string $method): Route
    {
        $this->method = $method;
        return $this;
    }

    public function setParam(string $key, $value)
    {
        $this->params[$key] = $value;

        return $this;
    }

    public function getParam(string $key)
    {
        return $this->params[$key] ?? null;
    }

    public function clearParams() {
        $this->params = [];

        return $this;
    }


}