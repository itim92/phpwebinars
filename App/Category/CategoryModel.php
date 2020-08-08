<?php

namespace App\Category;

class CategoryModel
{

    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;


    public function __construct(string $name)
    {
        $this->setName($name);
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return CategoryModel
     */
    public function setId(int $id): CategoryModel
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
     * @return CategoryModel
     */
    public function setName(string $name): CategoryModel
    {
        $this->name = $name;
        return $this;
    }



}