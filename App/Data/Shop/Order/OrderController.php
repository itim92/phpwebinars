<?php


namespace App\Data\Shop\Order;


use App\Controller\AbstractController;
use App\Data\Product\ProductRepositoryOld;
use App\Data\User\UserModel;
use App\Model\AbstractModel;
use App\Model\ModelAnalyzer;
use App\Model\ModelManager;
use App\Model\Proxy\ProxyModelManager;
use App\Utils\ReflectionUtil;

class OrderController extends AbstractController
{

    /**
     * @route("/order/list")
     */
    public function index(OrderRepository $orderRepository)
    {

        return $this->render('shop/order/index.tpl', [
            'orders' => $orderRepository->findAll(),
        ]);
    }

    /**
     * @route("/order/create")
     */
    public function create(ModelManager $manager, ProductRepositoryOld $productRepository, UserModel $user = null)
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
     * @route("/order/update")
     */
    public function update(OrderItemRepository $orderItemRepository)
    {

        /**
         * @var $orderItem OrderItemModel
         */
        $orderItem = $orderItemRepository->find(2);

        $orderItems = $orderItem->getOrder()->getItems();
        $orderItems = $orderItems[1]->getOrder()->getItems();
        echo "<pre>"; var_dump("App\Data\Shop\Order\OrderController.php : 64", $orderItems); echo "</pre>";

        exit;


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