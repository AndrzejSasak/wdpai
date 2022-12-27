<?php

session_start();

require_once 'Repository.php';
require_once __DIR__.'/../models/User.php';

class UserRepository extends Repository
{

    public function getUser(string $email): ?User
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM public._user u 
            JOIN public.user_details ud ON u.id_user = ud.id_user_details WHERE u.email = :email;
        ');
        $stmt->bindParam('email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if(!$user) {
            return null;
        }

        return User::makeUserWithId(
            $user['id_user'],
            $user['email'],
            $user['password'],
            $user['name'],
            $user['surname']
        );
    }

    public function createUser(User $user): void
    {

        $stmt = $this->database->connect()->prepare('
            WITH IDENTITY AS ( INSERT INTO user_details(name, surname) VALUES(?, ?) RETURNING id_user_details )
            INSERT INTO _user (email, password, enabled, salt, created_at, id_user_details, id_role)
            VALUES (?, ?, True, \'123\', NOW(), (SELECT id_user_details FROM IDENTITY), 2)
        ');

        $stmt->execute([
            $user->getName(),
            $user->getSurname(),
            $user->getEmail(),
            $user->getPassword()
        ]);
    }

}