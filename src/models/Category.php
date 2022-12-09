<?php

class Category
{
    private $id;

    public static array $VALUES = [
        'Shirts',
        'Jackets',
        'Pants',
        'Socks',
        'Shoes',
        'Accessories'
    ];

    public function getId()
    {
        return $this->id;
    }

    public function setId($id): void
    {
        $this->id = $id;
    }
    private $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }


}