<?php

namespace App\Data\Shop\Order;

use App\Data\User\UserModel,
    App\Model\AbstractModel as AM;
use DateTime;


/**
 * Class OrderModel
 * @package App\Data\Shop\Order
 * @Model\Table("orders")
 */
class OrderModel extends AM
{

    /**
     * @var int
     * @Model\Id
     */
    protected $id = 0;

    /**
     * @var DateTime
     * @Model\TableField
     */
    protected $createdAt;

    /**
     * @var float
     * @Model\TableField
     */
    protected $totalSum = 0;

    /**
     * @var UserModel
     * @Model\TableField("user_id")
     */
    protected $user;

    /**
     * @var OrderItemModel[]
     * @Model\Relation("order_id")
     */
    protected $items;

    public function __construct()
    {
        $this->createdAt = new DateTime();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @return float
     */
    public function getTotalSum(): float
    {
        return $this->totalSum;
    }

    /**
     * @return UserModel
     */
    public function getUser(): UserModel
    {
        return $this->user;
    }

    /**
     * @return OrderItemModel[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    public function addItem(OrderItemModel $item)
    {
        $this->items[] = $item;

        $this->totalSum += $item->getTotalSum();
    }

    /**
     * @param UserModel $user
     * @return OrderModel
     */
    public function setUser(UserModel $user): OrderModel
    {
        $this->user = $user;
        return $this;
    }

}