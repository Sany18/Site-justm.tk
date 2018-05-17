<!doctipe html>
<!--Предложения и замечания: parubok.sashko@gmail.com | Александр-->
<html lang="en">
<head>
    <script async src="js.js"></script>
    <link rel="stylesheet" href="global_style.css"> 
    <meta scharset="utf-8">
    <title>New Music</title>
</head>    
<body onload="showResult(''), clock(), window.onscroll()">    
    <?php require_once 'Counter.php' ?>
    <div>
        <audio id="player" onended="nextPlay()">
        <source id ="playerSource" src=" " type="audio/mpeg">
        </audio>
    </div>
    <div id="BPlayer">
        <table>
            <th><button id="keyPrev" onclick="keyPrev()">&#60;&#60;</button></th>
            <th><button id="keyPlayPause" onclick="keyPlay()"></button></th>
            <th><button id="keyNext" onclick="keyNext()">&#62;&#62;</button></th>
            <th style="width:150px"><input onchange="setVolume(this.value)" oninput="setVolume(this.value)" type="range" min="0" max="100" style="width:120px"></th>
            <th style="width:150px; text-align:center;"><div id="pTimer"></div></th>
            <th style="vertical-align: top;"><div id="bMove">[Move]</div></th>
        </table>
        <input id="statusBar" onchange="setCurrentTime(this.value)" type="range" value="0" min="0" max="1000" style="width: 100%" />
    </div>
    <div id="searchBar">    	
    	<input id="inputSearch" onkeyup="showResult(this.value)" accesskey="s" value=" " alt="Alt + S" autofocus/>    	
   		<div id="numberOfResults"></div>
    </div>
    <div id="clock" href="log.txt"></div>
    <div id="scroll"></div>
    <div id="livesearch"></div>
    <div id="singers"><?php require_once 'Singers.php' ?></div>
    <div id="news"><?php require_once 'News.php' ?></div>
    <a id="mobileVersion" href="mobileVersion/mobileTopPage.html">Mobile version</a>
</body>
</html>
