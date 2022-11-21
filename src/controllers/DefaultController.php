<?php

require_once 'AppController.php';

class DefaultController extends AppController {
    
    public function index() {
        $this->render('login');
    }

    public function register() {
        $this->render('register');
    }

    public function wardrobe() {
        $this->render('wardrobe');
    }

    public function randomizer() {
        $this->render('randomizer');
    }

    public function picker() {
        $this->render('picker');
    }

    public function favourites() {
        $this->render('favourites');
    }

    

}