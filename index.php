<?php

require 'Router.php';

ini_set('memory_limit', '-1');
//phpinfo();

$path = trim($_SERVER['REQUEST_URI'], '/');
$path = parse_url($path, PHP_URL_PATH);

Router::get('', 'DefaultController');
Router::get('index', 'DefaultController');
Router::get('registerUser', 'DefaultController');
Router::get('wardrobe', 'DefaultController');
Router::get('randomizer', 'DefaultController');
Router::get('picker', 'DefaultController');
Router::get('favourites', 'DefaultController');
Router::post('login', 'SecurityController');
Router::post('register', 'SecurityController');
Router::post('addClothing', 'ClothingController');
Router::run($path);