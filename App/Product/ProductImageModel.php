<?php


namespace App\Product;


class ProductImageModel
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var ProductModel
     */
    protected $product;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $path;

    /**
     * @var int
     */
    protected $size;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return ProductImageModel
     */
    public function setId(int $id): ProductImageModel
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return ProductModel
     */
    public function getProduct(): ProductModel
    {
        return $this->product;
    }

    /**
     * @param ProductModel $product
     * @return ProductImageModel
     */
    public function setProduct(ProductModel $product): ProductImageModel
    {
        $this->product = $product;
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
     * @return ProductImageModel
     */
    public function setName(string $name): ProductImageModel
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @param string $path
     * @return ProductImageModel
     */
    public function setPath(string $path): ProductImageModel
    {
        $this->path = $path;
        return $this;
    }

    /**
     * @return int
     */
    public function getSize(): int
    {
        return $this->size;
    }

    /**
     * @param int $size
     * @return ProductImageModel
     */
    public function setSize(int $size): ProductImageModel
    {
        $this->size = $size;
        return $this;
    }


}