<?php

 /*****************************************************
 * Utility methods
 *****************************************************/
 	//Print array for debugging
	function jaz_print_r($query) {
		echo '<pre>';
		print_r($query);
		echo '</pre>';
	}  
	
	//Flatten a muti-dimentional array into single array
	function array_flatten($array) { 
	  if (!is_array($array)) { 
	    return FALSE; 
	  } 
	  
	  $result = array(); 
	  foreach ($array as $key => $value) { 
	    if (is_array($value)) { 
	      $result = array_merge($result, $this->array_flatten($value)); 
	    } 
	    else { 
	      $result[$key] = $value; 
	    } 
	  } 
	  return $result; 
	} 	
	
	
	