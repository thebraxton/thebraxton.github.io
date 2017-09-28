<?php require_once $_SERVER["DOCUMENT_ROOT"] . "util.php"; util_session_start(); ?>
<html>
	<head>
		<title>Unicorn Friends - AskNed</title>
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
				<h1>AskNed</h1><br />
				<?php
					if(!empty($_GET["error"]))
						echo "<font color=\"red\">" . $_GET["error"] . "</font><br /><br />\n				";
					
					if($_SESSION["loggedin"])
					{
						//Possible error: can't login to database
						$db = util_mysqli_login();
						if($db->connect_error)
							util_error("SERVER ERROR: Couldn't connect to database");
						
						//Possible error: can't get user ID
						$userid = util_get_userid($db, $_SESSION["username"]);
						if($userid == -1)
							util_error("SERVER ERROR: Couldn't get user ID");
						
						//Possible error: can't prepare statement
						$prepare = $db->prepare("SELECT userid, question FROM askned WHERE userid = ?");
						if(!$prepare)
							util_error("SERVER ERROR: Couldn't prepare statement while retrieving question");
						
						$prepare->bind_param("i", $userid);
						$prepare->execute();
						$prepare->bind_result($result, $question);
						$prepare->fetch();
						$prepare->close();
						
						$db->close();
						
						if(!empty($result))
						{
							echo "Your question: \"" . $question . "\" (<a href=\"/askned/delete.php\">Delete</a>)<br /><br />\n";
						}
				?>
<form action="/askned/send.php" method="post">
					Ask Ned a question: <input type="text" name="question" size="50" maxlength="200">
					<input type="submit" value="Ask">
				</form>
<?php
					}
					else
					{
						echo "<a href=\"/account/login\">Login to ask a question</a>\n";
					}
				?>
				<br /><br />
				<a href="/askned/viewall">View all questions</a>
			</div>
		</div>
		<div class="footer">
			<?php util_include_get("footer.php"); ?>
		</div>
		<script src="/script.js"></script>
	</body>
</html>
