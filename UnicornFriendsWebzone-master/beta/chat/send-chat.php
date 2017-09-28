<?php
	require_once $_SERVER["DOCUMENT_ROOT"] . "util.php";
		util_session_start();
	//Possible error: not logged in
	if(!$_SESSION["loggedin"])
		util_error("Not logged in");
	
	//Possible error: can't login to database
	$db = util_mysqli_login();
	if($db->connect_error)
		util_error("Server error, try again");
		
		

	function send_chat($sender, $message, $sudo=false){
	$db = util_mysqli_login();
	if($db->connect_error)
		util_error("Server error, try again");
	//Possible error: can't get user ID
	$userid = util_get_userid($db, $sender);
	if($userid == -1)
		util_error("Server error, try again");
	
	//Possible error: banned
	$rank = util_get_userlevel($db, $sender);
	if($rank == -1)
		util_error("Jews are not allowed to speak.");
	
	//Possible error: can't prepare statement
	$prepare = $db->prepare("UPDATE chatonline SET afk = ?, text = ? WHERE userid = ?");
	if(!$prepare)
		error("Server error, try again");
	
	$empty = "";
	$prepare->bind_param("ssi", $empty, $empty, $userid);
	$prepare->execute();
	$prepare->close();
	
	$prepare = $db->prepare("UPDATE chatonline SET text = ? WHERE userid = ?");
	if(!$prepare)
		error("Server error, try again");
	
	$empty = "";
	$prepare->bind_param("si", $empty, $userid);
	$prepare->execute();
	$prepare->close();
	

	
	//Possible error: nothing to send after trimming message
	$msg = trim(preg_replace("/\s+/", " ", htmlentities(substr($message, 0, 200))));
	if(empty($msg))
		exit;
	
	$color = util_get_usercolor($db, $sender);
	if(($msg[0] == '/' || $msg[0] == '!') && strlen($msg) > 1)
	{
		$msg = substr($msg, 1);
		$cmd = $msg;
		
		$args = explode(" ", $msg);
		$name = $args[0];
		array_shift($args);
		
		util_include_get("chat/process-cmd.php");
		$cmdarr = cmdprocess($name, $args, $sender, $color, $db);
		
		$msg = trim($cmdarr[0]);
		$shownto = $cmdarr[1];
		$selecttype = "cmd";
		
		//Possible error: nothing to send after processing cmd
		if(empty($msg))
			exit;
	}
	else
	{
		if(strcasecmp(substr($msg, 0, strlen("&gt;")), "&gt;") == 0 && strlen($msg) > 4)
			$msg = "<font color=\"green\">" . $msg . "</font>";
		
		if(strpos($msg, "&lt;") !== false || strpos($msg, "://") !== false || strpos($msg, "@") !== false)
		{
			//Possible error: nothing to send after processing tags
			util_include_get("chat/process-tag.php");
			$msg = trim(tagprocess($msg, $db));
			if(empty($msg))
				exit;
		}
		
		$msg = util_format_user($sender, $color, true) . ": " . $msg;
		$cmd = "";
		$shownto = "";
		$selecttype = "msg";
	}
	
	//Possible error: can't prepare statement
	$prepare = $db->prepare("SELECT timestamp, " . $selecttype . " FROM chatlog WHERE BINARY userid = ? ORDER BY id DESC LIMIT 1");
	if(!$prepare)
		util_error("Server error, try again");
	
	$prepare->bind_param("i", $userid);
	$prepare->execute();
	$prepare->bind_result($prvtime, $prvmsg);
	$prepare->fetch();
	$prepare->close();
	
	//Mods can bypass spam filter
	if($rank < 2)
	{
		$curmsg = strcmp($selecttype, "msg") == 0 ? $msg : $cmd;
		
		//Possible error: spam filter (repeated message)
		if(strcasecmp($curmsg, $prvmsg) == 0)
			util_error("Spam filter (repeated message)");
		
		//Posible error: spam filter (flooding)
		if(time() - strtotime($prvtime) < 3)
			util_error("Spam filter (flooding, wait 3s)");
	}
	
	//Possible error: can't prepare statement
	$prepare = $db->prepare("INSERT INTO chatlog (timestamp, userid, msg, cmd, shownto) VALUES (?, ?, ?, ?, ?)");
	if(!$prepare)
		util_error($db->error . "Server error, try again");
	
	$timestamp = date("Y-m-d H:i:s");
	$prepare->bind_param("sisss", $timestamp, $userid, $msg, $cmd, $shownto);
	$prepare->execute();
	$prepare->close();
	
	$db->close();
	
	if(!empty($_GET["msg"]))
	     echo "success";
	     }

	//Used by app
	if(empty($_POST["msg"])) $_POST["msg"] = $_GET["msg"];
	send_chat($_SESSION["username"], $_POST["msg"]);
?>
