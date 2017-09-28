<?php
	require_once $_SERVER["DOCUMENT_ROOT"] . "util.php";
	util_session_start();
	
	function json_error($error)
	{
		$json["err"] = "<font color=\"red\">" . $error . "</font>";
		die(json_encode($json));
	}
	
	//Possible error: 420 easter egg
	if($_POST["max"] == 420)
		json_error("blaze wede m9");
	
	$limit = min(max((int) $_POST["max"], 0), 100);
	
	//Possible error: can't login to database
	$db = util_mysqli_login();
	if($db->connect_error)
		json_error("SERVER ERROR: Couldn't connect to database");
	
	$ismod = $_SESSION["loggedin"] && util_get_userlevel($db, $_SESSION["username"]) == 2;
	if(!$_SESSION["loggedin"])
	{
		//Possible error: can't prepare statement
		$prepare = $db->prepare("SELECT id, timestamp, msg FROM (SELECT * FROM chatlog WHERE id > ? AND BINARY shownto = ? ORDER BY id DESC LIMIT ?) AS `tmptable` ORDER BY id ASC");
		//$prepare = $db->prepare("SELECT id, timestamp, msg FROM chatlog WHERE id BETWEEN ? AND ? AND shownto = ? ORDER BY id ASC");
		if(!$prepare)
			json_error("SERVER ERROR: Couldn't prepare statement while retrieving chat log for non-account");
		
		$stempty = "";
		$prepare->bind_param("isi", $_POST["new"], $stempty, $limit);
		//$prepare->bind_param("iis", $range_start, $range_end, $stempty);
		$prepare->execute();
		$prepare->bind_result($id, $timestamp, $msg);
	}
	else
	{
		if(!$ismod)
		{
			//Possible error: can't get user ID
			$userid = util_get_userid($db, $_SESSION["username"]);
			if($userid == -1)
				json_error("SERVER ERROR: Couldn't get user ID");
		
			//Possible error: can't prepare statement
			$prepare = $db->prepare("SELECT id, timestamp, msg, shownto FROM (SELECT * FROM chatlog WHERE id > ? AND BINARY ((shownto = ? OR shownto LIKE ? OR userid = ?) AND shownto NOT LIKE ?) ORDER BY id DESC LIMIT ?) AS `tmptable` ORDER BY id ASC");
			//$prepare = $db->prepare("SELECT id, timestamp, msg, shownto FROM chatlog WHERE id BETWEEN ? AND ? AND (shownto = ? OR shownto LIKE ? OR userid = ?) AND shownto NOT LIKE ? ORDER BY id ASC");
			if(!$prepare)
				json_error("SERVER ERROR: Couldn't prepare statement while retrieving chat log for regular account");
			
			$stempty = "";
			$stid = "% ". $userid ." %";
			$stdel = "% -1 %";
			
			$prepare->bind_param("issisi", $_POST["new"], $stempty, $stid, $userid, $stdel, $limit);
			//$prepare->bind_param("iissis", $range_start, $range_end, $stempty, $stid, $userid, $stdel);
			$prepare->execute();
			$prepare->bind_result($id, $timestamp, $msg, $shownto);
		}
		else
		{
			//Possible error: can't prepare statement
			$prepare = $db->prepare("SELECT id, timestamp, msg, shownto FROM (SELECT * FROM chatlog WHERE id > ? ORDER BY id DESC LIMIT ?) AS `tmptable` ORDER BY id ASC");
			//$prepare = $db->prepare("SELECT id, timestamp, msg, shownto FROM chatlog WHERE id BETWEEN ? AND ? ORDER BY id ASC");
			if(!$prepare)
				json_error("SERVER ERROR: Couldn't prepare statement while retrieving chat log for mod");
			
			$prepare->bind_param("ii", $_POST["new"], $limit);
			//$prepare->bind_param("ii", $range_start, $range_end);
			$prepare->execute();
			$prepare->bind_result($id, $timestamp, $msg, $shownto);
		}
	}
	
	while($prepare->fetch())
	{
		$json["end"] = $id;
		if(empty($json["start"]))
			$json["start"] = $id;
		
		$time = new DateTime($timestamp);
		$time->setTimezone(new DateTimeZone(timezone_name_from_abbr("", $_POST["tzoff"], $_POST["tzdst"])));
		$timefmt = $time->format("n-j-y g:i:s A");
		
		if(!empty($shownto))
		{
			//Possible error: can't login to database
			$db2 = util_mysqli_login();
			if($db2->connect_error)
				json_error("SERVER ERROR: Couldn't connect to database");
			
			$shownto = explode(" ", trim($shownto));
			$showntofmt = array();
			
			for($i = 0; $i < count($shownto); $i++)
			{
			    $userid = $shownto[$i];
				if(strcmp($userid, "-1") != 0 && !empty($userid))
				{
					$user = util_get_iduser($db2, $userid);
					if(empty($user))
					    $showntofmt[count($showntofmt)] = "*UNKNOWN USER*";
					else
					    $showntofmt[count($showntofmt)] = util_format_user($user, util_get_usercolor($db2, $user), true);
				}
			}
			
			$db2->close();
			
			$showntofmt = trim(implode(", ", $showntofmt));
			if(!empty($showntofmt))
				$msg = "(to " . $showntofmt . ") " . $msg;
			
			$json[$id]["sto"] = $showntofmt;
		}
		
		//Bonus feature not in help
		if(!$ismod)
		{
		    $msg = preg_replace_callback("/(?:^|(?<=\s))@me(?:$|(?=[^[:alnum:]\-_]))/i", function($user)
	    	{
		        //Possible error: can't login to database
			    $db2 = util_mysqli_login();
			    if($db2->connect_error)
				    json_error("SERVER ERROR: Couldn't connect to database");
			    
		        return util_format_user("@" . $_SESSION["username"], util_get_usercolor($db2, $_SESSION["username"]), true);
		    }, $msg);
		}
		
		if($ismod)
		{
		    if(empty($shownto))
                $deleteurl = "Delete";
            else
			    $deleteurl = in_array(-1, $shownto) ? "Undelete" : "Delete";
			
			$json[$id]["msg"] = "[<a id=\"msg" . $id . "\" href=\"javascript:toggleMsg(" . $id . ")\">" . $deleteurl . "</a>] " . $timefmt . " " . $msg . "<br />";
		}
		else
		{
			$json[$id]["msg"] = $timefmt . " " . $msg . "<br />";
		}
	}
	
	if(empty($json["start"]))
	{
		$json["start"] = $_POST["new"];
		$json["end"] = $_POST["new"];
	}
	
	$prepare->close();
	$db->close();
	
	echo json_encode($json);
?>
