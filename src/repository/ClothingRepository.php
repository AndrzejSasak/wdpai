<?php
session_start();

require_once 'Repository.php';
require_once __DIR__.'/../models/Clothing.php';
require_once __DIR__.'/../models/Outfit.php';

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
            SELECT clo.*, c.category_name FROM clothing clo 
            JOIN category c on clo.id_category = c.id_category
            WHERE id_user = :id_user;
        ');
        $stmt->bindParam('id_user', $_SESSION['id_user'], PDO::PARAM_INT);
        $stmt->execute();

        $allClothing = $stmt->fetchAll(PDO::FETCH_ASSOC);
//        var_dump($allClothing);

        foreach ($allClothing as $clothing) {
            $result[] = new Clothing(
                $clothing['name'],
                new Category($clothing['category_name']),
                $clothing['image']
            );
        }

        return $result;
    }

    public function addClothing(Clothing $clothing): void
    {

        $stmt = $this->database->connect()->prepare('
            SELECT id_category FROM category WHERE category_name = :category_name;
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

        $stmt2->execute([
            $clothing->getName(),
            $date->format('Y-m-d'),
            $clothing->getImage(),
            $id_category['id_category'],
            $id_user
        ]);

    }

    public function getAllCategoriesOfClothing(): array
    {
        $result = [];

        $stmt = $this->database->connect()->prepare('
            SELECT * FROM category;
        ');

        $stmt->execute();
        $allCategories = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($allCategories as $category) {
            $result[] = new Category($category['category_name']);
        }

        return $result;
    }

    public function getRandomizedOutfit(): ?Outfit
    {
        $outfit = new Outfit();
        $outfit->setIdUser($_SESSION['id_user']);

        if(!$this->userHasClothesInEachCategory()) {
            return null;
        }

        $allClothing = $this->getAllClothingOfUser();
        $allCategories = $this->getAllCategoriesOfClothing();

        foreach($allCategories as $category) {
            //get a random clothing with current category
            $allClothingTemp = $allClothing;
            $randomClothing = $this->getRandomClothingOfCategory($allClothingTemp, $category);
            //add to outfit
            $outfit->addClothingToOutfit($randomClothing);
        }

//        var_dump($outfit);


        return $outfit;
    }

    private function userHasClothesInEachCategory(): bool
    {
        $allClothing = $this->getAllClothingOfUser();
        $allCategories = $this->getAllCategoriesOfClothing();

        foreach ($allCategories as $category) {
            $hasClothesInCurrentCategory = false;
            foreach($allClothing as $clothing) {
                if($clothing->getCategory()->getName() === $category->getName()) {
                    $hasClothesInCurrentCategory = true;
                    break;
                }
            }
            if(!$hasClothesInCurrentCategory) {
                return false;
            }
        }

        return true;
    }

    private function getRandomClothingOfCategory(array $allClothing, $category): ?Clothing
    {
        $allClothingOfCurrentCategory = array_filter($allClothing, static function (Clothing $clothing) use ($category) {
            return $clothing->getCategory()->getName() === $category->getName();
        });

        $allClothingOfCurrentCategoryValues = array_values($allClothingOfCurrentCategory);
        $randomClothingIndex = rand(0, sizeof($allClothingOfCurrentCategory) - 1);
        $randomClothing = $allClothingOfCurrentCategoryValues[$randomClothingIndex];
//        var_dump($randomClothing);
        return $randomClothing;
    }


}