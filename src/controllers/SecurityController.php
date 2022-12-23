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

        if(isset($_COOKIE['user'])) {
            $url = "http://$_SERVER[HTTP_HOST]";
            header("Location: ${url}/wardrobe");
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

        if(!password_verify($password, $user->getPassword())) {
            return $this->render('login', ['messages' => ['Wrong password']]);
        }

        $cookie_name = 'user';
        $cookie_value = $email;
        setcookie($cookie_name, $cookie_value, time() + (60 * 20), "/"); //20 mins

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

        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $name = $_POST['name'];
        $surname = $_POST['surname'];
        $user = User::makeUserWithoutId($email, $password, $name, $surname);
        $userRepository->createUser($user);

        $userRegistered = $userRepository->getUser($email);
        $cookie_name = 'user';
        $cookie_value = $userRegistered->getEmail();
        setcookie($cookie_name, $cookie_value, time() + (60 * 20), "/"); //20 mins

        session_start();
        $_SESSION['id_user'] = $userRegistered->getId();
        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/wardrobe");
    }

    public function logout()
    {
        setcookie('user', $_COOKIE['user'], time() - 10, "/");
        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/index");
    }

}