<?php
	require_once $_SERVER["DOCUMENT_ROOT"] . "util.php";
	util_session_start();
	
	//Possible error: make sure all inputs are filled out
	if(/*empty($_POST["app"]) ||*/ empty($_POST["username"]) || empty($_POST["pass"]))
		util_error("Are you gonna fill it out or not?");
	
	//Possible error: can't login to database
	$db = util_mysqli_login();
	if($db->connect_error)
		util_error("SERVER ERROR: Couldn't connect to database");
	
	if(!empty($_POST["app"])){ //TODO GET RID OF DIS
	//Possible error: can't prepare statement
	$prepare = $db->prepare("SELECT COLUMN_NAME FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ? AND COLUMN_NAME = ?");
	if(!$prepare)
		util_error("SERVER ERROR: Couldn't prepare statement while checking app");
	
	//Possible error: unknown app
	$table_schema = util_mysqli_dbname();
	$table_name = "secrets";
	$column_name = "secret_" . $_POST["app"];
	
	$prepare->bind_param("sss", $table_schema, $table_name, $column_name);
	$prepare->execute();
	$prepare->bind_result($exists);
	$prepare->fetch();
	$prepare->close();
	
	if(empty($exists))
		util_error("Unknown app: \"" . $_POST["app"] . "\"");}else $column_name = "secret_chat";
	
	//Possible error: can't prepare statement
	$prepare = $db->prepare("SELECT passhash, id FROM accounts WHERE BINARY username = ?");
	if(!$prepare)
		util_error("SERVER ERROR: Couldn't prepare statement while checking account");
	
	//Possible error: unknown username
	$prepare->bind_param("s", $_POST["username"]);
	$prepare->execute();
	$prepare->bind_result($passhash, $userid);
	$prepare->fetch();
	$prepare->close();
	
	if(empty($passhash))
		util_error("Unknown username");
	
	//Possible error: incorrect password
	if(!password_verify($_POST["pass"], $passhash))
		util_error("Incorrect password");
	
	//Possible error: can't prepare statement
	$prepare = $db->prepare("SELECT userid FROM secrets WHERE userid = ?");
	if(!$prepare)
	    util_error("SERVER ERROR: Couldn't prepare statement while checking secret");
	
	$prepare->bind_param("i", $userid);
	$prepare->execute();
	$prepare->bind_result($result);
    $prepare->fetch();
    $prepare->close();
	
	if(empty($result))
	{
	    //Possible error: can't prepare statement
	    $prepare = $db->prepare("INSERT INTO secrets (secret_chat, userid) VALUES (?, ?)");
	    if(!$prepare)
	    	util_error("SERVER");
	}
	else
	{
	    //Possible error: can't prepare statement
	    $prepare = $db->prepare("UPDATE secrets SET " . $column_name . " = ? WHERE userid = ?"); //potentially unsafe? mebby?
	    if(!$prepare)
		    util_error("SERVER ERROR: Couldn't prepare statement while updating secret");
	}
	
	$secret = util_gen_secret();
	
	$prepare->bind_param("si", $secret, $userid);
	$prepare->execute();
    $prepare->close();
    
	echo "KEYBEGIN" . $secret . "KEYEND";
    $db->close();
?>
