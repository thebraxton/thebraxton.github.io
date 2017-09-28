<?php
	require_once $_SERVER["DOCUMENT_ROOT"] . "util.php";
	util_session_start();
	
	function error_redirect($error)
	{
		header("Location: " . util_get_domain() . "account/register/?error=" . $error);
		exit;
	}
	
	function error_redirect_login($error)
	{
		header("Location: " . util_get_domain() . "account/login/?error=" . $error);
		exit;
	}
	
	function success_redirect()
	{
		header("Location: " . util_get_domain() . "?login=1");
		exit;
	}
	
	if($_SESSION["loggedin"]) success_redirect();
	
	//Possible error: make sure all inputs are filled out
	if(empty($_POST["username"]) || empty($_POST["pass1"]) || empty($_POST["pass2"]))
		error_redirect("Are you gonna fill it out or not?");
	
	//Possible error: invalid color
	if(!util_verify_color($_POST["color"]))
		error_redirect("Invalid color: \"" . $_POST["color"] . "\"");
	
	if(strcasecmp($_POST["color"], "black") == 0)
		$_POST["color"] = "";
	
	//Possible error: color is rainbow
	if(strcasecmp($_POST["color"], "rainbow") == 0)
		error_redirect("Rainbow is reserved for verified accounts");
	
	//Possible error: passwords don't match
	if(strcmp($_POST["pass1"], $_POST["pass2"]) != 0)
		error_redirect("Passwords don't match");
	
	//Possible error: too long
	if(strlen($_POST["username"]) > 20 || strlen($_POST["pass1"]) > 20)
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
		error_redirect("Username taken");
	
	//Possible error: can't prepare statement
	$prepare = $db->prepare("INSERT INTO accounts (username, passhash, color, ip) VALUES (?, ?, ?, ?)");
	if(!$prepare)
		error_redirect("SERVER ERROR: Couldn't prepare statement while registering");
	
	$passhash = password_hash($_POST["pass1"], PASSWORD_BCRYPT);
		
	$prepare->bind_param("ssss", $_POST["username"], $passhash, $_POST["color"], $_SERVER["REMOTE_ADDR"]);
	$prepare->execute();
	$prepare->close();
	
	if($_POST["stay"])
	{
    	//Possible error: can't get user ID
    	$userid = util_get_userid($db, $_POST["username"]);
	    if($userid == -1)
		    error_redirect_login("SERVER ERROR: Couldn't log in after registering: couldn't get user ID");
		
		//Possible error: can't prepare statement
		$prepare = $db->prepare("INSERT INTO secrets (secret_stay, userid) VALUES (?, ?)");
		if(!$prepare)
		    error_redirect_login("SERVER ERROR: Couldn't log in after registering: couldn't prepare statement while adding secret");
		
		$secret = util_gen_secret();
		
		$prepare->bind_param("si", $secret, $userid);
		$prepare->execute();
		$prepare->close();
		
		$expire = time() + 60 * 60 * 24 * 365;
		setcookie("stay_auth", hash("sha256", $secret . $passhash), $expire, "/");
        setcookie("stay_id", $userid, $expire, "/");
	}
	else
	{
	    $_SESSION["loggedin"] = true;
        $_SESSION["username"] = $_POST["username"];
	}
	
	$db->close();
	success_redirect();
?>
