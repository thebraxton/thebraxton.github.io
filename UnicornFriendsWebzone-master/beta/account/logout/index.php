<?php
    require_once $_SERVER["DOCUMENT_ROOT"] . "util.php";
    util_session_start();
    
    if($_SESSION["loggedin"])
	{
	    if(!empty($_COOKIE["stay_auth"]) || !empty($_COOKIE["stay_id"]))
	    {
	        setcookie("stay_auth", $_COOKIE["stay_auth"], 1, "/");
            setcookie("stay_id", $_COOKIE["stay_id"], 1, "/");
	    }
	
		$_SESSION["loggedin"] = false;
		$success = true;
	}
	else
	{
		$success = false;
	}
?>
<html>
	<head>
		<title>Unicorn Friends - Logout</title>
		<link rel="shortcut icon" href="/favicon.ico" />
		<link rel="stylesheet" type="text/css" href="/style.css" />
		<script src="https://www.gstatic.com/firebasejs/live/3.0/firebase.js"></script>
		<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
	</head>
	<body>
		<?php util_echo_sideads(); ?>
		<div class="wrapper">
			<div class="content">
				<?php
					util_include_get("header.php");
					echo "				<h1>Logout</h1><br />\n";
					if($success)
						echo "				<p><font color=\"green\">OKAY BYE.</font></p><br />\n";
					else
						echo "				<p><font color=\"red\">Pro tip: in order to logout, you need to be logged in.</font></p><br />\n";
				?>
			</div>
		</div>
		<div class="footer">
			<?php util_include_get("footer.php"); ?>
		</div>
		<script src="/script.js"></script>
	</body>
</html>