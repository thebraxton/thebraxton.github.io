<?php
    require_once $_SERVER["DOCUMENT_ROOT"] . "util.php";
    util_session_start();
    
    if(!$_SESSION["loggedin"])
        util_include_set();
?>
Password:<br />
<input type="password" name="pass1" maxlength="20" /><br />
Repeat password:<br />
<input type="password" name="pass2" maxlength="20" /><br /><br />