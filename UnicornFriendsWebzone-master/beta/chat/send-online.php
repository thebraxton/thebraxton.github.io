<?php
	require_once $_SERVER["DOCUMENT_ROOT"] . "util.php";
	util_session_start();
	
	//Possible error: not logged in
	if(!$_SESSION["loggedin"])
		exit;
	
	//Possible error: can't login to database
	$db = util_mysqli_login();
	if($db->connect_error)
		exit;
	
	//Possible error: can't get user ID
	$userid = util_get_userid($db, $_SESSION["username"]);
	if($userid == -1)
		exit;
	
	//mode == 1: set offline
	//mode == 2: set online
	
	//For app
	if(empty($_POST["mode"]))
		$_POST["mode"] = $_GET["mode"];
	
	//For app
	if(empty($_POST["text"]))
		$_POST["text"] = (bool) $_GET["text"];
	
	if($_POST["mode"] == 1)
	{
		//Possible error: can't prepare statement
		$prepare = $db->prepare("DELETE FROM chatonline WHERE userid = ?");
		if(!$prepare)
			exit;
		
		$prepare->bind_param("i", $userid);
		$prepare->execute();
		$prepare->close();
	}
	else if($_POST["mode"] == 2)
	{
		//Possible error: can't prepare statement
		$prepare = $db->prepare("SELECT userid, afk FROM chatonline WHERE userid = ?");
		if(!$prepare)
			exit;
		
		$prepare->bind_param("i", $userid);
		$prepare->execute();
		$prepare->bind_result($result, $reason);
		$prepare->fetch();
		$prepare->close();
		
		$timestamp = date("Y-m-d H:i:s");
		
		if(empty($result))
		{
			//Possible error: can't prepare statement
			$prepare = $db->prepare("INSERT INTO chatonline (userid, timestamp, text) VALUES (?, ?, ?)");
			if(!$prepare)
				exit;
			
			$prepare->bind_param("iss", $userid, $timestamp, htmlspecialchars($_POST["text"]));
		}
		else
		{
			//Possible error: can't prepare statement
			$prepare = $db->prepare("UPDATE chatonline SET timestamp = ?, afk = ?, text = ? WHERE userid = ?");
			if(!$prepare)
				exit;
			
			if($_POST["typing"])
			    $reason = "";
			
			$prepare->bind_param("sssi", $timestamp, $reason, htmlspecialchars($_POST["text"]), $userid);
		}
		
		$prepare->execute();
		$prepare->close();
		echo $db->error;
	}
	
	$db->close();
?>
