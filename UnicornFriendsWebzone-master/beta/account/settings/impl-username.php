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
	if(empty($_POST["username"]))
		error_redirect("Are you gonna fill it out or not?");
	
	//Possible error: too long
	if(strlen($_POST["username"]) > 20)
		error_redirect("Too long");
	
    //Possible error: invalid characters in username
	if(preg_match("/^[[:alnum:]\-_]+$/", $_POST["username"]) == 0)
		error_redirect("Username can only contain letters, numbers, underscores (_), or hyphens (-).");
	
	//Possible error: "me" as username
	if(strcasecmp($_POST["username"], "me") == 0)
	    error_redirect("The username \"me\" is used internally and can't be taken.");
	
	//Possible error: robot
	if(!util_verify_captcha())
		error_redirect("Failed reCAPTCHA (are you a robot?)");
	
	//Possible error: can't login to database
	$db = util_mysqli_login();
	if($db->connect_error)
		error_redirect("SERVER ERROR: Couldn't connect to database");
	
	//Possible error: username taken
	if(util_get_userexists($db, $_POST["username"]))
		error_redirect("USER ERROR: Username taken");
	
	//Possible error: can't prepare statement
	$prepare = $db->prepare("UPDATE accounts SET username = ? WHERE BINARY username = ?");
	if(!$prepare)
		error_redirect("SERVER ERROR: Couldn't prepare statement while changing username");
	
	$prepare->bind_param("ss", $_POST["username"], $_SESSION["username"]);
	$prepare->execute();
	$prepare->close();
	
	$_SESSION["username"] = $_POST["username"];
	
	$db->close();
	success_redirect("Username changed to " . $_POST["username"]);
?>