<?php
/*
echo"<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-76974324-2', 'auto');
  ga('send', 'pageview');

</script>";*/
	//Some settings and utility functions
	date_default_timezone_set("Europe/London"); //do not change this
	
	//--------------------Google API Keys--------------------\\
	
	function util_captcha_site()
	{
		return "6LdxhR0TAAAAAHtFYo3icXyXhxjZvAOTrv8IXtWk";
	}
	
	function util_captcha_secret()
	{
		return "REDACTED";
	}
	
	//YouTube Data v3 API server key
	function util_server_key()
	{
		return "REDACTED";
	}
	
	function util_getad_center()
	{
		//if(rand(0, 1))
		if(true) //change to false when trying to verify again
		{
			//bob
			$client = "ca-pub-7137172888515516";
			$slot = "8894266185";
		}
		else
		{
			//jer
			$client = "ca-pub-2465462622962305";
			$slot = "6020013477";
		}
		
		return "<ins class=\"adsbygoogle\" style=\"display:inline-block;width:728px;height:90px\" data-ad-client=\"" . $client . "\" data-ad-slot=\"" . $slot . "\"></ins><script> (adsbygoogle = window.adsbygoogle || []).push({}); </script>";
	}
	
	//$side is either "left" or "right"
	function util_getad_side($side)
	{
		//if(rand(0, 1))
		if(true)
		{
			//bob
			$client = "ca-pub-7137172888515516";
			$slot = "2932117786";
		}
		else
		{
			//jer
			$client = "ca-pub-2465462622962305";
			$slot = "6960193079";
		}
		
		return "<div id=\"" . $side . "ad\"><ins class=\"adsbygoogle\" style=\"display:inline-block;width:160px;height:600px\" data-ad-client=\"" . $client . "\" data-ad-slot=\"" . $slot . "\"></ins><script> (adsbygoogle = window.adsbygoogle || []).push({}); </script></div>";
	}
	
	//--------------------Other settings--------------------\\
	
	//The forward slash on the end is important for these three
	function util_get_domain()
	{
		return "https://beta.unicornfriends.net/";
	}
	
	function util_get_uploaddir()
	{
		return "/var/www/dl/chat/uploads/";
	}
	
	function util_get_uploaddmn()
	{
		return "https://dl.unicornfriends.net/chat/uploads/";
	}
	
	function util_killswitch_password()
	{
		return "REDACTED";
	}
	
	function util_mysqli_dbname()
	{
		return "database";
	}
	
	function util_mysqli_login()
	{
		return new mysqli("127.0.0.1", "root", "REDACTED", util_mysqli_dbname());
	}
	
	function util_get_chatstart()
	{
		return "2016-12-25";
	}
	
	//--------------------Utilities--------------------\\
	
	function util_session_start()
	{
		if(session_status() != PHP_SESSION_ACTIVE)
			session_start();
		
		//Change this to true in case of emergency and need to shut down the site
		$killswitch = false;
		
		if($killswitch)
		{
			if(!$_SESSION["killswitchpass"])
			{
				if(strcmp($_GET["killswitchpass"], util_killswitch_password()) == 0)
					$_SESSION["killswitchpass"] = true;
				else
					util_error("The webzone is down for updating. Give me a few chromosomes. &lt;3 JerBear + bobic");
			}
		}
		
		//For cookie (stay) login
		if(!$_SESSION["loggedin"] && !empty($_COOKIE["stay_auth"]) && !empty($_COOKIE["stay_id"]))
		{
            //Possible error: can't login to database
            $db = util_mysqli_login();
			if($db->connect_error)
				return;
			
			//Possible error: unknown ID
			if(!util_get_idexists($db, $_COOKIE["stay_id"]))
			    return;
			
			//Possible error: can't prepare statement
			$prepare = $db->prepare("SELECT accounts.username, accounts.passhash, secrets.secret_stay FROM accounts LEFT JOIN secrets ON accounts.id = secrets.userid WHERE accounts.id = ?");
			if(!$prepare)
			    return;
			
			$prepare->bind_param("s", $_COOKIE["stay_id"]);
			$prepare->execute();
			$prepare->bind_result($username, $passhash, $secret);
			$prepare->fetch();
			$prepare->close();
			
            if($_COOKIE["stay_auth"] == hash("sha256", $secret . $passhash))
            {
                $_SESSION["username"] = $username;
			    $_SESSION["loggedin"] = true;
			    
			    $expire = time() + 60 * 60 * 24 * 365;
            }
            else
            {
                $expire = 1;
            }
            
            setcookie("stay_auth", $_COOKIE["stay_auth"], $expire, "/");
            setcookie("stay_id",  $_COOKIE["stay_id"], $expire, "/");
        }
		
		
		//For app login
		if(!$_SESSION["loggedin"] && (!empty($_GET["userid"]) || !empty($_GET["username"])) && !empty($_GET["authcode"]))
		{
			//Possible error: can't login to database
			$db = util_mysqli_login();
			if($db->connect_error)
				util_error("SERVER ERROR: Couldn't connect to database");
			
			if(!empty($_GET["userid"])){ //TODO DELETE DIS
			//Possible error: unknown ID
			if(!util_get_idexists($db, $_GET["userid"]))
				util_error("Unknown ID");
			
			//Possible error: can't get username
	        $username = util_get_iduser($db, $_GET["userid"]);
	        if(empty($username))
		        util_error("SERVER ERROR: Couldn't get username");}else{
			//Possible error: unknown username
			if(!util_get_userexists($db, $_GET["username"]))
				util_error("Unknown username");
				
			//Possible error: can't get user ID
	        $userid = util_get_userid($db, $_GET["username"]);
	        if($userid == -1)
		        util_error("SERVER ERROR: Couldn't get user ID");
		    
		    $_GET["userid"] = $userid;
		    $username = $_GET["username"];}
			
			//Possible error: can't prepare statement
			$prepare = $db->prepare("SELECT secret_chat FROM secrets WHERE userid = ?");
			if(!$prepare)
				util_error("SERVER ERROR: Failed to prepare statement while checking authcode");
			
			$prepare->bind_param("i", $_GET["userid"]);
			$prepare->execute();
			$prepare->bind_result($secret);
			$prepare->fetch();
			$prepare->close();
			
			//Possible error: no secret
			if(empty($secret))
				util_error("Authcode error (try loggin out and back in)");
			
			for($i = 600; $i > -600; $i--)
			{
				if(strcmp(hash("md5", $secret . (time() + $i)), $_GET["authcode"]) == 0)
				{
					$_SESSION["loggedin"] = true;
					$_SESSION["username"] = $username;
					$db->close();
					return;
				}
			}
			
			//Possible error: failed to auth
			util_error("Authcode error (try loggin out and back in) " . $_GET["authcode"]);
		}
	}
	
	function util_gen_secret()
	{
	    $characters = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$charactersLength = strlen($characters);
		
		$secret = "";
		for($i = 0; $i < 500; $i++)
		    $secret .= $characters[rand(0, $charactersLength - 1)];
		
		return $secret;
	}
	
	function util_include_get($script)
	{
		define("blocked", true);
		require_once $_SERVER["DOCUMENT_ROOT"] . $script;
	}
	
	//Prevent direct access to a file
	function util_include_set()
	{
		if(!defined("blocked"))
		{
			header("HTTP/1.0 403 Forbidden");
			util_error("403 - Access denied");
		}
	}
	
	function util_error($error)
	{
		die("<font color=\"red\">" . $error . "</font>");
	}
	
	function util_warn($warning)
	{
		echo "<font color=\"red\">" . $warning . "</font>";
	}
	
	//Adds color and bold formatting to username
	function util_format_user($user, $color, $clickname)
	{
		$userfmt = "<b>" . $user . "</b>";
		$onclick = $clickname ? " onclick=\"clickName('" . $user . "')\"" : ""; 
		
		if(strcasecmp($color, "rainbow") == 0)
			return "<font" . $onclick . " color=\"Blue\" class=\"rainbow\">" . $userfmt . "</font>";
		else if((empty($color) || strcasecmp($color, "black") == 0) && empty($onclick))
			return $userfmt;
		else if(empty($color) || strcasecmp($color, "black") == 0)
			return "<font" . $onclick . ">" . $userfmt . "</font>";
		else
			return "<font" . $onclick . " color=\"" . $color . "\">" . $userfmt . "</font>";
	}
	
	function util_verify_color($color)
	{
		$valid = array("black", "blue", "cyan", "darkorange", "dodgerblue", "gold", "gray", "grey", "green", "maroon", "magenta", "navy", "pink", "purple", "rainbow", "saddlebrown", "springgreen", "red");
		return in_array($color, $valid);
	}
	
	function util_verify_captcha()
	{
		if(!empty($_POST["g-recaptcha-response"]))
		{
			$curl_handle=curl_init();
			curl_setopt($curl_handle, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify?secret=" . util_captcha_secret() . "&remoteIP=" . $_SERVER["REMOTE_ADDR"] . "&response=" . $_POST["g-recaptcha-response"]);
			curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
	
			$response = curl_exec($curl_handle);
			curl_close($curl_handle);
			
			$json = json_decode($response, true);
			return $json["success"];
		}
		else
		{
			return false;
		}
	}
	
	function util_echo_sideads()
	{
		echo util_getad_side("left") . "\n		" . util_getad_side("right") . "\n";
	}
	
	//--------------------API--------------------\\
	
	function util_get_userid($db, $username)
	{
		//Possible error: unknown username
		if(!util_get_userexists($db, $username))
			return -1;
		
		//Possible error: can't prepare statement
		$prepare = $db->prepare("SELECT id FROM accounts WHERE BINARY username = ?");
		if(!$prepare)
			return -1;
		
		$prepare->bind_param("s", $username);
		$prepare->execute();
		$prepare->bind_result($id);
		$prepare->fetch();
		$prepare->close();
		
		if(empty($id))
			return -1;
		
		return $id;
	}
	
	function util_get_iduser($db, $id)
	{
		//Possible error: unknown ID
		if(!util_get_idexists($db, $id))
			return "";
		
		//Possible error: can't prepare statement
		$prepare = $db->prepare("SELECT username FROM accounts WHERE id = ?");
		if(!$prepare)
			return "";
		
		$prepare->bind_param("i", $id);
		$prepare->execute();
		$prepare->bind_result($username);
		$prepare->fetch();
		$prepare->close();
		
		return $username;
	}
	
	function util_get_userlevel($db, $username)
	{
		//Possible error: unknown username
		if(!util_get_userexists($db, $username))
			return -1;
		
		//Possible error: can't prepare statement
		$prepare = $db->prepare("SELECT level FROM accounts WHERE BINARY username = ?");
		if(!$prepare)
			return -1;
		
		$prepare->bind_param("s", $username);
		$prepare->execute();
		$prepare->bind_result($level);
		$prepare->fetch();
		$prepare->close();
		
		if(empty($level) && $level != 0)
			return -1;
		
		return $level;
	}
	
	function util_get_usercolor($db, $username)
	{
		//Possible error: unknown username
		if(!util_get_userexists($db, $username))
			return "black";
		
		//Possible error: can't prepare statement
		$prepare = $db->prepare("SELECT color FROM accounts WHERE BINARY username = ?");
		if(!$prepare)
			return "black";
		
		$prepare->bind_param("s", $username);
		$prepare->execute();
		$prepare->bind_result($color);
		$prepare->fetch();
		$prepare->close();
		
		if(empty($color))
			return "black";
		else
			return $color;
	}
	
	function util_get_userexists($db, $username)
	{
		//Possible error: can't prepare statement
		$prepare = $db->prepare("SELECT username FROM accounts WHERE BINARY username = ?");
		if(!$prepare)
			return false;
		
		//Possible error: unknown username
		$prepare->bind_param("s", $username);
		$prepare->execute();
		$prepare->bind_result($result);
		$prepare->fetch();
		$prepare->close();
		
		return !empty($result);
	}
	
	function util_get_idexists($db, $id)
	{
		//Possible error: can't prepare statement
		$prepare = $db->prepare("SELECT username FROM accounts WHERE id = ?");
		if(!$prepare)
			return false;
		
		//Possible error: unknown username
		$prepare->bind_param("i", $id);
		$prepare->execute();
		$prepare->bind_result($result);
		$prepare->fetch();
		$prepare->close();
		
		return !empty($result);
	}
	
	if(!empty($_GET["dumpid"]))
	{
		util_session_start();
		
		//Possible error: can't login to database
		$db = util_mysqli_login();
		if($db->connect_error)
			die(json_encode(array("error" => "SERVER ERROR: Couldn't connect to database")));
		
		//Possible error: unknown ID
		if(!util_get_idexists($db, $_GET["dumpid"]))
			die(json_encode(array("error" => "Unknown ID")));
		
		$json["id"] = (int) $_GET["dumpid"];
		$json["username"] = util_get_iduser($db, $_GET["dumpid"]);
		$json["level"] = util_get_userlevel($db, $json["username"]);
		$json["color"] = util_get_usercolor($db, $json["username"]);
		die(json_encode($json));
	}
	else if(!empty($_GET["dumpuser"]))
	{
		util_session_start();
		
		//Possible error: can't login to database
		$db = util_mysqli_login();
		if($db->connect_error)
			die(json_encode(array("error" => "SERVER ERROR: Couldn't connect to database")));
		
		//Possible error: unknown ID
		if(!util_get_userexists($db, $_GET["dumpuser"]))
			die(json_encode(array("error" => "Unknown username")));
		
		$json["id"] = util_get_userid($db, $_GET["dumpuser"]);
		$json["username"] = $_GET["dumpuser"];
		$json["level"] = util_get_userlevel($db, $_GET["dumpuser"]);
		$json["color"] = util_get_usercolor($db, $_GET["dumpuser"]);
		die(json_encode($json));
	}
?>
