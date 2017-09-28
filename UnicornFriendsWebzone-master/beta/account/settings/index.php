<?php require_once $_SERVER["DOCUMENT_ROOT"] . "util.php"; util_session_start(); ?>
<html>
	<head>
		<title>Unicorn Friends - Settings</title>
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
				<h1>Account Settings</h1><br />
				<?php
					if(!$_SESSION["loggedin"])
					{
						echo "<p><font color=\"red\">You're not logged in, ya doingus.</font></p><br />\n			";
					}
					else
					{
						if(!empty($_GET["error"])) echo "<p><font color=\"red\">" . strip_tags($_GET["error"]) . "</font></p><br />\n				";
						else if(!empty($_GET["success"])) echo "<p><font color=\"green\">" . strip_tags($_GET["success"]) . "</font></p><br />\n				";
				?>
<input type="radio" name="setting" onclick="getForm('username')" checked>Change username<br />
				<input type="radio" name="setting" onclick="getForm('password')">Change password<br />
				<input type="radio" name="setting" onclick="getForm('color')">Change color<br />
				<input type="radio" name="setting" onclick="getForm('reset')">Log out everywhere (reset auth key)<br />
				<input type="radio" name="setting" onclick="getForm('delete')">Delete account<br /><br />
				<form id="form" method="post">
					<div id="formdata"></div>
					<div class="g-recaptcha" data-sitekey="<?php echo util_captcha_site(); ?>"></div><br />
					<input type="submit" value="Update" />
				</form>
			<?php
					}
				?>
</div>
		</div>
		<div class="footer">
			<?php util_include_get("footer.php"); ?>
		</div>
		<script src="/script.js"></script>
		<script src="/account/settings/getform.js"></script>
	</body>
</html>
