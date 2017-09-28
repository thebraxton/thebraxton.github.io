<?php require_once $_SERVER["DOCUMENT_ROOT"] . "util.php"; util_session_start(); ?>
<html>
	<head>
		<title>Unicorn Friends - Register</title>
		<link rel="shortcut icon" href="/favicon.ico" />
		<link rel="stylesheet" type="text/css" href="/style.css" />
		<script src="https://www.gstatic.com/firebasejs/live/3.0/firebase.js"></script>
		<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
		<script src="https://www.google.com/recaptcha/api.js"></script>
	</head>
	<body>
		<?php util_echo_sideads(); ?>
		<div class="wrapper">
			<div class="content">
				<?php util_include_get("header.php"); ?>
				<h1>Register</h1><br />
				<?php
					if($_SESSION["loggedin"])
					{
						echo "<p><font color=\"red\">You're already logged in, ya doingus.</font></p><br />\n";
					}
					else
					{
						if(!empty($_GET["error"])) echo "<p><font color=\"red\">" . strip_tags($_GET["error"]) . "</font></p><br />\n				";
						require_once "form.php";
					}
				?>
			</div>
		</div>
		<div class="footer">
			<?php util_include_get("footer.php"); ?>
		</div>
		<script src="/script.js"></script>
	</body>
</html>
