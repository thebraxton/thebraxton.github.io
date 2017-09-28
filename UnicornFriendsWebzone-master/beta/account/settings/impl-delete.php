<?php
	require_once $_SERVER["DOCUMENT_ROOT"] . "util.php";
	util_session_start();
	
	function error_redirect($error)
	{
		header("Location: " . util_get_domain() . "account/settings/?error=" . $error);
		exit;
	}
	
	//Possible error: not logged in
	if(!$_SESSION["loggedin"])
		error_redirect("");
	
	//Possible error: robot
	if(!util_verify_captcha())
		error_redirect("Failed reCAPTCHA (are you a robot?)");
	
	//Possible error: can't login to database
	$db = util_mysqli_login();
	if($db->connect_error)
		error_redirect("SERVER ERROR: Couldn't connect to database");
	
	//Possible error: can't get user ID
    $userid = util_get_userid($db, $_SESSION["username"]);
	if($userid == -1)
		error_redirect("SERVER ERROR: Couldn't get user ID");
	
	//Possible error: can't prepare statement
	$prepare = $db->prepare("DELETE FROM secrets WHERE userid = ?");
	if(!$prepare)
	    error_redirect("SERVER ERROR: Couldn't prepare statement while deleting secret");
	
	$prepare->bind_param("i", $userid);
    $prepare->execute();
	$prepare->close();
	
	//Possible error: can't prepare statement
	$prepare = $db->prepare("DELETE FROM accounts WHERE BINARY username = ?");
	if(!$prepare)
		error_redirect("SERVER ERROR: Couldn't prepare statement while deleting account");
	
	$prepare->bind_param("s", $_SESSION["username"]);
	$prepare->execute();
	$prepare->close();
	
	$db->close();
	
	if(!empty($_COOKIE["stay_auth"]) || !empty($_COOKIE["stay_id"]))
	{
	    setcookie("stay_auth", $_COOKIE["stay_auth"], 1, "/");
        setcookie("stay_id", $_COOKIE["stay_id"], 1, "/");
	}
	
	$_SESSION["loggedin"] = false;
	header("Location: " . util_get_domain() . "?delete=1");
?>