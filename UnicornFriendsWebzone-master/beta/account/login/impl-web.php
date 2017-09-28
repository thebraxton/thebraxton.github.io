<?php
	require_once $_SERVER["DOCUMENT_ROOT"] . "util.php";
	util_session_start();
	
	function error_redirect($error)
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
	if(empty($_POST["username"]) || empty($_POST["pass"]))
		error_redirect("Are you gonna fill it out or not?");
	
	//Possible error: can't login to database
	$db = util_mysqli_login();
	if($db->connect_error)
		error_redirect("SERVER ERROR: Couldn't connect to database");
	
	//Possible error: can't prepare statement
	$prepare = $db->prepare("SELECT passhash, id FROM accounts WHERE BINARY username = ?");
	if(!$prepare)
		error_redirect("SERVER ERROR: Couldn't prepare statement while checking account");
	
	//Possible error: unknown username
	$prepare->bind_param("s", $_POST["username"]);
	$prepare->execute();
	$prepare->bind_result($passhash, $userid);
	$prepare->fetch();
	$prepare->close();
	
	if(empty($passhash))
		error_redirect("Unknown username");
	
	//Possible error: incorrect password
	if(!password_verify($_POST["pass"], $passhash))
		error_redirect("Incorrect password");
	
	if($_POST["stay"])
	{
    	//Possible error: can't prepare statement
	    $prepare = $db->prepare("SELECT userid FROM secrets WHERE userid = ?");
	    if(!$prepare)
		    error_redirect("SERVER ERROR: Couldn't prepare statement while checking secret");
	    
	    $prepare->bind_param("i", $userid);
	    $prepare->execute();
	    $prepare->bind_result($result);
    	$prepare->fetch();
    	$prepare->close();
		
		if(empty($result))
		{
		    //Possible error: can't prepare statement
		    $prepare = $db->prepare("INSERT INTO secrets (secret_stay, userid) VALUES (?, ?)");
		    if(!$prepare)
		    	error_redirect("SERVER ERROR: Couldn't prepare statement while adding secret");
		}
		else
		{
		    //Possible error: can't prepare statement
		    $prepare = $db->prepare("UPDATE secrets SET secret_stay = ? WHERE userid = ?");
		    if(!$prepare)
			    error_redirect("SERVER ERROR: Couldn't prepare statement while updating secret");
		}
		
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
    
	//Possible error: can't prepare statement
	$prepare = $db->prepare("UPDATE accounts SET ip = ? WHERE BINARY username = ?");
	if(!$prepare)
		error_redirect("SERVER ERROR: Couldn't prepare statement while logging IP");
	
	$prepare->bind_param("ss", $_SERVER["REMOTE_ADDR"], $_POST["username"]);
	$prepare->execute();
	$prepare->close();
	
	$db->close();
	success_redirect();
?>
