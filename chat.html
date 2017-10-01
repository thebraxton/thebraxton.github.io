<!doctype html>
<html>
  <head>
    <title>NodeJS Comet Chat Demo</title>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.1/jquery.min.js"></script>
	<script type='text/javascript'>
$(function() {
    // This only works in modern browsers :)
    var webSocket = new WebSocket('ws://localhost:8080/chat');
    webSocket.onopen = function(event){
        $('#status').html('connected');
    };
    webSocket.onmessage = function(event){
		$('#transcript').append(event.data + "<br/>");
    };
    
    webSocket.onclose = function(event){
       $('#status').html('socket closed');
    };
    
	$('#sendButton').click(function() {
		var text = $('#textEntry').val();
		webSocket.send(text);
		$('#textEntry').val("");
	});
})
	</script>

  </head>
  <body>

    <h2>Chat</h2>
    <input type="text" id="textEntry" size="100"></input><button id="sendButton">Send</button>

    <h2><span id="status">opening socket</span></h2>

    <div id="transcript"></div>
  </body>
</html>
