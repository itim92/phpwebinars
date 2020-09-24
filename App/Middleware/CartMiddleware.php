<?php


namespace App\Middleware;


use App\Data\Cart\Cart;
use App\DI\Container;

class CartMiddleware implements IMiddleware
{

    /**
     * @var Container
     */
    private $di;

    /**
     * @var Cart
     */
    private $cart;

    public function __construct(Container $di)
    {
        $this->di = $di;


        $cartSerializedData = $_SESSION['cart'] ?? null;
        $cart = null;

        if (!is_null($cartSerializedData)) {
            $cart = unserialize($cartSerializedData);
        }

        if (!($cart instanceof Cart)) {
            $cart = new Cart();
        }


        $di->addOneMapping(Cart::class, $cart);
        $this->cart = $cart;
    }
    
    
    public function beforeDispatch()
    {

    }

    public function afterDispatch()
    {
        $_SESSION['cart'] = serialize($this->cart);
    }


}