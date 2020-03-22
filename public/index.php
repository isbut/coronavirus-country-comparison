<?php

// Define environement
define('ENV', 'development');
define('APP_PATH', '/home/dev1/public_html/Isbut/Coronavirus');
define('PUBLIC_PATH', '/home/dev1/public_html/Isbut/Coronavirus/public');

// Require composer autoloader
require APP_PATH . '/vendor/autoload.php';

// Init
$app = new App\Main;
$app->init();