<?php require_once $_SERVER["DOCUMENT_ROOT"] . "util.php"; util_session_start(); ?>
<html>
	<head>
		<title>Unicorn Friends - AskNed - View All</title>
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
				<h1>AskNed - View All</h1><br />
				<a href="/askned">Back</a><br /><br />
				<table>
					<tr>
						<th>Username</th>
						<th>Question</th>
					</tr>
<?php
						//Possible error: can't login to database
						$db = util_mysqli_login();
						if($db->connect_error)
							util_error("SERVER ERROR: Couldn't connect to database");
						
						//Possible error: can't login to database
						$db2 = util_mysqli_login();
						if($db2->connect_error)
							util_error("SERVER ERROR: Couldn't connect to database");
						
						//Possible error: can't prepare statement
						$prepare = $db->prepare("SELECT userid, question FROM askned");
						if(!$prepare)
							util_error("SERVER ERROR: Couldn't prepare statement while retrieving question");
						
						$prepare->bind_param("i", $userid);
						$prepare->execute();
						$prepare->bind_result($userid, $question);
						
						while($prepare->fetch())
						{
							$user = util_get_iduser($db2, $userid);
							if(empty($user))
								$userfmt = "*UNKNOWN USER*";
							else
								$userfmt = util_format_user($user, util_get_usercolor($db2, $user), false);
							
							echo "					<tr><td>" . $userfmt . "</td><td>" . $question . "</td></tr>\n";
						}
						
						$prepare->close();
						
						$db2->close();
						$db->close();
					?>
				</table>
			</div>
		</div>
		<div class="footer">
			<?php util_include_get("footer.php"); ?>
		</div>
		<script src="/script.js"></script>
	</body>
</html>
