<?php

namespace App;


class Import
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
	
	public function execute()
	{
		
		$log = "--------------------\nIMPORT START: " . date('Y-m-d H:i:s') . "\n";
		
		// Initializing app info
		$app_info = [];
		
		// Get file new file
		$filename = str_replace('[date]', date($this->config['data-source-file-date'], $this->config['import-timestamp']), $this->config['data-source-filename']);
		
		// Load file from source
		$file = file_get_contents($this->config['data-source-path'] . $filename);
		if ($file === false) {
			
			$log .= "Could not load remote file '" . $this->config['data-source-path'] . $filename . "'.\nIMPORT FINISHED: " . date('Y-m-d H:i:s') . "\n\n";
			$this->writeLog($log);
			die('Could not load remote file "' . $this->config['data-source-path'] . $filename . '".');
			
		}
		
		// Update app info last update
		$app_info['last_update'] = date('d/m/Y', $this->config['import-timestamp']);
		$app_info['import_date'] = date('Y-m-d H:i:s');
		
		$log .= "Remote file '" . $this->config['data-source-path'] . $filename . "' loaded.\n";
		
		// Save file
		try {
			
			$destination_file = $this->config['paths']['data-csv'] . '/' . $filename;
			
			$fh = fopen($destination_file, 'w');
			$fw = fwrite($fh, $file);
			$fc = fclose($fh);
			
		} catch (Exception $e) {
			
			$log .= "Could not save local file '" . $this->config['paths']['data-csv'] . "/" . $filename . "'.\nIMPORT FINISHED: " . date('Y-m-d H:i:s') . "\n\n";
			$this->writeLog($log);
			die('Could not save local file "' . $this->config['paths']['data-csv'] . '/' . $filename . '": ' . $e->getMessage());
			
		}
		
		$log .= "Local file '" . $this->config['paths']['data-csv'] . "/" . $filename . "' saved.\n";
		
		// Parse imported file to get countries list
		
		$log .= "Parsing countries list...\n";
		
		// Countries data
		$countries = [];
		$lines = 0;
		$data_columns = $this->columnsFormatGet(date('Y-m-d'), $this->config['import-timestamp']);
		
		// Load countries population
		try {
			
			$countries_population = json_decode(file_get_contents($this->config['paths']['data-json'] . '/' . $this->config['files']['population']), true);
			
		} catch (Exception $e) {
			
			$log .= "Could not load local file '" . $this->config['paths']['data-json'] . "/" . $this->config['files']['population'] . "'.\nIMPORT FINISHED: " . date('Y-m-d H:i:s') . "\n\n";
			$this->writeLog($log);
			die('Could not load local file "' . $this->config['paths']['data-json'] . '/' . $this->config['files']['population'] . '": ' . $e->getMessage());
			
		}
		
		try {
			
			if (($handle = fopen($destination_file, "r")) !== false) {
				
				while (($data = fgetcsv($handle, 1000, ",")) !== false) {
					
					if ($lines > 0) {
						
						$country = trim($data[$data_columns['country']]);
						
						if (!in_array($country, $this->config['data-countries-disappeared'])) {
							
							if (!isset($countries[$country])) {
								// New country
								
								if (!isset($countries_population[$country])) {
									// New country detected. Have to update population manually!
									$log .= "New country detected: '" . $country . "'.\n";
								}
								
								// Update countries list
								$countries[$country] = [
									'normalized' => normalize($country),
									'population' => isset($countries_population[$country]) ? $countries_population[$country]['population'] : 0,
									'confirmed' => intval(trim($data[$data_columns['confirmed']])),
									'active' => intval(trim($data[$data_columns['confirmed']])) - intval(trim($data[$data_columns['deaths']])) - intval(trim($data[$data_columns['recovered']])),
									'deaths' => intval(trim($data[$data_columns['deaths']])),
									'recovered' => intval(trim($data[$data_columns['recovered']])),
									'lat' => floatval(trim($data[$data_columns['lat']])),
									'lng' => floatval(trim($data[$data_columns['lng']])),
								];
								
							} else {
								// Existing country (province)
								
								$countries[$country]['confirmed'] += intval(trim($data[$data_columns['confirmed']]));
								$countries[$country]['active'] += (intval(trim($data[$data_columns['confirmed']])) - intval(trim($data[$data_columns['deaths']])) - intval(trim($data[$data_columns['recovered']])));
								$countries[$country]['deaths'] += intval(trim($data[$data_columns['deaths']]));
								$countries[$country]['recovered'] += intval(trim($data[$data_columns['recovered']]));
								
							}
							
						}
						
					}
					
					$lines++;
					
				}
				
				fclose($handle);
				
			}
			
			// Order alphabetically
			ksort($countries);
			
		} catch (Exception $e) {
			
			$log .= "Could not parse local file '" . $this->config['paths']['data-csv'] . "/" . $filename . "'.\nIMPORT FINISHED: " . date('Y-m-d H:i:s') . "\n\n";
			$this->writeLog($log);
			die('Could not parse file "' . $filename . '": ' . $e->getMessage());
			
		}
		
		$log .= "Countries list parsed: " . $lines . " items.\n";
		
		// Parse data to get countries info
		
		$log .= "Parsing countries info...\n";
		
		// Initialize countries data array
		
		$countries_data = [];
		
		// Get timeline template
		
		$timeline = [];
		
		$date = strtotime($this->config['data-start-date'] . ' 12:00:00');
		
		while ($date <= strtotime('today')) {
			
			$timeline[date('Y-m-d', $date)] = [
				'confirmed' => 0,
				'active' => 0,
				'deaths' => 0,
				'recovered' => 0,
				'confirmed_daily' => 0,
				'deaths_daily' => 0,
				'recovered_daily' => 0,
			];
			
			$date += (24 * 60 * 60);
			
		}
		
		foreach ($countries as $country => $data) {
			
			$countries[$country]['timeline'] = $timeline;
			
		}
		
		// Get countries info by file
		
		$date = strtotime($this->config['data-start-date'] . ' 12:00:00');
		$lines = 0;
		
		while ($date <= strtotime('today')) {
			
			$date_formatted = date('Y-m-d', $date);
			$filename = str_replace('[date]', date($this->config['data-source-file-date'], $date), $this->config['data-source-filename']);
			$file = $this->config['paths']['data-csv'] . '/' . $filename;
			$data_columns = $this->columnsFormatGet($date_formatted);
			
			if (($handle = fopen($file, "r")) !== false) {
				
				while (($data = fgetcsv($handle, 1000, ",")) !== false) {
					
					if ($lines > 0) {
						
						// Update country data
						$country = trim($data[$data_columns['country']]);
						
						if (isset($this->config['data-countries-changed'][$country])) {
							// Some country names have changed
							$country = $this->config['data-countries-changed'][$country];
						}
						
						if (isset($countries[$country])) {
							
							$countries[$country]['timeline'][$date_formatted]['confirmed'] += trim($data[$data_columns['confirmed']]);
							$countries[$country]['timeline'][$date_formatted]['active'] += (trim($data[$data_columns['confirmed']]) - trim($data[$data_columns['deaths']]) - trim($data[$data_columns['recovered']]));
							$countries[$country]['timeline'][$date_formatted]['deaths'] += trim($data[$data_columns['deaths']]);
							$countries[$country]['timeline'][$date_formatted]['recovered'] += trim($data[$data_columns['recovered']]);
							
						}
						
					}
					
					$lines++;
					
				}
				
				fclose($handle);
				
			}
			
			$date += (24 * 60 * 60);
			
		}
		
		$log .= "Countries info parsed: " . $lines . " items.\n";
		
		// Recalculations of data
		
		$log .= "Recalculating data...\n";
		
		foreach ($countries as $country => $data) {
			
			$last_confirmed = 0;
			$last_deaths = 0;
			$last_recovered = 0;
			
			foreach ($data['timeline'] as $date => $d) {
				
				$countries[$country]['timeline'][$date]['confirmed_daily'] = intval($countries[$country]['timeline'][$date]['confirmed']) - $last_confirmed;
				$countries[$country]['timeline'][$date]['deaths_daily'] = intval($countries[$country]['timeline'][$date]['deaths']) - $last_deaths;
				$countries[$country]['timeline'][$date]['recovered_daily'] = intval($countries[$country]['timeline'][$date]['recovered']) - $last_recovered;
				
				$last_confirmed = intval($countries[$country]['timeline'][$date]['confirmed']);
				$last_deaths = intval($countries[$country]['timeline'][$date]['deaths']);
				$last_recovered = intval($countries[$country]['timeline'][$date]['recovered']);
				
			}
			
		}
		
		$log .= "Data recalculated.\n";
		
		// Write countries JSON file
		
		$log .= "Writing JSON files...\n";
		
		try {
			
			$destination_file = $this->config['paths']['data-json'] . '/' . $this->config['files']['countries'];
			
			$fh = fopen($destination_file, 'w');
			$fw = fwrite($fh, json_encode($countries, JSON_UNESCAPED_UNICODE));
			$fc = fclose($fh);
			
		} catch (Exception $e) {
			
			$log .= "Could not write JSON file '" . $this->config['paths']['data-json'] . "/" . $this->config['files']['countries'] . "'.\nIMPORT FINISHED: " . date('Y-m-d H:i:s') . "\n\n";
			$this->writeLog($log);
			die('Could not write JSON file "' . $this->config['paths']['data-json'] . '/' . $this->config['files']['countries'] . '": ' . $e->getMessage());
			
		}
		
		$log .= "File '" . $this->config['paths']['data-json'] . "/" . $this->config['files']['countries'] . "' saved.\n";
		
		// Write app_info JSON file
		
		try {
			
			$destination_file = $this->config['paths']['data-json'] . '/' . $this->config['files']['app-info'];
			
			$fh = fopen($destination_file, 'w');
			$fw = fwrite($fh, json_encode($app_info, JSON_UNESCAPED_UNICODE));
			$fc = fclose($fh);
			
		} catch (Exception $e) {
			
			$log .= "Could not write JSON file '" . $this->config['paths']['data-json'] . "/" . $this->config['files']['app-info'] . "'.\nIMPORT FINISHED: " . date('Y-m-d H:i:s') . "\n\n";
			$this->writeLog($log);
			die('Could not write JSON file "' . $this->config['paths']['data-json'] . '/' . $this->config['files']['app-info'] . '": ' . $e->getMessage());
			
		}
		
		$log .= "File '" . $this->config['paths']['data-json'] . "/" . $this->config['files']['app-info'] . "' saved.\n";
		
		// Import finished
		
		$log .= "IMPORT FINISHED: " . date('Y-m-d H:i:s') . "\n\n";
		
		// Write log
		
		$this->writeLog($log);
		
		die('<pre>' . $log);
		
	}
	
	// Returns the CSV columns format based on date
	public function columnsFormatGet($date)
	{
		
		$columns = [];
		
		foreach ($this->config['data-columns'] as $d => $c) {
			
			if ($date >= $d) {
				$columns = $c;
			}
			
		}
		
		return $columns;
		
	}
	
	public function writeLog($log)
	{
		
		$destination_file = $this->config['paths']['logs'] . '/' . $this->config['files']['import-log'];
		
		$fh = fopen($destination_file, 'a');
		$fw = fwrite($fh, $log);
		$fc = fclose($fh);
	
	}
	
}