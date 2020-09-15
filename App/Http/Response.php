<?php

namespace App\Http;

/**
 * Class Response
 * @package App\Http
 */
class Response
{

    /**
     * @var string
     */
    private $body = '';

    private $redirectUrl = null;

    public function redirect()
    {
        header('Location: ' . $this->getRedirectUrl());
        exit;
    }

    public function __toString()
    {
        if (!is_null($this->getRedirectUrl())) {
            $this->redirect();
        }

        return $this->getBody();
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * @param string $body
     */
    public function setBody(string $body): self
    {
        $this->body = $body;

        return $this;
    }

    /**
     * @param null $redirectUrl
     * @return Response
     */
    public function setRedirectUrl($redirectUrl)
    {
        $this->redirectUrl = $redirectUrl;
        return $this;
    }

    /**
     * @return null
     */
    public function getRedirectUrl()
    {
        return $this->redirectUrl;
    }
}