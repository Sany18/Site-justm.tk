var x=console.log("hello"),buttonId=0,currentOfResults=0;

function keyPlay()
	{
		document.getElementById("player").play();
		document.getElementById("keyPlayPause").style.backgroundPosition = "-257px -35px";
		document.getElementById("keyPlayPause").setAttribute('onclick', "keyPause()");
	}

function keyPause()
	{
		document.getElementById("player").pause();
		document.getElementById("keyPlayPause").style.backgroundPosition = "-37px -35px";
		document.getElementById("keyPlayPause").setAttribute('onclick', "keyPlay()");
	}

function keyNext()
	{
		document.getElementById("bid"+ ++buttonId).click();
	}

function keyPrev()
	{
		document.getElementById("bid"+--buttonId).click()
	}

function setVolume(a)
	{
		document.getElementById("player").volume=a/100
	}

function nextPlay()
	{
		buttonId++;
		document.getElementById("bid"+buttonId)||(buttonId=0);
		document.getElementById("bid"+buttonId++).click()
	}

function setCurrentTime(a)
	{
		var b=document.getElementById("player").duration;
		document.getElementById("player").currentTime=b/1E3*a
	}

function statusBar()
	{
		var a=document.getElementById("player").currentTime,
		b=document.getElementById("player").duration,
		c=checkZero((b/60).toFixed(0))+":"+checkZero(b.toFixed(0)%60);
		document.getElementById("statusBar").value=a/b*1E3;
		document.getElementById("pTimer").innerHTML=checkZero(Math.floor(Math.floor(a)/60))+":"+checkZero(a.toFixed(0)%60)+" / "+c;
		setTimeout(statusBar,200)
	}

function checkZero(a){return 10>a?"0"+a:a}

function playFileAtId(a,b)
	{
		for(var c=0;c<currentOfResults;++c) 
			document.getElementById("bid"+c).style.backgroundColor="";
			document.getElementById("bid"+b).style.backgroundColor="rgb(170, 187, 204)";
			buttonId=b;
			c=window.XMLHttpRequest?new XMLHttpRequest:new ActiveXObject("Microsoft.XMLHTTP");
			c.onreadystatechange=function()
				{
					4==this.readyState&&200==this.status&&(document.getElementById("playerSource").src=this.responseText,document.getElementById("player").load(),
					document.getElementById("player").play(),
					statusBar())
				};
				c.open("GET","getFileAddress.php?k="+a,!0);
				c.send();
				document.getElementById("keyPlayPause").style.backgroundPosition = "-257px -35px";
				document.getElementById("keyPlayPause").setAttribute('onclick', "keyPause()");
	}

function showResult(a)
	{
		var b=window.XMLHttpRequest?new XMLHttpRequest:new ActiveXObject("Microsoft.XMLHTTP");
		b.onreadystatechange=function()
			{
				if(4==this.readyState&&200==this.status)
					{
						var a=this.responseText.split("MEGASECRETPOINT");
						document.getElementById("livesearch").innerHTML=a[0];
						currentOfResults=a[1];
						document.getElementById("numberOfResults").innerHTML=currentOfResults
					}
			};
			a.length?b.open("GET","request.php?q="+a,!0):b.open("GET","request.php?q= ",!0);b.send()
	}

function clock()
	{
		var a=new Date,b=a.getHours(),c=a.getMinutes();
		a=a.getSeconds();
		c=checkZero(c);
		a=checkZero(a);
		document.getElementById("clock").innerHTML=b+":"+c+":"+a;
		setTimeout(clock,1E3)
	}
	window.onscroll=function()
	{
		var a=window.pageYOffset||document.documentElement.scrollTop;
		document.getElementById("scroll").innerHTML=a
	};

function innerInputSearch(a)
	{
		document.getElementById("inputSearch").value=a
	}

var buttonMove=document.getElementById("bMove"),Player=document.getElementById("BPlayer");
buttonMove.onmousedown=function(a)
{
	function b(a)
	{
		Player.style.top=a.pageY-c+"px";
		Player.style.left=a.pageX-d+"px"
	}
	var c=a.pageY-Player.getBoundingClientRect().top+pageYOffset,d=a.pageX-Player.getBoundingClientRect().left+pageXOffset;
	Player.style.position="absolute";
	Player.style.position="fixed";
	b(a);
	document.onmousemove=function(a)
	{
		b(a)
	};
	window.onmouseup=function()
	{
		document.onmousemove=null;
		Player.onmouseup=null
	}
};
Player.ondragstart=function(){return!1};
