<?php
    require_once $_SERVER["DOCUMENT_ROOT"] . "util.php";
    util_session_start();
    
    if(!$_SESSION["loggedin"])
        util_include_set();
?>
Username:<br />
<input type="text" name="username" maxlength="20" /><br /><br />