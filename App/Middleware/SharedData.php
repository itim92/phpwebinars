<?php


namespace App\Middleware;


use App\Data\User\UserModel;
use App\DI\Container;
use App\Renderer\Renderer;

class SharedData implements IMiddleware
{

    /**
     * @var Container
     */
    private $di;

    public function __construct(Container $di)
    {

        $this->di = $di;
    }

    public function run()
    {
        /**
         * @var $renderer Renderer
         */
        $renderer = $this->di->get(Renderer::class);

        $user = $this->di->getOrNull(UserModel::class);
        if (!is_null($user)) {
            $renderer->addSharedData('user', $user);
        }
    }
}