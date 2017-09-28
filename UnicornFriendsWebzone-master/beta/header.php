<?php require_once $_SERVER["DOCUMENT_ROOT"] . "util.php"; util_include_set(); ?>
<div align="center">
					<?php echo util_getad_center() . "\n"; ?>
					<a href="/"><img src="/logo.png" /></a>
					<b>OVER <?php util_include_get("downloads/get-count.php"); echo get_downcount("rickroll"); ?> RICKROLLED</b><br /><br />
					<span id="header-main">
						<a href="/about">About Us</a>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
						<a href="/downloads">Downloads</a>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
						<?php
								echo "<a href=\"/chat\">Chat</a>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;\n";
						?>
						<a href="https://jerbear.spreadshirt.com" target="_blank">Merch</a>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
						<a href="javascript:headerAccount()">Account</a>
					</span>
					<span id="header-account">
						<a href="javascript:headerMain()">Back</a>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
						<a href="/askned">AskNed</a>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
						<?php
							if(!$_SESSION["loggedin"])
							{
								echo "<a href=\"/account/login\">Login</a>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;\n";
								echo "					<a href=\"/account/register\">Register</a>\n";
							}
							else
							{
								echo "<a href=\"/account/settings\">Settings</a>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;\n";
								echo "					<a href=\"/account/logout\">Logout</a>\n";
							}
						?>
					</span>
					<br />
				</div>
				<br />
