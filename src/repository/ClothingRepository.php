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

        $clothing = new Clothing(
            $clothing['name'],
            new Category($clothing['category']),
            $clothing['image'],
        );
        $clothing->setId($id);
        return $clothing;
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
            $newClothing = new Clothing(
                $clothing['name'],
                new Category($clothing['category_name']),
                $clothing['image']
            );
            $newClothing->setId($clothing['id_clothing']);
            $result[] = $newClothing;
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

        var_dump($id_category);
        var_dump($id_category['id_category']);

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
            $newCategory = new Category($category['category_name']);
            $newCategory->setId($category['id_category']);
            $result[] = $newCategory;
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

    public function addOutfitToFavourites(Outfit $outfit): void
    {
        //add outfit to outfit table
        $pdo = $this->database->connect();

        $pdo->beginTransaction();

        list($idUser, $id_outfit, $id_clothing) = $this->addOutfitToOutfitTable($pdo, $outfit);

        //add to favourites
        $stmt3 = $pdo->prepare('
            INSERT INTO favourite_outfit(id_outfit, id_user) VALUES (:id_outfit, :id_user)
        ');
        $stmt3->bindParam('id_outfit', $id_outfit, PDO::PARAM_INT);
        $stmt3->bindParam('id_user', $idUser, PDO::PARAM_INT);
        $stmt3->execute();

        $pdo->commit();
    }

    public function getFavouriteOutfitsOfUser(): array
    {

        $stmt1 = $this->database->connect()->prepare('
            SELECT DISTINCT id_outfit FROM favourite_outfit WHERE id_user = :id_user;
        ');
        $stmt1->bindParam('id_user', $_SESSION['id_user'], PDO::PARAM_INT);
        $stmt1->execute();
        $outfitIds = $stmt1->fetchAll(PDO::FETCH_ASSOC);

        $stmt = $this->database->connect()->prepare('
            SELECT o.id_outfit id_outfit,
                   o.name outfit_name,
                   o.id_user id_user,
                   c.id_clothing id_clothing,
                   c.name clothing_name,
                   c.image image,
                   c2.category_name category_name
            FROM favourite_outfit 
                JOIN outfit o on favourite_outfit.id_outfit = o.id_outfit
                JOIN clothing_outfit co on o.id_outfit = co.id_outfit
                JOIN clothing c on co.id_clothing = c.id_clothing
                JOIN category c2 on c.id_category = c2.id_category
            WHERE o.id_user = :id_user
            ORDER BY id_outfit
        ');
        $stmt->bindParam('id_user', $_SESSION['id_user'], PDO::PARAM_INT);

        $stmt->execute();
        $allClothingPiecesFromStmt = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $resultOutfits = [];
        foreach($outfitIds as $outfitId) {
            $outfit = new Outfit();
            $outfit->setId($outfitId['id_outfit']);
            $outfit->setIdUser($_SESSION['id_user']);
            $resultOutfits[] = $outfit;
        }

        foreach ($allClothingPiecesFromStmt as $clothingPiece) {
            $newClothingPiece = new Clothing(
                $clothingPiece['clothing_name'],
                new Category($clothingPiece['category_name']),
                $clothingPiece['image'],
            );
            $newClothingPiece->setId($clothingPiece['id_clothing']);
            $newClothingPiece->setOutfitId($clothingPiece['id_outfit']);

            foreach ($resultOutfits as $outfit) {
                if($outfit->getId() === $newClothingPiece->getOutfitId()) {
                    $outfit->addClothingToOutfit($newClothingPiece);
                }
            }
        }

//        var_dump($resultOutfits);
        return $resultOutfits;
    }

    public function getAllOutfitsOfUser(): array
    {
        $stmt1 = $this->database->connect()->prepare('
            SELECT id_outfit FROM outfit WHERE id_user = :id_user;
        ');
        $stmt1->bindParam('id_user', $_SESSION['id_user'], PDO::PARAM_INT);
        $stmt1->execute();
        $outfitIds = $stmt1->fetchAll(PDO::FETCH_ASSOC);

        $stmt = $this->database->connect()->prepare('
            SELECT outfit.id_outfit id_outfit,
               outfit.name outfit_name,
               outfit.id_user id_user,
               c.id_clothing id_clothing,
               c.name clothing_name,
               c.image image,
               c2.category_name category_name
            FROM outfit
                     JOIN clothing_outfit co on outfit.id_outfit = co.id_outfit
                     JOIN clothing c on co.id_clothing = c.id_clothing
                     JOIN category c2 on c.id_category = c2.id_category
            WHERE outfit.id_user = :id_user
            ORDER BY id_outfit
        ');
        $stmt->bindParam('id_user', $_SESSION['id_user'], PDO::PARAM_INT);

        $stmt->execute();
        $allClothingPiecesFromStmt = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $resultOutfits = [];
        foreach($outfitIds as $outfitId) {
            $outfit = new Outfit();
            $outfit->setId($outfitId['id_outfit']);
            $outfit->setIdUser($_SESSION['id_user']);
            $resultOutfits[] = $outfit;
        }

        foreach ($allClothingPiecesFromStmt as $clothingPiece) {
            $newClothingPiece = new Clothing(
                $clothingPiece['clothing_name'],
                new Category($clothingPiece['category_name']),
                $clothingPiece['image'],
            );
            $newClothingPiece->setId($clothingPiece['id_clothing']);
            $newClothingPiece->setOutfitId($clothingPiece['id_outfit']);

            foreach ($resultOutfits as $outfit) {
                if($outfit->getId() === $newClothingPiece->getOutfitId()) {
//                    var_dump($newClothingPiece->getOutfitId());
                    $outfit->addClothingToOutfit($newClothingPiece);
                }
            }
        }

//        var_dump($resultOutfits);
        return $resultOutfits;
    }

    public function saveToAllOutfits($outfit): void
    {
        $pdo = $this->database->connect();
        $pdo->beginTransaction();
        $this->addOutfitToOutfitTable($pdo, $outfit);
        $pdo->commit();
    }

    public function addOutfitToOutfitTable(?PDO $pdo, Outfit $outfit): array
    {
        $stmt = $pdo->prepare('
            INSERT INTO outfit(id_user) VALUES (:id_user);
        ');
        $idUser = $outfit->getIdUser();
        $stmt->bindParam('id_user', $idUser, PDO::PARAM_INT);

        $stmt->execute();

        $id_outfit = $pdo->lastInsertId();

        foreach ($outfit->getClothingPieces() as $clothingPiece) {
            $stmt2 = $pdo->prepare('
                INSERT INTO clothing_outfit(id_clothing, id_outfit) VALUES (:id_clothing, :id_outfit)
            ');
            $id_clothing = $clothingPiece->getId();
//            var_dump($id_clothing);
            $stmt2->bindParam('id_clothing', $id_clothing, PDO::PARAM_INT);
            $stmt2->bindParam('id_outfit', $id_outfit, PDO::PARAM_INT);

            $stmt2->execute();
        }
        return array($idUser, $id_outfit, $id_clothing);
    }

    public function deleteClothing($clothingToDelete)
    {
        $pdo = $this->database->connect();
        $pdo->beginTransaction();

        foreach($clothingToDelete as $item) {
            $itemExploded = explode("/", $item);
            $img_name = end($itemExploded);

            $stmt = $pdo->prepare('
                DELETE FROM outfit o 
                       WHERE id_outfit = (SELECT DISTINCT id_outfit FROM clothing_outfit co
                        JOIN clothing c on c.id_clothing = co.id_clothing WHERE c.image = :img_name)  
            ');
            $stmt->bindParam('img_name', $img_name, PDO::PARAM_STR);
            $stmt->execute();

            $stmt = $pdo->prepare('
                DELETE FROM clothing_outfit co USING clothing c WHERE c.image = :img_name
            ');
            $stmt->bindParam('img_name', $img_name, PDO::PARAM_STR);
            $stmt->execute();

            $stmt = $pdo->prepare('
                DELETE FROM clothing WHERE clothing.image = :img_name
            ');
            $stmt->bindParam('img_name', $img_name, PDO::PARAM_STR);
            $stmt->execute();

        }

        $pdo->commit();
    }


}