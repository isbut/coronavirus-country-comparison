<?php

namespace App;

use Bramus\Router\Router;

class Main
{
	
	private $config;
	
	public function __construct()
	{
		
		// Load config
		$this->config = array_merge(
			require __DIR__ . '/../config/app.php',
			require __DIR__ . '/../config/env.php'
		);
		
	}
	
	public function init()
	{
		
		// Create Router instance
		$router = new Router();
		
		// Define routes
		require __DIR__ . '/../config/routes.php';
		
		// Run it!
		$router->run();
		
	}
	
	public function index()
	{
		
		// Load countries
		$countries = json_decode(file_get_contents($this->config['paths']['data-json'] . '/' . $this->config['files']['countries']), true);
		
		// Get inputs
		$country1 = isset($_GET['c1']) ? sanitize($_GET['c1']) : $this->config['defaults']['country1'];
		$country2 = isset($_GET['c2']) ? sanitize($_GET['c2']) : $this->config['defaults']['country2'];
		$mode = isset($_GET['m']) ? sanitize($_GET['m']) : $this->config['defaults']['mode'];
		$start = isset($_GET['s']) ? sanitize($_GET['s']) : $this->config['defaults']['start'];
		$graph_mode = isset($_GET['gm']) ? sanitize($_GET['gm']) : $this->config['defaults']['graph_mode'];
		// Load cookie info
		if (isset($_COOKIE[$this->config['defaults']['cookie']['name']])
			&& substr_count($_COOKIE[$this->config['defaults']['cookie']['name']], ',') == 1) {
			$t = explode(',', $_COOKIE[$this->config['defaults']['cookie']['name']]);
			$country1 = sanitize($t[0]);
			$country2 = sanitize($t[1]);
		}
		
		// Check inputs
		if (!isset($countries[$country1])) {
			$country1 = $this->config['defaults']['country1'];
		}
		if (!isset($countries[$country2])) {
			$country2 = $this->config['defaults']['country2'];
		}
		if (!in_array($mode, $this->config['allowed']['modes'])) {
			$mode = $this->config['defaults']['mode'];
		}
		if (!in_array($start, $this->config['allowed']['starts'])) {
			$start = $this->config['defaults']['start'];
		}
		if (!in_array($graph_mode, $this->config['allowed']['graph_modes'])) {
			$graph_mode = $this->config['defaults']['graph_mode'];
		}
		
		include(APP_PATH . '/views/inc/header.php');
		include(APP_PATH . '/views/inc/head.php');
		include(APP_PATH . '/views/main.php');
		include(APP_PATH . '/views/inc/footer.php');
		
	}
	
}