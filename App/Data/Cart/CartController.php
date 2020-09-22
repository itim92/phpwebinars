<?php


namespace App\Data\Cart;


use App\Controller\AbstractController;
use App\Data\Product\ProductRepository;

class CartController extends AbstractController
{

    /**
     * @route("/shop/cart")
     */
    public function index(ProductRepository $productRepository)
    {
        $cart = new Cart();

        $product = $productRepository->getById(13);
        $amount = 2;

        $cart->addProduct($amount, $product);
//        $cart->addProduct($amount, $product);

//        $cart->removeProduct($product);


        return $this->render('cart/index.tpl', [
            'cart' => $cart,
        ]);
    }

    /**
     * @route("/shop/cart/add")
     */
    public function addProduct()
    {
        // /shop/cart/add?id=13


        return $this->redirect('/shop/cart');
    }
}