<?php

require_once 'AppController.php';

class DefaultController extends AppController {
    
    public function index() {
        $this->render('login');
    }

    public function registerUser() {
        $this->render('register');
    }

    public function wardrobe() {
//        session_start();
//        $this->checkUserIsLoggedIn();
        $this->render('wardrobe');
    }

    public function randomizer() {
//        session_start();
//        $this->checkUserIsLoggedIn();
        $this->render('randomizer');
    }

    public function picker() {
//        session_start();
//        $this->checkUserIsLoggedIn();
        $this->render('picker');
    }

    public function favourites() {
//        session_start();
//        $this->checkUserIsLoggedIn();
        $this->render('favourites');
    }

    private function checkUserIsLoggedIn() {
        $this->checkUserIsLoggedIn();
        if(!$_SESSION['id_user'] == null) {
            $url = "http://$_SERVER[HTTP_HOST]";
            header("Location: {$url}/index");
//            die();
        }
    }

}