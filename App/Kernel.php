<?php


namespace App;


use App\Config\Config;
use App\DI\Container;
use App\Middleware\IMiddleware;
use App\Router\Dispatcher;
use App\Router\Exception\ControllerDoesNotExistException;
use App\Router\Exception\ExpectToRecieveResponseObjectException;
use App\Router\Exception\MethodDoesNotExistException;
use App\Router\Exception\NotFoundException;
use Smarty;

class Kernel
{

    /**
     * @var DI\Container
     */
    private $di;

    public function __construct()
    {

        $di = new DI\Container();
        $this->di = $di;
        $di->addOneMapping(Container::class, $di);

        $di->singletone(Config::class, function() {
            $configDir = 'config';
            return Config::create($configDir);
        });

        /**
         * @var $config Config
         */
        $config = $di->get(Config::class);

        $di->singletone(Smarty::class, function($di) {
            $smarty = new Smarty();
            $config = $di->get(Config::class);

            $smarty->template_dir = $config->renderer->templateDir;
            $smarty->compile_dir = $config->renderer->compileDir;

            return $smarty;
        });

        foreach ($config->di->singletones as $classname) {
            $di->singletone($classname);
        }

    }

    public function run()
    {
        try {
            $config = $this->di->get(Config::class);

            foreach ($config->di->middlewares as $classname) {
                $middleware = $this->di->get($classname);

                if ($middleware instanceof IMiddleware) {
                    $middleware->beforeDispatch();
                }
            }

            $response = (new Dispatcher($this->di))->dispatch();


            foreach ($config->di->middlewares as $classname) {
                $middleware = $this->di->get($classname);

                if ($middleware instanceof IMiddleware) {
                    $middleware->afterDispatch();
                }
            }

            echo $response;
        } catch (NotFoundException $e) {
            //404
            echo "404";
        } catch (ControllerDoesNotExistException | MethodDoesNotExistException $e) {
            //500
            echo "500 - controller / route";
        } catch (ExpectToRecieveResponseObjectException $e) {
            //500
            echo "500 - response";
        } catch (\ReflectionException $e) {
            //500
            echo "500 - reflection";

            echo "<pre>";
            echo $e;
            echo "</pre>";
        }
    }
}