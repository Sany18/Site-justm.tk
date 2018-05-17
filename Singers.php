<?php
	$filename = 'singers.txt';
    $lines = file($filename);
    foreach ($lines as $key => $value) 
    {
    	$trim = "\n\t\r\x00..\x1F";
		$val = trim($value, $trim);
		echo '<button onclick="innerInputSearch(&#39;'.$val.'&#39;), showResult(&#39;'.$val.'&#39;)">'.$val.'</button>';
    }
?>