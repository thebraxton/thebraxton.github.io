headerMain();

function moveAds()
{
	var body = document.body;
	var html = document.documentElement;
	
	var height = Math.max(body.scrollHeight, body.offsetHeight, html.clientHeight, html.scrollHeight, html.offsetHeight);
	var top = (height - 600) / 2;
	var side = (((window.innerWidth - 800) / 2) - 160) / 2;
	
	document.getElementById("leftad").style.top = top;
	document.getElementById("leftad").style.left= side;
	
	document.getElementById("rightad").style.top = top;
	document.getElementById("rightad").style.right = side;
}

function headerMain()
{
	document.getElementById("header-main").style.display = "";
	document.getElementById("header-account").style.display = "none";
}

function headerAccount()
{
	document.getElementById("header-main").style.display = "none";
	document.getElementById("header-account").style.display = "";
}

function popup(url)
{
	var w = 900;
	var h = 675;
	var x = window.screenLeft + (window.innerWidth - w) / 2;
	var y = window.screenTop + (window.innerHeight - h) / 2;
	
	if(x > 0 && y > 0)
		window.open(url, "popup", "width=" + w + ",height=" + h + ",left=" + x + ",top=" + y);
	else
		window.open(url, "popup", "width=" + w + ",height=" + h);
}

function getXhttp(url, data, outid, callback)
{
	var xhttp = new XMLHttpRequest();
	
	xhttp.open("POST", url, true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send(data);
	
	xhttp.onreadystatechange = function()
	{
		var out = document.getElementById(outid);
		if(xhttp.readyState == 4)
		{
			if(xhttp.status == 200)
			{
				if(outid != null)
					out.innerHTML = xhttp.responseText;
				
				if(callback != null)
					callback(xhttp.responseText);
			}
			else if(xhttp.status === 0)
			{
				if(outid != null)
					out.innerHTML = "<font color=\"red\">Timed out</font>";
			}
			else
			{
				if(outid != null)
					out.innerHTML = "<font color=\"red\">HTTP " + xhttp.status + "</font>";
			}
		}
	};
}

window.onload = function()
{
	moveAds();
};

window.onresize = function()
{
	moveAds();
};
