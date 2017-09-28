<?php
    require_once $_SERVER["DOCUMENT_ROOT"] . "util.php";
    util_session_start();
    
    if(!$_SESSION["loggedin"])
        util_include_set();
?>
Username color:<br />
<input type="radio" name="color" value="black">&block;&block; Black<br />
<input type="radio" name="color" value="gray"><font color="gray">&block;&block; Gray/Grey</font><br />
<input type="radio" name="color" value="green"><font color="green">&block;&block; Green</font><br />
<input type="radio" name="color" value="springgreen"><font color="springgreen">&block;&block; Spring Green</font><br />
<input type="radio" name="color" value="cyan"><font color="cyan">&block;&block; Cyan</font><br />
<input type="radio" name="color" value="dodgerblue"><font color="dodgerblue">&block;&block; Dodger Blue</font><br />
<input type="radio" name="color" value="blue"><font color="blue">&block;&block; Blue</font><br />
<input type="radio" name="color" value="navy"><font color="navy">&block;&block; Navy</font><br />
<input type="radio" name="color" value="purple"><font color="purple">&block;&block; Purple</font><br />
<input type="radio" name="color" value="magenta"><font color="magenta">&block;&block; Magenta</font><br />
<input type="radio" name="color" value="pink"><font color="pink">&block;&block; Pink</font><br />
<input type="radio" name="color" value="saddlebrown"><font color="saddlebrown">&block;&block; Saddle Brown</font><br />
<input type="radio" name="color" value="maroon"><font color="maroon">&block;&block; Maroon</font><br />
<input type="radio" name="color" value="red"><font color="red">&block;&block; Red</font><br />
<input type="radio" name="color" value="darkorange"><font color="darkorange">&block;&block; Dark Orange</font><br />
<input type="radio" name="color" value="gold"><font color="gold">&block;&block; Gold</font><br />
<br /><br />
