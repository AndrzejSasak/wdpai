<?php
session_start();

require_once 'Repository.php';
require_once __DIR__.'/../models/Clothing.php';

class ClothingRepository extends Repository
{

    public function getClothing(int $id): ?Clothing
    {
        $stmt = $this->database->connect()->prepare(
            'SELECT * FROM clothing WHERE id_clothing = :id'
        );
        $stmt->bindParam('id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $clothing = $stmt->fetch(PDO::FETCH_ASSOC);

        if(!$clothing) {
            return null;
        }

        return new Clothing(
            $clothing['name'],
            $clothing['category'],
            $clothing['image'],
        );
    }

    public function getAllClothingOfUser(): array
    {
        $result = [];

        $stmt = $this->database->connect()->prepare('
            SELECT * FROM clothing WHERE id_user = :id_user
        ');
        $stmt->bindParam('id_user', $_SESSION['id_user'], PDO::PARAM_INT);
        $stmt->execute();

        $allClothing = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($allClothing as $clothing) {
            $result[] = new Clothing(
                $clothing['name'],
                $clothing['category'],
                $clothing['image']
            );
        }

        return $result;
    }


    public function addClothing(Clothing $clothing): void
    {
        $date = new DateTime();
        $stmt = $this->database->connect()->prepare('
                INSERT INTO clothing(name, category, created_at, image, id_user) 
                VALUES(?, ?, ?, ?, ?)
        ');


        $id_user = $_SESSION['id_user'];

        $stmt->execute([
            $clothing->getName(),
            $clothing->getCategory(),
            $date->format('Y-m-d'),
            $clothing->getImage(),
            $id_user
        ]);

    }

}