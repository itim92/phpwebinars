<?php


namespace App\Data\Shop\Order;


use App\Controller\AbstractController;
use App\Data\Product\ProductRepository;
use App\Data\User\UserModel;
use App\Model\ModelManager;

class OrderController extends AbstractController
{

    /**
     * @route("/order/list")
     */
    public function index()
    {

        return $this->render('shop/order/index.tpl', []);
    }

    /**
     * @route("/order/create")
     */
    public function create(ModelManager $manager, ProductRepository $productRepository, UserModel $user = null)
    {
        $productsForOrder = [
            [3, 2],
            [5, 1],
            [1, 2],
        ];

        $order = new OrderModel();

        foreach ($productsForOrder as $info) {
            list($productId, $amount) = $info;
            $product = $productRepository->getById($productId);

            $orderItem = new OrderItemModel($amount, $product, $order);
            $order->addItem($orderItem);
        }

        if (!is_null($user)) {
            $order->setUser($user);
        }

        $manager->save($order);
        foreach ($order->getItems() as $item) {
            $manager->save($item);
        }

        return $this->redirect("/order/list");
    }


    /**
     * @route("/order/view/{id}")
     */
    public function view(int $id)
    {

        return $this->render('shop/order/view.tpl', []);
    }


    /**
     * @route("/order/delete")
     */
    public function delete()
    {

        return $this->redirect("/order/list");
    }
}