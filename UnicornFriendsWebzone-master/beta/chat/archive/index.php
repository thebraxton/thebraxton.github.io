<?php require_once $_SERVER["DOCUMENT_ROOT"] . "util.php"; util_session_start(); ?>
<html>
	<head>
		<title>Unicorn Friends - Chat Archive</title>
		<link rel="shortcut icon" href="/favicon.ico" />
		<link rel="stylesheet" type="text/css" href="/style.css">
	</head>
	<body>
		<div class="wrapper">
			<div class="content">
				<h1>Chat log for "<?php $_GET["date"] = trim(htmlspecialchars($_GET["date"])); echo $_GET["date"]; ?>"</h1><br />
				<p>Note: if your timezone isn't GMT you might get results from a different day</p><br />
				<div class="archive">
<?php
						//Possible error: no date selected
						$_GET["date"] = trim(htmlspecialchars($_GET["date"]));
						if(empty($_GET["date"]))
							util_error("No date selected");
						
						//Possible error: can't login to database
						$db = util_mysqli_login();
						if($db->connect_error)
							util_error("SERVER ERROR: Couldn't connect to database");
						
						$ismod = $_SESSION["loggedin"] && (util_get_userlevel($db, $_SESSION["username"]) == 2);
						$timestamp = $_GET["date"] . "%";
						
						if(!$_SESSION["loggedin"])
						{
							//Possible error: can't prepare statement
							$prepare = $db->prepare("SELECT timestamp, msg, shownto FROM chatlog WHERE BINARY (shownto = ? AND timestamp LIKE ?) ORDER BY id ASC");
							if(!$prepare)
								util_error("SERVER ERROR: Couldn't prepare statement while retrieving chat log for non-account"  . $db->error);
							
							$stempty = "";
							$prepare->bind_param("ss", $stempty, $timestamp);
						}
						else
						{
							if(!$ismod)
							{
								//Possible error: can't get user ID
								$userid = util_get_userid($db, $_SESSION["username"]);
								if($userid == -1)
									util_error("SERVER ERROR: Couldn't get user ID");
							
								//Possible error: can't prepare statement
								$prepare = $db->prepare("SELECT timestamp, msg, shownto FROM chatlog WHERE BINARY ((shownto = ? OR shownto LIKE ? OR userid = ?) AND shownto NOT LIKE ? AND timestamp LIKE ?) ORDER BY id ASC");
								if(!$prepare)
									util_error("SERVER ERROR: Couldn't prepare statement while retrieving chat log for regular account" . $db->error);
								
								$stempty = "";
								$stid = "% ". $userid." %";
								$stdel = "% -1 %";
								$prepare->bind_param("ssiss", $stempty, $stid, $userid, $stdel, $timestamp);
							}
							else
							{
								//Possible error: can't prepare statement
								$prepare = $db->prepare("SELECT timestamp, msg, shownto FROM chatlog WHERE BINARY timestamp LIKE ? ORDER BY id ASC");
								if(!$prepare)
									util_error("SERVER ERROR: Couldn't prepare statement while retrieving chat log for mod" . $db->error);
								
								$prepare->bind_param("s", $timestamp);
							}
						}
						
						$prepare->execute();
						$prepare->bind_result($timestamp, $msg, $shownto);
						
						$empty = true;
						while($prepare->fetch())
						{
							$empty = false;
							
							$time = new DateTime($timestamp);
							$time->setTimezone(new DateTimeZone(timezone_name_from_abbr("", $_GET["tzoff"], $_GET["tzdst"])));
							$timefmt = $time->format("n-j-y g:i:s A");
							
							if(!empty($shownto))
                    		{
			                    //Possible error: can't login to database
		                    	$db2 = util_mysqli_login();
	                	    	if($db2->connect_error)
	                	    		util_error("SERVER ERROR: Couldn't connect to database");
		                    	
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
                		    }
                		    
                		    //Bonus feature not in help
                		    if($_SESSION["loggedin"] && !$ismod)
                		    {
                		        $msg = preg_replace_callback("/(?:^|(?<=\s))@me(?:$|(?=[^[:alnum:]\-_]))/i", function($user)
                	    	    {
                	    	        //Possible error: can't login to database
	                		        $db2 = util_mysqli_login();
	                		        if($db2->connect_error)
	                			        util_error("SERVER ERROR: Couldn't connect to database");
	                		        
	                	            return util_format_user("@" . $_SESSION["username"], util_get_usercolor($db2, $_SESSION["username"]), true);
	                	        }, $msg);
	                	    }
							
							echo "					" . $timefmt . " " . $msg . "<br />\n";
						}
						
						$prepare->close();
						
						if($empty)
							echo "					<font color=\"red\">Empty log</font>\n";
						
						$db->close();
					?>
				</div>
			</div>
		</div>
		<div class="footer">
			<?php util_include_get("footer.php"); ?>
		</div>
	</body>
</html>