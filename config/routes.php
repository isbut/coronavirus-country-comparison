<?php

// Web routes

// Home
$router->get('/', '\App\Main@index');
// Import
$router->get('/import', '\App\Import@execute');