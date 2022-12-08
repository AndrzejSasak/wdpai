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
            new Category($clothing['category']),
            $clothing['image'],
        );
    }

    public function getAllClothingOfUser(): array
    {
        $result = [];

        $stmt = $this->database->connect()->prepare('
            SELECT clo.*, c.name FROM clothing clo 
            JOIN category c on clo.id_category = c.id_category
            WHERE id_user = :id_user;
        ');
        $stmt->bindParam('id_user', $_SESSION['id_user'], PDO::PARAM_INT);
        $stmt->execute();

        $allClothing = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($allClothing as $clothing) {
//            var_dump($clothing['id_category']);
            $result[] = new Clothing(
                $clothing['name'],
                new Category($clothing['name']),
                $clothing['image']
            );
        }

        return $result;
    }

//    public function getRandomClothingFromCategory(Category $category): ?Clothing
//    {
//
//    }


    public function addClothing(Clothing $clothing): void
    {

        $stmt = $this->database->connect()->prepare('
            SELECT id_category FROM category WHERE name = :category_name;
        ');

        $categoryName = $clothing->getCategory()->getName();
        $stmt->bindParam('category_name',  $categoryName, PDO::PARAM_STR);
        $stmt->execute();
        $id_category = $stmt->fetch(PDO::FETCH_ASSOC);

        $date = new DateTime();
        $stmt2 = $this->database->connect()->prepare('
                INSERT INTO clothing(name, created_at, image, id_category, id_user) 
                VALUES(?, ?, ?, ?, ?)
        ');

        $id_user = $_SESSION['id_user'];

//        var_dump($id_category['id_category']);

        $stmt2->execute([
            $clothing->getName(),
            $date->format('Y-m-d'),
            $clothing->getImage(),
            $id_category['id_category'],
            $id_user
        ]);

    }

}