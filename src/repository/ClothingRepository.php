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
        $stmt->bindParam('email', $email, PDO::PARAM_INT);
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

    public function addClothing(Clothing $clothing): void
    {
        $date = new DateTime();
        $stmt = $this->database->connect()->prepare('
                INSERT INTO clothing(name, category, created_at, image, id_user) 
                VALUES(?, ?, ?, ?, ?)
        ');

//        $id_user = 1; //TODO: get user id from current session
        $id_user = $_SESSION['id_user'];
        var_dump($id_user);

        $stmt->execute([
            $clothing->getName(),
            $clothing->getCategory(),
            $date->format('Y-m-d'),
            $clothing->getImage(),
            $id_user
        ]);

    }

}