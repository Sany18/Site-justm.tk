<link rel="stylesheet" href="global_style.css"><body style="color: darkblue;">
<?php
session_start();
require_once 'connection.php';
$link = mysqli_connect($host, $user, $password, $database);

$filesArray = $_SESSION['missFilesArrayInSession_Address'];
$singer = $_SESSION['missFilesArrayInSession_Singer'];
$name = $_SESSION['missFilesArrayInSession_Name'];

for ($i=0; $i < count($filesArray) ; $i++) 
{ 
	$query ="INSERT INTO MusicData (id, address, singer, name, img) VALUES (NULL, '$filesArray[$i]', '$singer[$i]', '$name[$i]', '-')"; //формирую запроc
	$result = mysqli_query($link, $query);
	mysqli_free_result($result);
	echo 'Добавлено: '.$singer[$i].' - '.$name[$i].'<br>';
}
mysqli_close($link);
echo '<br><a href="getLocalFilesInfo.php">Назад</a>'
?>