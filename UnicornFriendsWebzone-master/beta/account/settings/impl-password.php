<?php
	require_once $_SERVER["DOCUMENT_ROOT"] . "util.php";
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
	
	//Possible error: make sure all inputs are filled out
	if(empty($_POST["pass1"]) || empty($_POST["pass2"]))
		error_redirect("Are you gonna fill it out or not?");
	
	//Possible error: passwords don't match
	if(strcmp($_POST["pass1"], $_POST["pass2"]) != 0)
		error_redirect("Passwords don't match");
	
	//Possible error: too long
	if(strlen($_POST["pass1"]) > 20)
		error_redirect("Too long");
	
	//Possible error: robot
	if(!util_verify_captcha())
		error_redirect("Failed reCAPTCHA (are you a robot?)");
	
	//Possible error: can't login to database
	$db = util_mysqli_login();
	if($db->connect_error)
		error_redirect("SERVER ERROR: Couldn't connect to database");
	
	//Possible error: can't prepare statement
	$prepare = $db->prepare("UPDATE accounts SET passhash = ? WHERE BINARY username = ?");
	if(!$prepare)
		error_redirect("SERVER ERROR: Couldn't prepare statement while changing password");
	
	$hash = password_hash($_POST["pass1"], PASSWORD_BCRYPT);
	$prepare->bind_param("ss", $hash, $_SESSION["username"]);
	$prepare->execute();
	$prepare->close();
	
	$db->close();
	success_redirect("Password changed");
?>