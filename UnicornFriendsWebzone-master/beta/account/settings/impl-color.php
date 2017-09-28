<?php
	require_once "../../util.php";
	util_session_start();
	
	function error_redirect($error)
	{
		header("Location: " . util_get_domain() . "account/settings/?error=" . $error);
		exit;
	}
	
	function success_redirect($success)
	{
		header("Location: " . util_get_domain() . "account/settings/?success=" . $success);
		exit;
	}
	
	//Possible error: not logged in
	if(!$_SESSION["loggedin"])
		error_redirect("");
	
	//Possible error: invalid color
	if(!util_verify_color($_POST["color"]))
		error_redirect("Invalid color: \"" . $_POST["color"] . "\"");
	
	if(strcasecmp($_POST["color"], "black") == 0)
		$_POST["color"] = "";
	
	//Possible error: robot
	if(!util_verify_captcha())
		error_redirect("Failed reCAPTCHA (are you a robot?)");
	
	//Possible error: can't login to database
	$db = util_mysqli_login();
	if($db->connect_error)
		error_redirect("SERVER ERROR: Couldn't connect to database");
	
	$rank = util_get_userlevel($db, $_SESSION["username"]);
	
	//Possible error: verified account changing colors
	if($rank > 0 && strcasecmp($_POST["color"], "rainbow") != 0)
		error_redirect("Verified usernames must be rainbow");
	
	//Possible error: non-verified account changing to rainbow
	if($rank <= 0 && strcasecmp($_POST["color"], "rainbow") == 0)
		error_redirect("Rainbow is reserved for verified accounts");
	
	//Possible error: can't prepare statement
	$prepare = $db->prepare("UPDATE accounts SET color = ? WHERE BINARY username = ?");
	if(!$prepare)
		error_redirect("SERVER ERROR: Couldn't prepare statement while changing username color");
	
	$prepare->bind_param("ss", $_POST["color"], $_SESSION["username"]);
	$prepare->execute();
	$prepare->close();
	
	$db->close();
	success_redirect("Username color changed");
?>