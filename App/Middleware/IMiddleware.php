<?php


namespace App\Middleware;


interface IMiddleware
{
    public function beforeDispatch();

    public function afterDispatch();
}