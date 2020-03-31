<?php

// Main config file

return [
	
	// Paths
	'paths' => [
		'data-csv' => APP_PATH . '/data/csv',
		'data-json' => APP_PATH . '/data/json',
		'logs' => APP_PATH . '/logs',
	],
	
	// Files
	'files' => [
		'countries' => 'countries.json',
		'app-info' => 'app-info.json',
		'population' => 'population.json',
		'import-log' => 'import-log.txt',
	],
	
	// Defaults
	'defaults' => [
		'country1' => 'Spain',
		'country2' => 'Italy',
		'mode' => 'absolute',
		'start' => 100,
		'graph_mode' => 'linear',
		'relative_num' => 100000,
		'countries_max' => 6,
		'xaxis_lapse' => 20,
		'xaxis_lapse_zoom' => 50,
		'cookie' => [
			'life' => 30,
			'name' => 'isbutccc',
		],
		'graph_palette' => [
			'#008FFB',
			'#00E396',
			'#FEB019',
			'#FF4560',
			'#775DD0',
			'#546E7A',
		],
		'info_palette' => [
			'population' => '#000000',
			'confirmed' => '#4c95ff',
			'active' => '#ffa946',
			'deaths' => '#f95d14',
			'recovered' => '#58d26b',
		],
	],
	
	// Allowed
	'allowed' => [
		'modes' => ['absolute', 'relative'],
		'starts' => [10, 100, 500],
		'graph_modes' => ['linear', 'logarithmic'],
	],
	
	// Parsing origin data
	// Time of update
	'update-time' => '02:00 CET',
	// Date to search for
	'import-timestamp' => strtotime('yesterday'),
	// Path for CSV files
	'data-source-path' => 'https://github.com/CSSEGISandData/COVID-19/raw/master/csse_covid_19_data/csse_covid_19_daily_reports/',
	// Source filename pattern
	'data-source-filename' => '[date].csv',
	// Source file date format
	'data-source-file-date' => 'm-d-Y',
	// Start date
	'data-start-date' => '2020-01-22',
	// Formats of CSV columns where data is located
	'data-columns' => [
		'2020-01-22' => [ // Fisrt day this format is used
			'province' => 0,
			'country' => 1,
			'confirmed' => 3,
			'deaths' => 4,
			'recovered' => 5,
			'lat' => 6,
			'lng' => 7,
		],
		'2020-03-23' => [ // Fisrt day this format is used
			'fips' => 0,
			'admin2' => 1,
			'province' => 2,
			'country' => 3,
			'last_update' => 4,
			'lat' => 5,
			'lng' => 6,
			'confirmed' => 7,
			'deaths' => 8,
			'recovered' => 9,
			'active' => 10,
			'combined_key' => 11,
		]
	],
	// Countries that have changed name
	'data-countries-changed' => [
		'Mainland China' => 'China',
		'Hong Kong' => 'China',
		'Macau' => 'China',
		'Bahamas, The' => 'Bahamas',
		'East Timor' => 'Timor-Leste',
		'South Korea' => 'Korea, South',
		'Republic of Korea' => 'Korea, South',
	],
	// Countries that have dissapeared
	'data-countries-disappeared' => [
		'Taiwan',
	],

];