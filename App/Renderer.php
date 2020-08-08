<?php


namespace App;

class Renderer
{

    protected static $smarty;

    public static function getSmarty()
    {
        if (is_null(static::$smarty)) {
            static::init();
        }

        return static::$smarty;
    }

    protected static function init() {
        $smarty = new \Smarty();

        $smarty->template_dir = APP_DIR . '/templates';
        $smarty->compile_dir = APP_DIR . '/var/compile';
        $smarty->cache_dir = APP_DIR . '/var/cache';
        $smarty->config_dir = APP_DIR . '/var/config';

        static::$smarty = $smarty;
    }
}