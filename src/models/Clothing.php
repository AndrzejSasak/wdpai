<?php

require_once 'Category.php';

class Clothing
{

    private $name;
    private $category;
    private $image;

    public function __construct(string $name, Category $category, string $image)
    {
        $this->name = $name;
        $this->category = $category;
        $this->image = $image;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function getCategory(): Category
    {
        return $this->category;
    }

    public function setCategory(Category $category)
    {
        $this->category = $category;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function setImage(string $image)
    {
        $this->image = $image;
    }




}