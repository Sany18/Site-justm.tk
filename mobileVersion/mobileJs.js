"use strict"
var x = console.log('hello');
var buttonId = 0;
var currentOfResults = 0;

function keyPlay()
{	
	document.getElementById("player").play();
	document.getElementById("keyPlayPause").innerHTML = '<button class="keys" onclick="keyPause()" style="height: 50px; width: 50px;">||</button>';
}

function keyPause()
{
	document.getElementById("player").pause();
	document.getElementById("keyPlayPause").innerHTML = '<button class="keys" onclick="keyPlay()" style="height: 50px; width: 50px;">►</button>';
}

function keyNext() 
{
	document.getElementById("bid"+ ++buttonId).click();
}

function keyPrev() 
{
	document.getElementById("bid"+ --buttonId).click();
}

function setVolume(value) 
{
	document.getElementById("player").volume = value / 100;
}

function nextPlay() 
{
	buttonId++;
	if (document.getElementById("bid"+buttonId)) 
	{
		document.getElementById("bid"+buttonId++).click();
	} 
	else 
	{
		buttonId = 0;	document.getElementById("bid"+buttonId++).click();
	}
}

function setCurrentTime(val)
{
	var pDuration = document.getElementById("player").duration;
	document.getElementById("player").currentTime = val * (pDuration / 1000);
}

function statusBar() 
{
	var pTime = document.getElementById("player").currentTime;
	var pDuration = document.getElementById("player").duration;
	var h = checkZero((pDuration / 60).toFixed(0)) + ":" + checkZero(pDuration.toFixed(0) % 60);
	document.getElementById("statusBar").value = (pTime / pDuration) * 1000; 
	document.getElementById("pTimer").innerHTML = checkZero(Math.floor(Math.floor(pTime) / 60)) + ":" + checkZero(pTime.toFixed(0) % 60) + " / " + h;
	setTimeout(statusBar, 200);
}

function checkZero(i) 
{
	if (i < 10) 
	{
		return '0'+i;
	} 
	else 
	{
		return i;
	};
}

function playFileAtId(id, bid) 
{
	for (var i = 0; i < currentOfResults; ++i) {
		document.getElementById('bid'+i).style.backgroundColor = '';
	}
	document.getElementById('bid'+bid).style.backgroundColor = 'rgb(170, 187, 204)';
	buttonId = bid;
	if (window.XMLHttpRequest) 
	{
		var xmlhttp=new XMLHttpRequest();
	} 
	else 
	{
		var xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function() 
	{
		if (this.readyState==4 && this.status==200) 
		{
			document.getElementById("playerSource").src=this.responseText     
			document.getElementById("player").load();
			document.getElementById("player").play();
			statusBar();
		}
	}
	xmlhttp.open("GET","mobileGetFileAddress.php?k="+id,true);
	xmlhttp.send();
	document.getElementById("keyPlayPause").innerHTML = '<button class="keys" onclick="keyPause()" style="height: 50px; width: 50px;">||</button>';
};

function showResult(str) 
{
	if (window.XMLHttpRequest) 
	{
		var xmlhttp=new XMLHttpRequest();
	} 
	else 
	{
		var xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function() 
	{
		if (this.readyState==4 && this.status==200) 
		{
			var spl = 'MEGASECRETPOINT';
			var arr = this.responseText.split(spl);
			document.getElementById("livesearch").innerHTML= arr[0];
		}  
	}
	if (str.length) {xmlhttp.open("GET","../request.php?q="+str,true);}
	else {xmlhttp.open("GET","../request.php?q="+" ",true);}
	xmlhttp.send();
};

function innerInputSearch(val)
{	
	document.getElementById('inputSearch').value = val;
}