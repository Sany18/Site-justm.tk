<link rel="stylesheet" href="global_style.css"><body style="color: darkblue;">
<?php
session_start();
session_unset();
$missFilesArray = array();
$rootDir = '/var/www/musics/media';
$r = 0;
$n = 0;
$singersArray = array();
require_once 'connection.php';
$link = mysqli_connect($host, $user, $password, $database) or die("Ошибка подключения к БД " . mysqli_error($link));

echo 'Жди<br>';

function parse($dir) //помещаю исходную директоирию
{
    global $r, $n, $link;
    foreach (scandir($dir) as $key => $value)  //создаю массив из директории и прохожусь по нему
    {
        if ($value != "." && $value != "..")     //отсеиваю точки (метод возвращает их первыми двумя позициями)
        {
            $ldir = $dir.'/'.$value;
            if (is_dir($ldir))                    //если это папка, вызываю рекурсию
            {
                parse($ldir);
            }
            else 
            {                                     //если файл, добавляю его в запрос SQL
                $trim = "media";
                $localAdd = stristr($ldir, $trim);    //Отсекаю /var/www/musics  |  теперь здесь только локальный адрес файла
                $query ="SELECT * FROM MusicData WHERE address = '$localAdd'"; //формирую запрос
                $result = mysqli_query($link, $query) or die("Ошибка обработки запроса: " . mysqli_error($link)); //отправляю и получаю результат
                $row = mysqli_fetch_array($result); //певая строка результата (в даном случае единственная)
                mysqli_free_result($result); //очистка ответа бд
                if(!$row['address'])         //если ответ с предложенным адресом пуст
                {                            //формирую красивый вывод инфы и добавляю в POST переменную
                    $exp = explode("_-_", $value);
                    $singer = strtr($exp[0], '_', ' ');
                        $trans1 = array('_' => ' ', '.mp3' => '');
                    $name = strtr($exp[1], $trans1);
                    addFileToQuery($localAdd, $singer, $name);
                    ++$n;
                    echo "В базе нет композиции с адресом: ".$localAdd.".<br><li>   Исполнитель: ".$singer."<br><li>   Название трека: ".$name."<br>";
                    $GLOBALS['singersArray'][] = $singer;
                }
                ++$r;
            } 
        }
    }
}

function addFileToQuery($fileAddr, $singer, $name) //складываю адреса всех файлов в 1 массив
{
    global $missFilesArray;
	$missFilesArray[] = $fileAddr;
    $_SESSION['missFilesArrayInSession_Address'][] = $fileAddr;
    $_SESSION['missFilesArrayInSession_Singer'][] = $singer;
    $_SESSION['missFilesArrayInSession_Name'][] = $name;
}

function status() //вывод статуса вконце парсинга
{
    global $n, $r, $link, $missFilesArray;
    mysqli_close($link);    
    echo '<br>Дождался<br>';
    echo 'Не занесенных в базу '.$n.' файлов.'; //вывод в браузер
    echo '<br>Всего в базе '.$r. ' файлов.<br>';
        if ($n > 0) {echo '<a href="addFilesToDataBase.php">Загрузить файлы в БД</a><br><br>';}
        else {echo 'И добавить нечего<br><br>';}
}

function repeatFilter($Arr)
{
    $localArray[] = $Arr[0];
    foreach ($Arr as $key => $value)
    {
        if (!in_array($value, $localArray)) 
        {
            $localArray[] = $value;
        }
    }
    return $localArray;
}

function singers($singArray)
{
    $filename = 'singers.txt';
    $singersOfFile = file($filename);
    $localSingersOfFile = array();
    $key = 0;
    $singArr = repeatFilter($singArray);    
    $trim = "\n\t\r\x00..\x1F";
    foreach ($singersOfFile as $key => $value) {
        $localSingersOfFile[] = $value;}

    foreach ($singArr as $num => $line) 
    {
        $singerOfFunction = trim($line, $trim);
        foreach ($localSingersOfFile as $key => $value1) 
        {
            $singerOfFile = trim($value1, $trim);
            if ($singerOfFunction == $singerOfFile)
            {
                ++$key;
            }
        }
        if (!$key && $singerOfFunction != '' || ' ' || '\n')
        {
            $localSingersOfFile[] = $singerOfFunction;
        }
        $key = 0;
    }
    natcasesort($localSingersOfFile);    
    file_put_contents($filename, ""); //чищу файл
    foreach ($localSingersOfFile as $key => $value) {
        $valueTrim = trim($value, $trim);
        file_put_contents($filename, $valueTrim."\n", FILE_APPEND);
    }

}

parse($rootDir); //привожу в действие всё безобразие 
status();
session_write_close();
singers($singersArray);
?>