<?php
session_start();
require_once 'connection.php'; // подключаем скрипт
$numberOfRows = 0;

// подключаемся к серверу
$link = mysqli_connect($host, $user, $password, $database) 
    or die("Ошибка подключения к БД " . mysqli_error($link)); 

// выполняем операции с базой данных     
$q=$_GET["q"]; //берем переменную из запроса ajax

$query ="SELECT id, singer, name FROM MusicData WHERE singer LIKE '%$q%' OR name LIKE '%$q%' LIMIT 500"; //формируем запрос

$result = mysqli_query($link, $query) or die("Ошибка обработки запроса: " . mysqli_error($link)); 
if($result)
{
    $rows = mysqli_num_rows($result); // количество полученных строк
    for ($GLOBALS["numberOfRows"] = 0 ; $GLOBALS["numberOfRows"] < $rows ; ++$GLOBALS["numberOfRows"])
    {
        $row = mysqli_fetch_row($result); // одна строка из результата в виде массива ячеек
        echo '<button id="bid'.$GLOBALS["numberOfRows"].'" onclick=playFileAtId('.$row[0].','.$GLOBALS["numberOfRows"].')>'.$row[1].' | '.$row[2].'</button><br>';
    };
    // очищаем результат
    mysqli_free_result($result);
    echo 'MEGASECRETPOINT'.$numberOfRows;
};
// закрываем подключение
mysqli_close($link);
?>
