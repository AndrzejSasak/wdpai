<?php

require_once 'AppController.php';

class DefaultController extends AppController {
    
    public function index() {
        $this->render('login');
    }

    public function registerUser() {
        $this->render('register');
    }

    public function randomizer() {
        $this->render('randomizer');
    }

    public function picker() {
        $this->render('picker');
    }

    public function outfits() {
        $this->render('outfits');
    }

}