<?php

// Web routes

// Home
$router->get('/', '\App\Main@index');
// Import
$router->get('/' . $this->config['import-slug'], '\App\Import@execute');