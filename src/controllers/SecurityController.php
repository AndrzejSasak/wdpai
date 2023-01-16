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
            $this->render('login');
        }

        if(isset($_COOKIE['user'])) {
            $url = "http://$_SERVER[HTTP_HOST]";
            header("Location: ${url}/wardrobe");
        }

        $email = $_POST["email"];
        $password = $_POST["password"];
        $user = $userRepository->getUser($email);

        if(!$user) {
            $this->render('login', ['messages' => ['User with this email not found']]);
        }

        if($user->getEmail() !== $email) {
            $this->render('login', ['messages' => ['User with this email not found']]);
        }

        if(!password_verify($password, $user->getPassword())) {
            $this->render('login', ['messages' => ['Wrong password']]);
        }

        $this->setCookie($email);
        $this->initSession($user);

        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/wardrobe");
    }

    public function register()
    {
        $userRepository = new UserRepository();

        if(!$this->isPost()) {
            $this->render('register');
        }

        $this->checkIfUserWithEmailAlreadyExists($userRepository);
        $this->createUser($userRepository);

        $userRegistered = $userRepository->getUser($_POST['email']);
        $this->setCookie($userRegistered->getEmail());

        $this->initSession($userRegistered);
        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/wardrobe");
    }

    public function logout()
    {
        setcookie('user', $_COOKIE['user'], time() - 10, "/");
        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/index");
    }

    private function setCookie($email): void
    {
        $cookie_name = 'user';
        $cookie_value = $email;
        setcookie($cookie_name, $cookie_value, time() + (60 * 20), "/"); //20 mins
    }

    private function initSession(?User $user): void
    {
        session_start();
        $_SESSION['id_user'] = $user->getId();
    }

    private function checkIfUserWithEmailAlreadyExists(UserRepository $userRepository): void
    {
        $email = $_POST["email"];
        $user = $userRepository->getUser($email);

        if ($user) {
            $this->render('register', ['messages' => ['User with this email already exists']]);
        }
    }

    private function createUser(UserRepository $userRepository): void
    {
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $name = $_POST['name'];
        $surname = $_POST['surname'];
        $user = User::makeUserWithoutId($_POST['email'], $password, $name, $surname);
        $userRepository->createUser($user);
    }

}