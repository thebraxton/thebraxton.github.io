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
	
	//Possible error: can't login to database
	$db = util_mysqli_login();
	if($db->connect_error)
		error_redirect("SERVER ERROR: Couldn't connect to database");
	
	//Possible error: can't get user ID
	$userid = util_get_userid($db, $_SESSION["username"]);
	if($userid == -1)
		error_redirect("SERVER ERROR: Couldn't get user ID");
	
	//Possible error: can't prepare statement
	$prepare = $db->prepare("DELETE FROM askned WHERE userid = ?");
	if(!$prepare)
		error_redirect("SERVER ERROR: Couldn't prepare statement while deleting question");
	
	$prepare->bind_param("i", $userid);
	$prepare->execute();
	$prepare->close();
	
	$db->close();
	header("Location: " . util_get_domain() . "askned");
?>
