<?php require_once $_SERVER["DOCUMENT_ROOT"] . "util.php"; util_session_start(); ?>
<html>
	<head>
		<title>Unicorn Friends - Chat</title>
		<link rel="shortcut icon" href="/favicon.ico" />
		<link rel="stylesheet" type="text/css" href="/style.css" />
		<script src="https://www.gstatic.com/firebasejs/live/3.0/firebase.js"></script>
		<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
		<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
  ga('create', 'UA-76974324-2', 'auto');
  ga('send', 'pageview');

</script>
	</head>
	<body>
		<?php util_echo_sideads(); ?>
		<div class="wrapper">
			<div class="content">
				<?php util_include_get("header.php"); ?>
				<h1>Chat<br /></h1><br />
				<a href="javascript:popup('/chat/help')">Help</a><br /><br />
				New chat loader is a WIP
				<table>
					<tr>
						<td>
							<div class="chatbox" id="chatbox"></div>
						</td>
						<td class="chat">
							<div class="chatonline">
								<h3>Online Accounts</h3>
								<input type="checkbox" id="hide" onclick="sendOnline()">Invisible
								<br /><br />
								<div id="online"></div>
							</div>
						</td>
					</tr>
				</table>
				<br />
				<?php
					if($_SESSION["loggedin"])
					{
				?>
<input type="text" id="msg" size="50" maxlength="200">
				<input type="button" id="chatbutton" onclick="sendChat()" value="Spam"> <span id="msgreturn"></span>
				<br /><br />
				<form id="uploadform">
					Image uploader (max 5 MB):<br />
					<input type="file" name="file" id="file" accept="image/*"/>
					<input type="button" value="Spam" id="filebutton"> <span id="uploadreturn"></span>
				</form>
				<br />
				<?php
					}
				?>
Maximum lines (up to 100): <input type="number" id="limit" min="1" max="100" value="20"><br /><br />
				Chat archives (starting on <?php echo util_get_chatstart(); ?>):
				<input type="date" id="date" value="<?php echo date("Y-m-d"); ?>">
				<input type="submit" value="Search" onclick="searchArchive()"><br /><br />
				<!--<iframe src="http://unicornfriends.net:8080/index.html" width="800px" height="375px"></iframe>-->
			</div>
		</div>
		<div class="footer">
			<?php util_include_get("footer.php"); ?>
		</div>
		<script src="/script.js"></script>
		<script src="/chat/chat.js"></script>
	</body>
</html>
