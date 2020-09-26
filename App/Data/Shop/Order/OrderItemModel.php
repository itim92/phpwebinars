<?php


namespace App\Data\Shop\Order;


use App\Data\Product\ProductModel;
use App\Model\AbstractModel;


/**
 * Class OrderItemModel
 * @package App\Data\Shop\Order
 * @Model\Table("order_items")
 */
class OrderItemModel extends AbstractModel
{

    /**
     * @var int
     * @Model\Id
     */
    protected $id;

    /**
     * @var int
     * @Model\TableField
     */
    protected $amount;

    /**
     * @var float
     * @Model\TableField
     */
    protected $totalSum;

    /**
     * @var ProductModel
     * @Model\TableField("product_id")
     */
    protected $product;

    /**
     * @var array
     * @Model\TableField
     */
    protected $productData;

    /**
     * @var OrderModel
     * @Model\TableField("order_id")
     */
    protected $order;

    public function __construct(int $amount, ProductModel $productModel, OrderModel $order)
    {
        $this->amount = $amount;
        $this->totalSum = $amount * $productModel->getPrice();

        $this->order = $order;
        $this->product = $productModel;
        $this->productData = [
            'name' => $productModel->getName(),
            'price' => $productModel->getPrice(),
            'article' => $productModel->getArticle(),
        ];
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    public function getTotalSum(): float
    {
        return $this->totalSum;
    }

}