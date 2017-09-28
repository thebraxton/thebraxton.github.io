<?php
	require_once $_SERVER["DOCUMENT_ROOT"] . "util.php";
	util_include_set();
	
	function get_downcount($name)
	{
		//Possible error: can't login to database
		$db = util_mysqli_login();
		if($db->connect_error)
			return "?";
		
		//Possible error: can't prepare statement
		$prepare = $db->prepare("SELECT downcount FROM downloads WHERE BINARY name = ?");
		if(!$prepare)
			return "?";
		
		$prepare->bind_param("s", $name);
		$prepare->execute();
		$prepare->bind_result($result);
		$prepare->fetch();
		$prepare->close();
		
		return strval($result);
	}
?>