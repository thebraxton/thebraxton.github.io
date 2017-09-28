<?php
	require_once $_SERVER["DOCUMENT_ROOT"] . "util.php";
	util_session_start();
	
	//Possible error: can't login to database
	$db = util_mysqli_login();
	if($db->connect_error)
		util_error("SERVER ERROR: Couldn't connect to database");
	
	//Possible error: can't prepare statement
	$prepare = $db->prepare("SELECT url FROM downloads WHERE BINARY name = ?");
	if(!$prepare)
		util_error("SERVER ERROR: Couldn't prepare statement while searching for URL");
	
	//Possible error: unknown file
	$prepare->bind_param("s", $_GET["name"]);
	$prepare->execute();
	$prepare->bind_result($result);
	$prepare->fetch();
	$prepare->close();
	
	if(empty($result))
		util_error("Unknown file: " . htmlspecialchars($_GET["name"]));
	
	//Possible error: can't prepare statement
	$prepare = $db->prepare("UPDATE downloads SET downcount = downcount + 1 WHERE BINARY name = ?");
	if(!$prepare)
		util_error("SERVER ERROR: Couldn't prepare statement while updating download counter");
	
	$prepare->bind_param("s", $_GET["name"]);
	$prepare->execute();
	$prepare->close();
	
	$db->close();
	header("Location: " . $result);
?>