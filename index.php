<?php

require 'Routing.php';

$path = trim($_SERVER['REQUEST_URI'], '/');
$path = parse_url($path, PHP_URL_PATH);

Routing::get('index', 'DefaultController');
Routing::get('register', 'DefaultController');
Routing::get('wardrobe', 'DefaultController');
Routing::get('randomizer', 'DefaultController');
Routing::get('picker', 'DefaultController');
Routing::get('favourites', 'DefaultController');
Routing::post('login', 'SecurityController');
Routing::run($path);