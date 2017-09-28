<?php
	require_once $_SERVER["DOCUMENT_ROOT"] . "util.php";
	util_session_start();
	
	//Possible error: can't login to database
	$db = util_mysqli_login();
	if($db->connect_error)
		util_error("SERVER ERROR: Couldn't connect to database");
	
	//Possible error: can't prepare statement
	$prepare = $db->prepare("UPDATE downloads SET downcount = downcount + 1 WHERE BINARY name = ?");
	if(!$prepare)
		util_error("SERVER ERROR: Couldn't prepare statement while updating download counter");
	
	$rickroll = "rickroll";
	$prepare->bind_param("s", $rickroll);
	$prepare->execute();
	$prepare->close();
	
	$db->close();
?>
<html>
	<head>
		<title>Unicorn Friends - 404</title>
		<script>
			var rick = new Audio("/404/rick.mp3");
			rick.loop = true;
			rick.play();
		</script>
	</head>
	<body background="/404/rick.jpg" style="background-repeat: repeat;">
		<div align="center"><h1>404 - RIP FILE</h1></div>
	</body>
</html>