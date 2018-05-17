<?php
require_once 'connection.php';
$link = mysqli_connect($host, $user, $password, $database);
$id=$_GET["k"];

$query ="SELECT address FROM MusicData WHERE id = '$id'"; //формируем запрос

$result = mysqli_query($link, $query) or die("Ошибка обработки запроса: " . mysqli_error($link)); 
if($result)
{
    $row = mysqli_fetch_array($result); // одна строка из результата в виде массива ячеек
    echo $row[0];
};
// закрываем подключение
mysqli_close($link);
?>