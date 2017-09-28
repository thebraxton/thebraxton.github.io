<?php require_once $_SERVER["DOCUMENT_ROOT"] . "util.php"; util_include_set(); ?>
<form action="/account/register/impl.php" method="post">
					Username:<br />
					<input type="text" name="username" maxlength="20" /><br />
					Password:<br />
					<input type="password" name="pass1" maxlength="20" /><br />
					Repeat password:<br />
					<input type="password" name="pass2" maxlength="20" /><br /><br />
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
					<input type="checkbox" name="stay" checked>Stay logged in<br /><br />
					<div class="g-recaptcha" data-sitekey="<?php echo util_captcha_site(); ?>"></div><br />
					<input type="submit" value="Register" />
				</form>
