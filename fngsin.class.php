<?php

/*
FNG Canada Social Insurance Number Generator and Validator v1.1
Copyright © 2009 Fake Name Generator <http://www.fakenamegenerator.com/>

FNG Canada Social Insurance Number Generator and Validator v1.1 by the Fake 
Name Generator is licensed to you under a Creative Commons Attribution-Share 
Alike 3.0 United States License.

For full license details, please visit:
http://www.fakenamegenerator.com/license.php

*/

class fngsin{

	// Validates using the Luhn Algorithm (MOD10)
	// See: http://en.wikipedia.org/wiki/Luhn_algorithm
	function luhn($str){
		$sum = 0;
		for ($i = 0; $i < strlen($str); $i++) {
			if ($i % 2) {
				// Double up even numbers
				$x = 2 * $str[$i];
				$sum += ($x > 9) ? $x - 9 : $x;
			} else {
				$sum += $str[$i];
			}
		}

		return (($sum % 10) == 0);
	}

	function validateSIN($sin){
		$sin = preg_replace('/[^\d]/', '', $sin);
		return (strlen($sin) == 9 && !($sin[0] == '0' || $sin[0] == '8') && luhn($sin))
	}

	function generateSIN($separator = ' '){
		$validPrefix = array(1,2,3,4,5,6,7,9);
		$sin = array_rand($validPrefix,1);
		$length = 9;

		while(strlen($sin) < ($length - 1)){
			$sin .= rand(0,9);
		}

		$sum = 0;
		$pos = 0;

		$reversedSIN = strrev( $sin );

		while($pos < $length - 1){
			$odd = $reversedSIN[ $pos ] * 2;
			if($odd > 9){
				$odd -= 9;
			}

			$sum += $odd;

			if($pos != ($length - 2)){
				$sum += $reversedSIN[ $pos +1 ];
			}
			$pos += 2;
		}

		$checkdigit = (( floor($sum/10) + 1) * 10 - $sum) % 10;
		$sin .= $checkdigit;

		$sin1 = substr($sin,0,3);
		$sin2 = substr($sin,3,3);
		$sin3 = substr($sin,6,3);

		return $sin1.$separator.$sin2.$separator.$sin3;
	}
	
}

/* Example usage: */

/*

// Instantiate the class
$fngsin = new fngsin();

// Generate a SIN
echo $fngsin->generateSIN();

// Validate a SIN
echo $fngsin->validateSIN('046 454 286');

*/
?>
