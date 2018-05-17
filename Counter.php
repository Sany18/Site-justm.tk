<?php
	$trim = "\n\t\r\x00..\x1F";
	$filename = 'log.txt';
	$ip = trim($_SERVER['REMOTE_ADDR'], $trim);
	$time = date('Y-m-d H:i:s');
	$stack = array();
	$key = 0;

    $lines = file($filename);

    if ($lines[0])
    {
	    foreach ($lines as $num => $line) 
	    {
	    	$stack[] = trim(explode("  ", $line)[1], $trim);
	    }

	    foreach ($stack as $num => $line) 
	    {
	    	if ($ip == $line)
	    	{
	    		++$key;
	    	}
	    }
	} 
	else 
	{
		file_put_contents($filename, $time."  ".$ip."\n", FILE_APPEND); //Если файл пуст, добавляет первую строку
		++$key;
	}

	if (!$key)
	{
		file_put_contents($filename, $time."  ".$ip."\n", FILE_APPEND); //Добавляет ip и дату в файл, если уникален
	}
?>