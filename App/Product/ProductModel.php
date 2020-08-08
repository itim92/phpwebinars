<?php

namespace App\Product;

use App\Category\CategoryModel;

class ProductModel
{

    /**
     * @var int
     */
    protected $id = 0;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $article = '';

    /**
     * @var float
     */
    protected $price;

    /**
     * @var int
     */
    protected $amount;

    /**
     * @var string
     */
    protected $description = '';

    /**
     * @var CategoryModel
     */
    protected $category;

    /**
     * @var ProductImageModel[]
     */
    protected $images = [];

    public function __construct(string $name, float $price, int $amount)
    {
        $this->setName($name);
        $this->setPrice($price);
        $this->setAmount($amount);
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return $this
     */
    public function setId(int $id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return ProductModel
     */
    public function setName(string $name): ProductModel
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getArticle(): string
    {
        return $this->article;
    }

    /**
     * @param string $article
     * @return ProductModel
     */
    public function setArticle(string $article): ProductModel
    {
        $this->article = $article;
        return $this;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @param float $price
     * @return ProductModel
     */
    public function setPrice(float $price): ProductModel
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * @param int $amount
     * @return ProductModel
     */
    public function setAmount(int $amount): ProductModel
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return ProductModel
     */
    public function setDescription(string $description): ProductModel
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return CategoryModel|null
     */
    public function getCategory(): ?CategoryModel
    {
        return $this->category;
    }

    /**
     * @param CategoryModel $category
     * @return ProductModel
     */
    public function setCategory(CategoryModel $category): ProductModel
    {
        $this->category = $category;
        return $this;
    }

    /**
     * @return ProductImageModel[]
     */
    public function getImages(): array
    {
        return $this->images;
    }

    /**
     * @param ProductImageModel[] $images
     * @return ProductModel
     */
    public function setImages(array $images): ProductModel
    {
        $this->images = $images;
        return $this;
    }

    public function addImage(ProductImageModel $productImage): ProductModel {
        $this->images[] = $productImage;
        return $this;
    }


}