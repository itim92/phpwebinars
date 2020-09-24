<?php


namespace App\Data\Cart;


use App\Controller\AbstractController;
use App\Data\Product\ProductRepository;
use App\Http\Response;

class CartController extends AbstractController
{

    /**
     * @route("/shop/cart")
     */
    public function index(Cart $cart, ProductRepository $productRepository)
    {
//        $cart = new Cart();

//        $product = $productRepository->getById(13);
//        $amount = 2;
//
//        $cart->addProduct($amount, $product);
//        $cart->addProduct($amount, $product);

//        $cart->removeProduct($product);

//        echo "<pre>";
//        var_dump($cart);
//        echo "</pre>";




        return $this->render('cart/index.tpl', [
            'cart' => $cart,
        ]);
    }

    /**
     * @route("/shop/cart/add")
     *
     * @param Cart $cart
     * @param ProductRepository $productRepository
     * @return Response
     */
    public function addProduct(Cart $cart, ProductRepository $productRepository)
    {
        // /shop/cart/add?id=13

        $id = $this->request->getIntFromGet('id');
        $amount = $this->request->getIntFromGet('amount', 1);

        if ($id) {
            $product = $productRepository->getById($id);
            $cart->addProduct($amount, $product);

//            $_SESSION['cart'] = serialize($cart);
        }

        return $this->redirect('/shop/cart');
    }


    /**
     * @route("/shop/cart/remove")
     *
     * @param Cart $cart
     * @param ProductRepository $productRepository
     * @return Response
     */
    public function removeProduct(Cart $cart, ProductRepository  $productRepository)
    {
        $id = $this->request->getIntFromGet('id');

        if ($id) {
            $product = $productRepository->getById($id);
            $cart->removeProduct($product);

//            $_SESSION['cart'] = serialize($cart);
        }

        return $this->redirect('/shop/cart');
    }
}