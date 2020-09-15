<?php


namespace App\Config;


class NullConfig
{
    public function __get(string $key)
    {
        return $this;
    }
}