<?php

// Define environement
define('ENV', 'development');
define('APP_PATH', '/home/des/public_html/Isbut/Coronavirus/Web');
define('PUBLIC_PATH', '/home/des/public_html/Isbut/Coronavirus/Web/public');

// Require composer autoloader
require APP_PATH . '/vendor/autoload.php';

// Init
$app = new App\Main;
$app->init();