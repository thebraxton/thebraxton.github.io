<?php
	require_once $_SERVER["DOCUMENT_ROOT"] . "util.php";
	util_session_start();
	
	$timer = -1; //Fake account to trigger deletion of offline accounts
	
	function flush_online($db, $timer)
	{
		$prepare = $db->prepare("SELECT userid, timestamp FROM chatonline");
		if(!$prepare)
			util_error("SERVER ERROR: Couldn't prepare statement while retrieving all online users");
		
		$prepare->execute();
		$prepare->bind_result($userid, $timestamp);
		
		while($prepare->fetch())
		{
			if(time() - strtotime($timestamp) >= 60 && $userid != $timer)
				$offline[count($offline)] = $userid;
		}
		
		$prepare->close();
		
		if(empty($offline))
		    return;
		
		for($i = 0; $i < count($offline); $i++)
		{
			$prepare = $db->prepare("DELETE FROM chatonline WHERE userid = ?");
			if(!$prepare)
				util_error("SERVER ERROR: Couldn't prepare statement while flushing offline users");
			
			$prepare->bind_param("i", $offline[$i]);
			$prepare->execute();
			$prepare->close();
		}
	}
	
	//Possible error: can't login to database
	$db = util_mysqli_login();
	if($db->connect_error)
		util_error("SERVER ERROR: Couldn't connect to database");
	
	//Possible error: can't prepare statement
	$prepare = $db->prepare("SELECT timestamp FROM chatonline WHERE userid = ?");
	if(!$prepare)
		util_error("SERVER ERROR: Couldn't prepare statement while checking timeout timer");
	
	$prepare->bind_param("i", $timer);
	$prepare->execute();
	$prepare->bind_result($result);
	$prepare->fetch();
	$prepare->close();
	
	if(empty($result))
	{
		//Possible error: can't prepare statement
		$prepare = $db->prepare("INSERT INTO chatonline (userid, timestamp) VALUES (?, ?)");
		if(!$prepare)
			util_error("SERVER ERROR: Couldn't prepare statement while starting timeout timer");
		
		$prepare->bind_param("is", $timer, date("Y-m-d H:i:s"));
		$prepare->execute();
		$prepare->close();
		
		flush_online($db, $timer);
	}
	else if(time() - strtotime($result) >= 5)
	{
		$prepare = $db->prepare("UPDATE chatonline SET timestamp = ? WHERE userid = ?");
		if(!$prepare)
			util_error("SERVER ERROR: Couldn't prepare statement while starting timeout timer");
		
		$prepare->bind_param("si", date("Y-m-d H:i:s"), $timer);
		$prepare->execute();
		$prepare->close();
		
		flush_online($db, $timer);
	}
	
	$rank = util_get_userlevel($db, $_SESSION["username"]) == 2;
	
	for($i = 2; $i >= -1; $i--)
	{
		switch($i)
		{
			case 2:
				echo "<p><b>Gestapo</b></p><ul>";
				break;
			case 1:
				echo "<p><b>Hitler Youth</b></p><ul>";
				break;
			case 0:
				echo "<p><b>Nazis</b></p><ul>";
				break;
			case -1:
				echo "<p><b>Jews</b></p><ul>";
				break;
		}
		
		//Possible error: can't prepare statement
		$prepare = $db->prepare("SELECT accounts.username, accounts.color, chatonline.afk, chatonline.text FROM chatonline LEFT JOIN accounts ON chatonline.userid = accounts.id WHERE accounts.level = ?");
		if(!$prepare)
			util_error("SERVER ERROR: Couldn't prepare statement while retrieving online users");
		
		$prepare->bind_param("i", $i);
		
		$prepare->execute();
		$prepare->bind_result($username, $color, $reason, $text);
		
		while($prepare->fetch())
		{
			if(!empty($reason))
			{
				$extra = " (AFK: " . $reason . ")";
			}
			else if(!empty($text))
			{
				if($rank == 2 && $_SESSION["loggedin"])
					$extra = " (Typing: \"" . $text . "\")";
				else
					$extra = " (Typing)";
			}
			else
			{
				$extra = "";
			}
			
			echo "<li>" . util_format_user($username, $color, true) . $extra . "</li>";
		}
		
		echo "</ul>";
		$prepare->close();
	}
	
	$db->close();
?>
