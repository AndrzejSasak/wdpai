<?php

require 'Router.php';

$path = trim($_SERVER['REQUEST_URI'], '/');
$path = parse_url($path, PHP_URL_PATH);

Router::get('index', 'DefaultController');
Router::get('register', 'DefaultController');
Router::get('wardrobe', 'DefaultController');
Router::get('randomizer', 'DefaultController');
Router::get('picker', 'DefaultController');
Router::get('favourites', 'DefaultController');
Router::post('login', 'SecurityController');
Router::post('addClothing', 'ClothingController');
Router::run($path);