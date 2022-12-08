<?php

require_once 'User.php';

class Outfit
{
    private string $name;
    private int $id_user;
    private array $clothingPieces;

    public function getIdUser(): int
    {
        return $this->id_user;
    }

    public function setIdUser(int $id_user): void
    {
        $this->id_user = $id_user;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getClothingPieces(): array
    {
        return $this->clothingPieces;
    }

    public function setClothingPieces(array $clothingPieces): void
    {
        $this->clothingPieces = $clothingPieces;
    }

    public function addClothingToOutfit(Clothing $clothing): void
    {
        $this->clothingPieces[] = $clothing;
    }





}