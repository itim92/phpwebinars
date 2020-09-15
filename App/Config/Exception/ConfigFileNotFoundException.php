<?php


namespace App\Config\Exception;


use App\Exception\AbstractAppException;
use Throwable;

class ConfigFileNotFoundException extends AbstractAppException
{
    public function __construct($dirname = "", $code = 500, Throwable $previous = null)
    {
        $message = "Config file '$dirname' not found";
        parent::__construct($message, $code, $previous);
    }

}