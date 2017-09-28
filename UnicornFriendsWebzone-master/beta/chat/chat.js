var tzoff = new Date().getTimezoneOffset();
var tzoff = new Date().getTimezoneOffset();

var d1 = new Date();
d1.setDate(1);
d1.setMonth(1);

var d2 = new Date();
d2.setDate(1);
d2.setMonth(7);

var tzdst;
if(parseInt(d1.getTimezoneOffset()) == parseInt(d2.getTimezoneOffset()))
{
	tzdst = 0;
}
else
{
	var hemisphere = parseInt(d1.getTimezoneOffset()) - parseInt(d2.getTimezoneOffset());
	
	if((hemisphere > 0 && parseInt(d1.getTimezoneOffset()) == parseInt(tzoff)) ||
	(hemisphere < 0 && parseInt(d2.getTimezoneOffset()) == parseInt(tzoff)))
		tzdst = 0;
	else
		tzdst = 1;
}

tzoff *= -60;

var focus = true;

var chatArr = new Array();
var chatStr = "";
var chatStrPrv = "";
var prvMax = 0;
var newest = 0;

var timerOnline = 0;
var timerReset = 0;

var chatHistory = new Array();
var index = 0;

getChat();
setInterval(getChat, 500);

function sendChat()
{
	var input = document.getElementById("msg")
	var msg = encodeURIComponent(input.value.trim());
	
	if(msg === "")
		return;
	
	new Audio("/chat/bust.wav").play();
	document.getElementById("msgreturn").innerHTML = "<font color=\"green\">Sending...</font>";
	getXhttp("/chat/send-chat.php", "msg=" + msg, "msgreturn", function(out)
	{
		if(out === "")
			getChat();
	});
	
	chatHistory.push(input.value.trim());
    index = chatHistory.length;
	input.value = "";
	
	sendOnline();
}

function getChat()
{
	var xhttp = new XMLHttpRequest();
	var input = document.getElementById("limit");
	var chatbox = document.getElementById("chatbox");
	var scroll = (chatbox.scrollTop - 15 === (chatbox.scrollHeight - chatbox.offsetHeight));
	var max = input.value;
	
	if(max < 0)
		max = 0;
	
	timerReset -= 0.5;
	if(timerReset <= 0 || max != prvMax)
	{
		timerReset = 5;
		newest = 0;
		prvMax = max;
	}
	
	getXhttp("/chat/get-chat.php", "new=" + newest + "&max=" + max + "&tzoff=" + tzoff + "&tzdst=" + tzdst, null, function(json)
	{
		var newChat = JSON.parse(json);
		if(newChat["err"] != null)
		{
			chatbox.innerHTML = newChat["err"];
			return;
		}
		
		for(var i = newChat["start"]; i <= newChat["end"]; i++)
		{
			if(newChat[i] != null)
			{
				if(chatArr.indexOf(newChat[i]["msg"]) == -1) //hacky fixx for duplicate messages
					chatArr.push(newChat[i]["msg"]);
			}
		}
		
		chatArr.splice(0, chatArr.length - max);
		
		if(newest != newChat["end"])
		{
			chatStr = "";
			newest = newChat["end"];
			
			for(var i = 0; i <= max; i++)
			{
				if(chatArr[i] !== "" && chatArr[i] != null)
					chatStr += chatArr[i];
			}
			
			if(chatStr != chatStrPrv)
			{
				chatbox.innerHTML = chatStr;
				chatStrPrv = chatStr;
			}
		}
		
		if(scroll)
			chatbox.scrollTop = chatbox.scrollHeight - chatbox.offsetHeight + 15;
	});
	
	getXhttp("/chat/get-online.php", "", "online");
	
	timerOnline -= 0.5;
	if(timerOnline <= 0)
	{
		sendOnline();
	}
}

function sendOnline()
{
    timerOnline = 30;
    var show = document.getElementById("hide").checked ? "1" : "2";
	getXhttp("/chat/send-online.php", "mode=" + show + "&text=" + document.getElementById("msg").value.trim());
}

function clickName(username)
{
	var msg = document.getElementById("msg");
	if(event.ctrlKey)
	{
        if(!msg.value.endsWith(" ") && msg.value.length > 0)
            msg.value += " ";
        
		if(username.charAt(0) != '@')
			msg.value += "@";
		
		msg.value += username + " ";
	}
	else
	{
		if(msg.value == "/msg" || msg.value == "/msg ")
		{
			if(!msg.value.endsWith(" "))
				msg.value += " ";
			
			msg.value += username + " ";
		}
		else if(msg.value.startsWith("/msg "))
		{
			if(!msg.value.endsWith(" "))
				msg.value += " ";
			
			var argparts = msg.value.split(" ");
			var nameparts = argparts[1].split(",");
			
			if(nameparts.indexOf(username) == -1)
			{
				if(argparts[1].endsWith(","))
					argparts[1] += username;
				else
					argparts[1] += "," + username;
			}
			
			msg.value = argparts.join(" ");
		}
		else
		{
			msg.value = "/msg " + username + " " + msg.value;
		}
	}
	
	msg.focus();
	sendOnline();
}

function searchArchive()
{
    popup("/chat/archive/?date=" + document.getElementById("date").value + "&tzoff=" + tzoff + "&tzdst=" + tzdst);
}

function toggleMsg(id)
{
	var msg = document.getElementById("msg" + id);
	if(msg.innerHTML.includes("Delete"))
		msg.innerHTML = "Deleting...";
	else
		msg.innerHTML = "Undeleting...";
	
	getXhttp("/chat/send-chat.php", "msg=/toggle " + id, "msgreturn", function(success)
	{
		if(success == "<font color=\"green\">Success</font>")
		{
			if(msg.innerHTML.includes("Deleting..."))
				msg.innerHTML = "Undelete";
			else
				msg.innerHTML = "Delete";
		}
	});
}

document.getElementById("filebutton").onclick = function()
{
    var button = document.getElementById("filebutton");
	var uploadreturn = document.getElementById("uploadreturn");
	
	var file = document.getElementById("file");
	var xhttp = new XMLHttpRequest();
	
	if(file.files[0] == null)
	{
		return;
	}
	
	if(file.files[0].size > 5 * 1024 * 1024)
	{
		uploadreturn.innerHTML = "<font color=\"red\">File too large</font>";
		file.value = "";
		return;
	}
	
	new Audio("/chat/bust.wav").play();
	button.disabled = true;
	
	xhttp.upload.addEventListener("progress", function(e)
	{
			var percent = parseInt((e.loaded / e.total) * 100);
			uploadreturn.innerHTML = "<font color=\"green\">Uploading (" + percent + "%)";
	}, false);
	
	xhttp.open("POST", "/chat/upload.php", true);
	xhttp.send(new FormData(document.forms.namedItem("uploadform")));
	
	xhttp.onreadystatechange = function()
	{
		if(xhttp.readyState == 4 && xhttp.status == 200)
		{
			uploadreturn.innerHTML = xhttp.responseText;
			file.value = "";
		}
		
		button.disabled = false;
	};
}

document.getElementById("msg").onkeyup = function(e)
{
    var keynum;
    if(window.event)
        keynum = e.keyCode;
    else if(e.which)
        keynum = e.which; //Netscape/Firefox/Opera    
    
    var input = document.getElementById("msg");
    if(String.fromCharCode(keynum) == "&" && chatHistory[index - 1] != null)
    {
        if(index > 0)
            index--;
        
        input.value = chatHistory[index];
    }
    
    if(String.fromCharCode(keynum) == "(")
    {
        if(index < chatHistory.length - 1)
        {
            index++;
            input.value = chatHistory[index];
        }
        else
        {
            input.value = "";
        }
    }
    
    sendOnline();
}

document.getElementById("msg").onkeypress = function(e)
{
	if(!e) e = window.event;
	if(e.keyCode == '13')
	{
		sendChat();
	}
};

window.onfocus = function()
{ 
	focus = true;
}; 

window.onblur = function()
{ 
	focus = false;
};

window.onbeforeunload = function()
{
	getXhttp("/chat/send-online.php", "mode=1");
};
