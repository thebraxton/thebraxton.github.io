<?php
	require_once $_SERVER["DOCUMENT_ROOT"] . "util.php";
	util_session_start();
	
	function error_redirect($error)
	{
		header("Location: " . util_get_domain() . "askned/?error=" . $error);
		exit;
	}
	
	//Possible error: not logged in
	if(!$_SESSION["loggedin"])
		error_redirect("Not logged in");
	
	//Possible error: make sure all inputs are filled out
	if(empty($_POST["question"]))
		error_redirect("Are you gonna fill it out or not?");
	
	$_POST["question"] = trim(preg_replace("/\s+/", " ", htmlentities(substr($_POST["question"], 0, 200))));
	
	//Possible error: can't login to database
	$db = util_mysqli_login();
	if($db->connect_error)
		error_redirect("SERVER ERROR: Couldn't connect to database");
	
	//Possible error: can't get user ID
	$userid = util_get_userid($db, $_SESSION["username"]);
	if($userid == -1)
		error_redirect("SERVER ERROR: Couldn't get user ID");
	
	//Possible error: can't prepare statement
	$prepare = $db->prepare("SELECT userid FROM askned WHERE userid = ?");
	if(!$prepare)
		error_redirect("SERVER ERROR: Couldn't prepare statement while retrieving question");
	
	$prepare->bind_param("i", $userid);
	$prepare->execute();
	$prepare->bind_result($result);
	$prepare->fetch();
	$prepare->close();
	
	if(empty($result))
	{
		//Possible error: can't prepare statement
		$prepare = $db->prepare("INSERT INTO askned (userid, question) VALUES (?, ?)");
		if(!$prepare)
			error_redirect("SERVER ERROR: Couldn't prepare statement while inserting question");
		
		$prepare->bind_param("is", $userid, $_POST["question"]);
	}
	else
	{
		//Possible error: can't prepare statement
		$prepare = $db->prepare("UPDATE askned SET question = ? WHERE userid = ?");
		if(!$prepare)
			error_redirect("SERVER ERROR: Couldn't prepare statement while updating question");
		
		$prepare->bind_param("si", $_POST["question"], $userid);
	}
	
	$prepare->execute();
	$prepare->close();
	
	$db->close();
	header("Location: " . util_get_domain() . "askned");
?>
