<?php
	require_once $_SERVER["DOCUMENT_ROOT"] . "util.php";
	util_include_set();
	
	function implodeargs($args, $db)
	{
		$implode = trim(implode(" ", $args));
		if(strpos($implode, "&lt;") !== false || strpos($implode, "://") !== false || strpos($implode, "@") !== false)
		{
			util_include_get("chat/process-tag.php");
			$implode = trim(tagprocess($implode, $db));
		}
		
		return $implode;
	}
	
	//$name = command name
	//$args = array of command args
	//$user = username
	//$color = username color, or empty string for black
	//$db = database
	//Each command returns an array, [0] is output to chat and [1] is shownto
	function cmdprocess($name, $args, $user, $color, $db)
	{
		switch(strtolower($name))
		{
			case "me":
				return cmdme($args, $user, $color, $db);
			case "mes":
				return cmdmes($args, $user, $color, $db);
			case "rickroll":
				return cmdrickroll($user, $color, $args, $db);
			case "leakip":
				return cmdleakip($user, $color);
			case "getip":
				return cmdgetip($user, $args, $db);
			case "rank":
				return cmdrank($user, $color, $args, $db);
			case "ban":
				return cmdban($user, $color, $args, $db);
			case "color":
				return cmdcolor($user, $color, $args, $db);
			case "msg":
			case "message":
				return cmdmsg($user, $color, $args, $db);
			case "afk":
				return cmdafk($user, $color, $args, $db);
			case "brb":
				return cmdbrb($user, $color, $db);
			case "toggle":
				return cmdtoggle($user, $args, $db);
			case "say":
				return cmdsay($args, $user, $db);
			case "sudo":
				return cmdsudo($args, $user, $db);
			default:
				util_error("Unknown command: \"" . $name . "\"");
		}
	}
	
	function cmdme($args, $user, $color, $db)
	{
		//Possible error: no action
		$action = implodeargs($args, $db);
		if(empty($action))
			util_error("Usage: /me [action]");
		
		$userfmt = util_format_user($user, $color, true);
		
		if(strcasecmp($color, "rainbow") == 0)
			$actionfmt = "<font class=\"rainbow\">" . $action . "</font>";
		else if(empty($color) || strcmp($color, "black") == 0)
			$actionfmt = $action;
		else
			$actionfmt = "<font color=\"" . $color . "\">" . $action . "</font>";
		
		$out = "<i>" . $userfmt . " " . $actionfmt . "</i>";
		
		return array($out, "");
	}
	
	function cmdmes($args, $user, $color, $db)
	{
		//Possible error: no action
		$action = implodeargs($args, $db);
		if(empty($action))
			util_error("Usage: /mes [action]");
		
		$userfmt = util_format_user($user, $color, true);
		
		if(strcasecmp($color, "rainbow") == 0)
			$actionfmt = "<font class=\"rainbow\">'s " . $action . "</font>";
		else if(empty($color) || strcmp($color, "black") == 0)
			$actionfmt = "'s " . $action;
		else
			$actionfmt = "<font color=\"" . $color . "\">'s " . $action . "</font>";
		
		$out = "<i>" . $userfmt . $actionfmt . "</i>";
		
		return array($out, "");
	}
	
	function cmdrickroll($user, $color, $args, $db)
	{
		$filename = implodeargs($args, $db);
		
		//Possible error: no filename
		if(empty($filename))
			util_error("Usage: /rickroll [filename]");
		
		//Possible error: invalid filename
		if(preg_match("/^[^@\/?*:<>;{}\\\\]+$/", $args[0]) == 0)
			util_error("Invalid filename: \"" . $args[0] . "\"");
		
		$filename = str_replace(" ", "_", trim($filename));
		
		$parts = pathinfo($filename);
		$src_name = $parts["filename"] . ".php";
		
		$target_dir = util_get_uploaddir();
		$target_name = $_SESSION["username"] . "-" . date("YmdHis") . "-" . $src_name;
		$target_file = $target_dir . $target_name;
		
		copy($_SERVER["DOCUMENT_ROOT"] . "chat/verify.php", $target_file);
		
		$url = "<a href=\"" . util_get_uploaddmn() . $target_name . "\" target=\"_blank\">" . $parts["basename"] . "</a>";
		return array(util_format_user($user, $color, true) . ": Uploaded file: " . $url, "");
	}
	
	function cmdleakip($user, $color)
	{
		$url = "<a href=\"http://db-ip.com/" . $_SERVER["REMOTE_ADDR"] . "\" target=\"_blank\">" . $_SERVER["REMOTE_ADDR"] . "</a>";
		return array(util_format_user($user, $color, true) . ": My IP address is " . $url . ". PLS HACK ME", "");
	}
	
	function cmdgetip($user, $args, $db)
	{
		if(empty($args[0]))
			$args[0] = $user;
		else if($args[0][0] == '@')
			$args[0] = substr($args[0], 1);
		
		//Possible error: unknown user
		if(!util_get_userexists($db, $args[0]))
			util_error("Unknown username: \"" . $args[0] . "\"");
		
		if(util_get_userlevel($db, $user) == 2 || strcmp($args[0], $user) == 0)
		{
			//Possible error: can't prepare statement
			$prepare = $db->prepare("SELECT ip FROM accounts WHERE BINARY username = ?");
			if(!$prepare)
				util_error("Server error, try again");
			
			$prepare->bind_param("s", $args[0]);
			$prepare->execute();
			$prepare->bind_result($result);
			$prepare->fetch();
			$prepare->close();
			
			$url = "<a href=\"http://db-ip.com/" . $result . "\" target=\"_blank\">" . $result . "</a>";
			die(util_format_user($args[0], util_get_usercolor($db, $args[0]), true) . "'s IP address is " . $url);
		}
		else
		{
			//Possible error: not a mod
			util_error("Only mods can see another account's IP address.");
		}
	}
	
	function cmdrank($user, $color, $args, $db)
	{
		if(empty($args[0]))
			$args[0] = $user;
		else if($args[0][0] == '@')
			$args[0] = substr($args[0], 1);
		
		//Possible error: unknown user
		if(!util_get_userexists($db, $args[0]))
			util_error("Unknown username: \"" . $args[0] . "\"");
		
		$levelname = array("-1" => "-1 (Jew)", "0" => "0 (Mexican)", "1" => "1 (Hitler Youth)", "2" => "2 (Gestapo)");
		
		$userchanger = util_format_user($user, $color, true);
		$userchanged = util_format_user($args[0], util_get_usercolor($db, $args[0]), true);
		
		$oldlevel = util_get_userlevel($db, $args[0]);
		if(count($args) == 1)
			die($userchanged . "  is rank level " . $levelname[$oldlevel] . ".");
		
		if(util_get_userlevel($db, $user) == 2)
		{
			//Possible error: invalid rank
			$newlevel = (int) $args[1];
			if($newlevel < -1 || $newlevel > 2)
				util_error("Invalid rank: \"" . $args[1] . "\"");
			
			//Possible error: nothing to change
			if($newlevel == $oldlevel)
				util_error($userchanged . " is already level " . $levelname[$newlevel] . ".");
			
			//Possible error: can't prepare statement
			$prepare = $db->prepare("UPDATE accounts SET level = ? WHERE BINARY username = ?");
			if(!$prepare)
				util_error("Server error, try again");
			
			$prepare->bind_param("is", $newlevel, $args[0]);
			$prepare->execute();
			$prepare->close();
			
			if($newlevel > 0 && $oldlevel <= 0)
			{
				$userchanged = util_format_user($args[0], "rainbow", true);
				$colargs = array($args[0], "rainbow");
				cmdcolor($user, $color, $colargs, $db);
			}
			
			if($newlevel <= 0 && $oldlevel > 0)
			{
				$userchanged = util_format_user($args[0], "black", true);
				$colargs = array($args[0], "black");
				cmdcolor($user, $color, $colargs, $db);
			}
			
			return array($userchanger . " set " . $userchanged . " to rank level " . $levelname[$newlevel] . ".", "");
		}
		else
		{
			//Possible error: not a mod
			util_error("Only mods can change rank.");
		}
	}
	
	function cmdban($user, $color, $args, $db)
	{
		//Possible error: invalid args
		if(empty($args[0]))
			util_error("Usage: /ban [username]");
		
		return cmdrank($user, $color, array($args[0], "-1"), $db);
	}
	
	function cmdcolor($user, $color, $args, $db)
	{
		//Possible error: invalid args
		if(count($args) == 0)
			util_error("Usage: /color [color] or /color [username] [color]");
		
		if(empty($args[1]))
		{
			$args[1] = $args[0];
			$args[0] = $user;
		}
		else if($args[0][0] == '@')
		{
			$args[0] = substr($args[0], 1);
		}
		
		//Possible error: unknown user
		if(!util_get_userexists($db, $args[0]))
			util_error("Unknown username: \"" . $args[0] . "\"");
		
		$oldcolor = util_get_usercolor($db, $args[0]);
		if(empty($oldcolor))
			$oldcolor = "black";
		
		$rank = util_get_userlevel($db, $args[0]);
		
		$userchanger = util_format_user($user, $color, true);
		$userchanged = util_format_user($args[0], $oldcolor, true);
		
		if(util_get_userlevel($db, $user) == 2 || strcmp($args[0], $user) == 0)
		{
			//Possible error: invalid color
			$newcolor = $args[1];
			if(!util_verify_color($args[1]))
				util_error("Invalid color: \"" . $newcolor . "\"");
			
			if(strcasecmp($newcolor, "black") == 0)
				$newcolor = "";
			
			//Possible error: verified account changing colors
			if($rank > 0 && strcasecmp($newcolor, "rainbow") != 0)
				util_error("Verified usernames must be rainbow");
	
			//Possible error: non-verified account changing to rainbow
			if($rank <= 0 && strcasecmp($newcolor, "rainbow") == 0)
				util_error("Rainbow is reserved for verified accounts");
			
			//Possible error: nothing to change
			if(strcmp($newcolor, $oldcolor) == 0)
				util_error($userchanged . " is already " . $newcolor . ".");
			
			//Possible error: can't prepare statement
			$prepare = $db->prepare("UPDATE accounts SET color = ? WHERE BINARY username = ?");
			if(!$prepare)
				util_error("Server error, try again");
			
			$prepare->bind_param("ss", $newcolor, $args[0]);
			$prepare->execute();
			$prepare->close();
			
			$userchanged = util_format_user($args[0], $newcolor, true);
			return array($userchanger . " changed " . $userchanged . "'s color.", "");
		}
		else
		{
			//Possible error: not a mod
			util_error("Only mods can change another account's color.");
		}
	}
	
	function cmdmsg($user, $color, $args, $db)
	{
		//Possible error: invalid args
		if(count($args) < 2)
			util_error("Usage: /msg [recipients] [msg]");
		
		$to = array_filter(explode(",", $args[0]));
		array_shift($args);
		
		$tmp = array();
		for($i = 0; $i < count($to); $i++)
		{
		    $rec = $to[$i];
			if($rec[0] == '@')
				$rec = substr($rec, 1);
			
			//Possible error: sending to yourself
			if(strcmp($rec, $user) == 0)
				util_error("Don't send messages to yourself, lonely fgt.");
			
			//Possible error: unknown username
			if(!util_get_userexists($db, $rec))
				util_error("Unkown username: \"" . $rec . "\"");
			
			//Possible error: can't get user ID
			$userid = util_get_userid($db, $rec);
			if($userid == -1)
				util_error("Server error, try again");
			
			if(!in_array($userid, $tmp))
				array_push($tmp, $userid);
		}
		
		//Possible error: no recipients
		$to = " " . implode(" ", $tmp) . " ";
		if(empty(trim($to)))
			util_error("No recipients");
		
		//Possible error: no message
		$msg = implodeargs($args, $db);
		if(empty($msg))
			exit;
		
		return array(util_format_user($user, $color, true) . ": " . $msg, $to);
	}
	
	function cmdafk($user, $color, $args, $db)
	{
		//Possible error: can't get user ID
		$userid = util_get_userid($db, $user);
		if($userid == -1)
			util_error("Server error, try again");
		
		//Possible error: can't prepare statement
		$prepare = $db->prepare("UPDATE chatonline SET afk = ? WHERE userid = ?");
		if(!$prepare)
			util_error("Server error, try again");
		
		$reason = implodeargs($args, $db);
		if(empty($reason))
			$reason = "Away from keyboard";
		
		$prepare->bind_param("si", $reason, $userid);
		$prepare->execute();
		$prepare->close();
		
		return array(util_format_user($user, $color, true) . " is AFK: " . $reason, "");
	}
	
	function cmdbrb($user, $color, $db)
	{
		return cmdafk($user, $color, array("Be right back"), $db);
	}
	
	function cmdtoggle($user, $args, $db)
	{
	    //Possible error: invalid ID
	    $id = $args[0];
	    if(!ctype_digit($id))
		    util_error("Invalid ID: \"" . $id . "\"");
	    
	    //Possible error: not a mod
	    if(util_get_userlevel($db, $user) == 2)
	    {
		    //Possible error: couldn't prepare statement
		    $prepare = $db->prepare("SELECT shownto FROM chatlog WHERE id = ?");
		    if(!$prepare)
			    util_error("Server error, try again");
		    
		    $prepare->bind_param("i", $id);
		    $prepare->execute();
		    $prepare->bind_result($shownto);
		    $prepare->fetch();
		    $prepare->close();
		    
		    $showntoarr = explode(" ", $shownto);
		    if(strcmp($showntoarr[count($showntoarr) - 2], "-1") == 0) //normally would be count - 1 but explode puts an extra string with only a space because of the extra space at the end
		    {
			    $shownto = " " . implode(" ", array_splice($showntoarr, 0, count($showntoarr) - 2)) . " ";
			    if(empty(trim($shownto)))
			    	$shownto = "";
		    }
		    else
		    {
			    $shownto = trim(implode(" ", $showntoarr));
			    if(!empty($shownto))
				    $shownto = " " . $shownto;
			    
			    $shownto .= " -1 ";
		    }
		    
		    //Possible error: couldn't prepare statement
		    $prepare = $db->prepare("UPDATE chatlog SET shownto = ? WHERE id = ?");
		    if(!$prepare)
			    util_error("Server error, try again");
		    
		    $prepare->bind_param("si", $shownto, $id);
		    $prepare->execute();
		    $prepare->close();
		    
		    die("<font color=\"green\">Success</font>");
	    }
	    else
	    {
		    util_error("Only mods can toggle messages.");
	    }
	}
	
	function cmdsay($args, $user, $db)
	{
	    //Possible error: not a mod
        if(util_get_userlevel($db, $user) == 2)
	    {
		    //Possible error: no message
		    $message = implodeargs($args, $db);
		    if(empty($message))
			    util_error("Usage: /say [message]");
	        
			return array("<b>" . $message . "</b>", "");
        }
        else
	    {
		    util_error("Only mods can use /say.");
	    }
	}
	function cmdsudo($args, $user, $db)
	{
	    //Possible error: not a mod
        if(util_get_userlevel($db, $user) == 2)
	    {
		    //Possible error: no message
		    if($args[0][0] == '@')
			$args[0] = substr($args[0], 1);
		    $to=array_shift($args);
		    $message = implodeargs($args, $db);
		    if(empty($message))
			    util_error("Usage: /sudo [to] [bleg]");
			send_chat($to, $message, $user);
	        
			return array("", "");
        }
        else
	    {
		    util_error("Only mods can use /sudo.");
	    }
	}
?>
