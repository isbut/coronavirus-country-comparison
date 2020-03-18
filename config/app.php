<?php

// Main config file

return [
	
	// Folders
	'folders' => [
		'data-csv' => '/data/csv',
		'data-json' => '/data/json',
	],
	
	// Files
	'files' => [
		'countries' => 'countries.json',
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
		'graph_palette' => [
			'#008FFB',
			'#00E396',
			'#FEB019',
			'#FF4560',
			'#775DD0',
			'#546E7A',
		],
	],
	
	// Allowed
	'allowed' => [
		'modes' => ['absolute', 'relative'],
		'starts' => [10, 100, 500],
		'graph_modes' => ['linear', 'logarithmic'],
	],
	
	// Parsing origin data
	// Path for CSV files
	'data-source-path' => 'https://github.com/CSSEGISandData/COVID-19/raw/master/csse_covid_19_data/csse_covid_19_daily_reports/',
	// Source filename pattern
	'data-source-filename' => '[date].csv',
	// Source file date format
	'data-source-file-date' => 'm-d-Y',
	// Start date
	'data-start-date' => '2020-01-22',
	// CSV columns where data is located
	'data-columns' => [
		'province' => 0,
		'country' => 1,
		'confirmed' => 3,
		'deaths' => 4,
		'recovered' => 5,
		'lat' => 6,
		'lng' => 7,
	],
	// Countries that have changed name
	'data-countries-changed' => [
		'Mainland China' => 'China',
		'Hong Kong' => 'China',
		'Macau' => 'China',
	],
	// Countries that have dissapeared
	'data-countries-disappeared' => [
		'Taiwan',
	],
	
	// Country info
	'countries' => [
		
		'China' => [
			'population' => 1439323776,
		],
		'Panama' => [
			'population' => 4314767,
		],
		'Australia' => [
			'population' => 25499884,
		],
		'Croatia' => [
			'population' => 4105267,
		],
		'Burkina Faso' => [
			'population' => 20903273,
		],
		'Albania' => [
			'population' => 2877797,
		],
		'Canada' => [
			'population' => 37742154,
		],
		'United Kingdom' => [
			'population' => 67886011,
		],
		'Philippines' => [
			'population' => 109581078,
		],
		'Nepal' => [
			'population' => 29136808,
		],
		'Sri Lanka' => [
			'population' => 21413249,
		],
		'United Arab Emirates' => [
			'population' => 9890402,
		],
		'Thailand' => [
			'population' => 69799978,
		],
		'Cambodia' => [
			'population' => 16718965,
		],
		'San Marino' => [
			'population' => 33931,
		],
		'Germany' => [
			'population' => 83783942,
		],
		'Congo (Kinshasa)' => [
			'population' => 5518087,
		],
		'Honduras' => [
			'population' => 9904607,
		],
		'US' => [
			'population' => 331002651,
		],
		'Algeria' => [
			'population' => 43851044,
		],
		'Reunion' => [
			'population' => 895312,
		],
		'Oman' => [
			'population' => 5106626,
		],
		'Cruise Ship' => [
			'population' => 0,
		],
		'Italy' => [
			'population' => 60461826,
		],
		'Iraq' => [
			'population' => 40222493,
		],
		'Lebanon' => [
			'population' => 6825445,
		],
		'Ukraine' => [
			'population' => 43733762,
		],
		'Austria' => [
			'population' => 9006398,
		],
		'Switzerland' => [
			'population' => 8654622,
		],
		'Ireland' => [
			'population' => 4937786,
		],
		'Georgia' => [
			'population' => 3989167,
		],
		'Bangladesh' => [
			'population' => 164689383,
		],
		'Kuwait' => [
			'population' => 4270571,
		],
		'North Macedonia' => [
			'population' => 2083374,
		],
		'Brazil' => [
			'population' => 212559417,
		],
		'Greece' => [
			'population' => 10423054,
		],
		'Sweden' => [
			'population' => 10099265,
		],
		'Pakistan' => [
			'population' => 220892340,
		],
		'Norway' => [
			'population' => 5421241,
		],
		'France' => [
			'population' => 65273511,
		],
		'Turkey' => [
			'population' => 84339067,
		],
		'Bahrain' => [
			'population' => 1701575,
		],
		'Iceland' => [
			'population' => 341243,
		],
		'Ecuador' => [
			'population' => 17643054,
		],
		'Estonia' => [
			'population' => 1326535,
		],
		'Denmark' => [
			'population' => 5792202,
		],
		'Netherlands' => [
			'population' => 17134872,
		],
		'Cuba' => [
			'population' => 11326616,
		],
		'Nigeria' => [
			'population' => 206139589,
		],
		'Lithuania' => [
			'population' => 2722289,
		],
		'New Zealand' => [
			'population' => 4822233,
		],
		'Belarus' => [
			'population' => 9449323,
		],
		'Azerbaijan' => [
			'population' => 10139177,
		],
		'Armenia' => [
			'population' => 2963243,
		],
		'Kazakhstan' => [
			'population' => 18776707,
		],
		'Iran' => [
			'population' => 83992949,
		],
		'Israel' => [
			'population' => 8655535,
		],
		'Cayman Islands' => [
			'population' => 65722,
		],
		'Japan' => [
			'population' => 126476461,
		],
		'Czechia' => [
			'population' => 10708981,
		],
		'Qatar' => [
			'population' => 2881053,
		],
		'Singapore' => [
			'population' => 5850342,
		],
		'Guadeloupe' => [
			'population' => 400124,
		],
		'Dominican Republic' => [
			'population' => 10847910,
		],
		'Egypt' => [
			'population' => 102334404,
		],
		'Bolivia' => [
			'population' => 11673021,
		],
		'Indonesia' => [
			'population' => 273523615,
		],
		'Korea, South' => [
			'population' => 51269185,
		],
		'Latvia' => [
			'population' => 1886198,
		],
		'Senegal' => [
			'population' => 16743927,
		],
		'Ethiopia' => [
			'population' => 114963588,
		],
		'Sudan' => [
			'population' => 43849260,
		],
		'Kenya' => [
			'population' => 53771296,
		],
		'Portugal' => [
			'population' => 10196709,
		],
		'Andorra' => [
			'population' => 77265,
		],
		'Guinea' => [
			'population' => 13132795,
		],
		'Antigua and Barbuda' => [
			'population' => 97929,
		],
		'Belgium' => [
			'population' => 11589623,
		],
		'Russia' => [
			'population' => 145934462,
		],
		'India' => [
			'population' => 1380004385,
		],
		'Morocco' => [
			'population' => 36910560,
		],
		'Aruba' => [
			'population' => 106766,
		],
		'Argentina' => [
			'population' => 45195774,
		],
		'Chile' => [
			'population' => 19116201,
		],
		'Jordan' => [
			'population' => 10203134,
		],
		'Poland' => [
			'population' => 37846611,
		],
		'Hungary' => [
			'population' => 9660351,
		],
		'Slovenia' => [
			'population' => 2078938,
		],
		'Finland' => [
			'population' => 5540720,
		],
		'South Africa' => [
			'population' => 59308690,
		],
		'Bosnia and Herzegovina' => [
			'population' => 3280819,
		],
		'Saudi Arabia' => [
			'population' => 34813871,
		],
		'Cote d\'Ivoire' => [
			'population' => 26378274,
		],
		'Luxembourg' => [
			'population' => 625978,
		],
		'Costa Rica' => [
			'population' => 5094118,
		],
		'Bhutan' => [
			'population' => 771608,
		],
		'Spain' => [
			'population' => 46754778,
		],
		'Malaysia' => [
			'population' => 32365999,
		],
		'Holy See' => [
			'population' => 801,
		],
		'Serbia' => [
			'population' => 8737371,
		],
		'Cameroon' => [
			'population' => 26545863,
		],
		'Slovakia' => [
			'population' => 5459642,
		],
		'Togo' => [
			'population' => 8278724,
		],
		'Peru' => [
			'population' => 32971854,
		],
		'Romania' => [
			'population' => 19237691,
		],
		'Mexico' => [
			'population' => 128932753,
		],
		'Colombia' => [
			'population' => 50882891,
		],
		'Brunei' => [
			'population' => 437479,
		],
		'Martinique' => [
			'population' => 375265,
		],
		'French Guiana' => [
			'population' => 298682,
		],
		'Malta' => [
			'population' => 441543,
		],
		'Paraguay' => [
			'population' => 7132538,
		],
		'Moldova' => [
			'population' => 4033963,
		],
		'Maldives' => [
			'population' => 540544,
		],
		'Bulgaria' => [
			'population' => 6948445,
		],
		'Tunisia' => [
			'population' => 11818619,
		],
		'Cyprus' => [
			'population' => 1207359,
		],
		'Vietnam' => [
			'population' => 97338579,
		],
		'Mongolia' => [
			'population' => 3278290,
		],
		'Jamaica' => [
			'population' => 2961167,
		]
	
	],

];