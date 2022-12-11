<?php

require 'Routing.php';

$path = trim($_SERVER['REQUEST_URI'], '/');
$path = parse_url($path, PHP_URL_PATH);

Routing::get('start', 'DefaultController');
Routing::get('register', 'DefaultController');
Routing::get('dashboard', 'DefaultController');
Routing::get('adminpanel', 'DefaultController');

Routing::post('login', 'SecurityController');

Routing::run($path);

?>