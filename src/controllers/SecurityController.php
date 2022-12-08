<?php

require_once 'AppController.php';
require_once __DIR__.'/../models/User.php';
require_once __DIR__.'/../repository/UserRepository.php';

class SecurityController extends AppController
{

    public function login()
    {
        $userRepository = new UserRepository();

        if(!$this->isPost()) {
            return $this->login('login');
        }

        $email = $_POST["email"];
        $password = $_POST["password"];
        $user = $userRepository->getUser($email);

        if(!$user) {
            return $this->render('login', ['messages' => ['User with this email not found']]);
        }

        if($user->getEmail() !== $email) {
            return $this->render('login', ['messages' => ['User with this email not found']]);
        }

        if($user->getPassword() !== $password) {
            return $this->render('login', ['messages' => ['Wrong password']]);
        }

//        return $this->render('wardrobe');
        session_start();
        $_SESSION['id_user'] = $user->getId();
        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/wardrobe");
    }

    public function register()
    {
        $userRepository = new UserRepository();

        if(!$this->isPost()) {
            return $this->render('register');
        }

        $email = $_POST["email"];
        $user = $userRepository->getUser($email);

        if($user) {
            return $this->render('register', ['messages' => ['User with this email already exists']]);
        }

        $password = $_POST['password'];
        $name = $_POST['name'];
        $surname = $_POST['surname'];
        $user = User::makeUserWithoutId($email, $password, $name, $surname);
        $userRepository->createUser($user);

        $userRegistered = $userRepository->getUser($email);
        session_start();
        $_SESSION['id_user'] = $userRegistered->getId();
        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/wardrobe");
    }


}