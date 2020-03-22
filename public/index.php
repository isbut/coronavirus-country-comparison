<?php

// Define environement
define('ENV', 'development');
define('APP_PATH', '/path_to_app_folder');
define('PUBLIC_PATH', '/path_to_public_folder');

// Require composer autoloader
require APP_PATH . '/vendor/autoload.php';

// Init
$app = new App\Main;
$app->init();