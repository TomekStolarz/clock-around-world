<?php

require 'Routing.php';

$path = trim($_SERVER['REQUEST_URI'], '/');
$path = parse_url($path, PHP_URL_PATH);

Routing::get('start', 'DefaultController');
Routing::get('register', 'DefaultController');
Routing::get('dashboard', 'CityController');
Routing::get('adminpanel', 'UserController');
Routing::get('search', 'DefaultController');
Routing::get('citydetail', 'CityController');
Routing::get('settings', 'DefaultController');
Routing::get('follow', 'CityController');
Routing::get('unfollow', 'CityController');
Routing::get('allCities', 'CityController');

Routing::post('login', 'SecurityController');
Routing::post('register', 'RegisterController');
Routing::post('searchCities', 'CityController');
Routing::post('isFollowed', 'CityController');
Routing::post('emailChange', 'UserController');
Routing::post('passwordChange', 'UserController');
Routing::post('userDelete', 'UserController');
Routing::post('userHistory', 'UserController');

Routing::run($path);

?>