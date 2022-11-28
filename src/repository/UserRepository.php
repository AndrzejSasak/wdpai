<?php
session_start();

require_once 'Repository.php';
require_once __DIR__.'/../models/User.php';

class UserRepository extends Repository
{

    public function getUser(string $email): ?User
    {
        $stmt = $this->database->connect()->prepare(
        'SELECT * FROM public._user u JOIN public.user_details ud ON u.id_user = ud.id_user_details WHERE u.email = :email;'
        );
        $stmt->bindParam('email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if(!$user) {
            return null;
        }

        return new User(
            $user['id_user'],
            $user['email'],
            $user['password'],
            $user['name'],
            $user['surname'],
        );
    }

}