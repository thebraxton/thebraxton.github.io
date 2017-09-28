<?php require_once $_SERVER["DOCUMENT_ROOT"] . "util.php"; util_session_start(); ?>
<html>
	<head>
		<title>Unicorn Friends - Home</title>
		<link rel="shortcut icon" href="/favicon.ico" />
		<link rel="stylesheet" type="text/css" href="/style.css" />
		<script src="https://www.gstatic.com/firebasejs/live/3.0/firebase.js"></script>
		<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
	</head>
	<body>
		<?php util_echo_sideads(); ?>
		<div class="wrapper">
			<div class="content">
				<?php util_include_get("header.php"); ?>
				<h1>Home</h1><br />
				<?php
					if(!empty($_SESSION["username"]))
					{
						if($_GET["login"] && $_SESSION["loggedin"])
						{
							$db = util_mysqli_login();
							if($db->connect_error)
								$color = "black";
							else
								$color = util_get_usercolor($db, $_SESSION["username"]);
							
							$db->close();
							
							if(empty($color) || strcasecmp($color, "black") == 0)
								$color = "green";
						
							$username = util_format_user($_SESSION["username"], $color, false);
							echo "<p><font color=\"green\"> Congratulations on logging in, " . $username . ". You're a winner now. </font></p><br />\n				";
						}
						else if($_GET["delete"] && !$_SESSION["loggedin"])
						{
							echo "<p><font color=\"red\"> Goodbye forever, <b>" . $_SESSION["username"] . "</b>. It was nice knowing you. lol jk</font></p><br />\n				";
						}
                        else if($_GET["reset"] && !$_SESSION["loggedin"])
                        {
                            echo "<p><font color=\"green\">YAAAAAY you were logged out everywhere.</font></p><br />\n				";
                        }
					}
				?>
<p>Welcome to the official <b>UNICORN FRIENDS WEBZONE</b>. There are <s>many</s> very few things to do here. You can carefully study JerBear and the people he paid to pretend to be his friends. A large collection of high-quality MIDIs are freely available to download. Pick up an overpriced shirt from the official Unicorn Friends Spreadshirt store. Before you leave, remember to call Alex an intelligent African in the chat.</p>
				<br />
				<p>It's actually pretty sad and lonely here, but whatever. It's probably better to just browse a different webzone.</p><br />
				<p><a href="/redirect.php">Here's a way better webzone.</a></p><br />
				<div align="center">
					<h3>Our latest bideo:</h3>
					<?php
						$request = "https://www.googleapis.com/youtube/v3/search?part=snippet&channelId=UCToXQmCCoLanQWmDx-1S3PA&maxResults=1&order=date&type=video&key=" . util_server_key();
						$curl_handle = curl_init();
						curl_setopt($curl_handle, CURLOPT_URL, $request);
						curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
						
						$response = curl_exec($curl_handle);
						curl_close($curl_handle);
						
						$json = json_decode($response, true);
						echo "<iframe width=\"800\" height=\"450\" src=\"https://www.youtube.com/embed/" . $json["items"][0]["id"]["videoId"] ."\" frameborder=\"0\" allowfullscreen></iframe>\n";
				       ?>
				</div>
			</div>
		</div>
		<div class="footer">
			<?php util_include_get("footer.php"); ?>
		</div>
		<script src="/script.js"></script>
	</body>
</html>
