<?php
	require_once $_SERVER["DOCUMENT_ROOT"] . "util.php";
	util_session_start();
	
	//Possible error: not logged in
	if(!$_SESSION["loggedin"])
		util_error("Not logged in");
	
	//Possible error: no file selected
	if(empty($_FILES["file"]["tmp_name"]))
		util_error("Upload failed");
	
	$src_name = str_replace(" ", "_", trim($_FILES["file"]["name"]));
	$src_name = str_replace(":", "-", $src_name);
	
	$target_dir = util_get_uploaddir();
	$target_name = $_SESSION["username"] . "-" . date("YmdHis") . "-" . $src_name;
	$target_file = $target_dir . $target_name;
	
	//Possible error: file name too long
	if(strlen($src_name) > 50)
		util_error("File name too long (max 50 characters)");
	
	//Possible error: not an image
	$check = getimagesize($_FILES["file"]["tmp_name"]);
	if($check === false)
		util_error("Image files only");
	
	//Possible error: too large
	if($_FILES["file"]["size"] > 5242880)
		util_error("File too large");
	
	//Possilble error: couldn't move
	if(move_uploaded_file($_FILES["file"]["tmp_name"], $target_file))
	{
		$_POST["msg"] = "Uploaded file: <url:" . util_get_uploaddmn() . $target_name . ":" . $src_name . ">";
		util_include_get("chat/send-chat.php");
	}
	else
		util_error("SERVER ERROR: Failed to publish upload");
?>
