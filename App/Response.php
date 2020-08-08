<?php

namespace App;

class Response
{

    public function redirect(string $url = '/')
    {
        header('Location: ' . $url);
        exit;
    }
}