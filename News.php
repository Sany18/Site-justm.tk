<?php
	$filename = 'News.txt';
    $lines = file($filename);
    echo '<ul>';
    foreach ($lines as $key => $value) 
    {
		echo '<li>'.$value.'</li>';
    }
    echo '</ul>';
?>