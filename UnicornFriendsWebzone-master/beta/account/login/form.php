<?php require_once $_SERVER["DOCUMENT_ROOT"] . "util.php"; util_include_set(); ?>
<form action="/account/login/impl-web.php" method="post">
					Username:<br />
					<input type="text" name="username" maxlength="20" /><br />
					Password:<br />
					<input type="password" name="pass" maxlength="20" /><br /><br />
					<input type="checkbox" name="stay" checked>Stay logged in<br /><br />
					<input type="submit" value="Login" />
				</form>
