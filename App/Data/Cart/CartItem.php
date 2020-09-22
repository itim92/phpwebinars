<?php


namespace App\Data\Cart;


use App\Data\Product\ProductModel;

class CartItem
{

    /**
     * @var int
     */
    private $amount;

    /**
     * @var ProductModel
     */
    private $productModel;

    public function __construct(int $amount, ProductModel $productModel)
    {
        $this->amount = $amount;
        $this->productModel = $productModel;
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    public function getTotal(): float
    {
        return $this->amount * $this->getProductModel()->getPrice();
    }

    /**
     * @param int $amount
     * @return $this
     */
    public function setAmount(int $amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * @return ProductModel
     */
    public function getProductModel(): ProductModel
    {
        return $this->productModel;
    }

}