<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <title>Multiplication Table</title>
  </head>
  <body>
    <h1>Multiplcation Table</h1>
	<?php
	$min_multiplicand = $_GET['min-multiplicand'];
	$max_multiplicand = $_GET['max-multiplicand'];
	$min_multiplier = $_GET['min-multiplier'];
	$max_multiplier = $_GET['max-multiplier'];
	if ( empty($min_multiplicand) )
	  echo 'Missing minimum multiplicand parameter.</br>';
	elseif ( !is_numeric($min_multiplicand) ) 
	  echo 'Minimum multiplicand must be an integer.</br>';
	if ( empty($max_multiplicand) )
	  echo 'Missing maximum multiplicand parameter.</br>';
    elseif ( !is_numeric($max_multiplicand) ) 
	  echo 'Maximum multiplicand must be an integer.</br>';
	if ( empty($min_multiplier) )
	  echo 'Missing minimum multiplier parameter.</br>';
	elseif ( !is_numeric($min_multiplier) ) 
	  echo 'Minimum multiplier must be an integer.</br>';
	if ( empty($max_multiplier) )
	  echo 'Missing maximum multiplier parameter.</br>';
	elseif ( !is_numeric($max_multiplier) ) 
	  echo 'Maximum multiplier must be an integer.</br>';
	if ( is_numeric($min_multiplicand) && is_numeric($max_multiplicand) && is_numeric($min_multiplier) && is_numeric($max_multiplier) ) { 
	  if( $min_multiplicand > $max_multiplicand )
	    echo 'Minimum multiplicand larger than maximum.</br>';
	  if ( $min_multiplier > $max_multiplier )
	    echo 'Minimum multiplier larger than maximum.</br>';
    }
	?>
  </body>
</html>