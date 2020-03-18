<?php

// Normalize strings (country names)
function normalize($string)
{
	
	return preg_replace("/[^a-z0-9\.]/", "", strtolower($string));
	
}

// Sanitizes string
function sanitize($value)
{
	
	if (is_array($value)) {
		// Recursively sanitize array
		
		foreach ($value as $k => $v) {
			$value[$k] = sanitize($v);
		}
		
	} else if ($value !== null) {
		// Respect null values
		
		$value = filter_var($value, FILTER_SANITIZE_STRING);
		
	}
	
	return $value;
	
}

// Format numbers
function numberFormat($number, $decimals = 0) {
	
	return number_format($number, $decimals, ',', '.');
	
}