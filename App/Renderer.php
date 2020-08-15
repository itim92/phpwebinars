<?php


namespace App;

use \Smarty;

class Renderer
{

    protected static $smarty;

    protected $_smarty;

    public function __construct(Smarty $smarty)
    {
        $this->_smarty = $smarty;
    }

    public static function getSmarty()
    {
        if (is_null(static::$smarty)) {
            static::init();
        }

        return static::$smarty;
    }

    protected static function init() {
        $smarty = new Smarty();

        $smarty->template_dir = APP_DIR . '/templates';
        $smarty->compile_dir = APP_DIR . '/var/compile';
        $smarty->cache_dir = APP_DIR . '/var/cache';
        $smarty->config_dir = APP_DIR . '/var/config';

        static::$smarty = $smarty;
    }

    public function render(string $template, array $data = [])
    {
        foreach ($data as $key => $value) {
            $this->_smarty->assign($key, $value);
        }

        $this->_smarty->display($template);
    }
}