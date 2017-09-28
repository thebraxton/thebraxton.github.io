<?php require_once $_SERVER["DOCUMENT_ROOT"] . "util.php"; util_session_start(); ?>
<html>
	<head>
		<title>Unicorn Friends - Chat Help</title>
		<link rel="shortcut icon" href="/favicon.ico" />
		<link rel="stylesheet" type="text/css" href="/style.css">
	</head>
	<body>
		<div class="wrapper">
			<div class="content">
				<h1>Chat Help</h1><br />
				<h3>Rules</h3><br />
				<ul>
					<li>No spamming</li>
					<li>Don't get me arrested (eg. no kiddie porn)</li>
					<li>Insulting Shrek will result in a permaban, because Shrek is love/life.</li>
				</ul>
				<br />
				<h3>Stuff to know</h3><br />
				<ul>
					<li>Messages can be up to <b>200</b> characters long</li>
					<li><span class="rainbow">Hitler Youth members are rainbow.</span> <a href="/chat/verify.php">Click here to apply for Hitler Youth.</a></li>
					<li>Usernames are cAsE-sEnSiTiVe and the @ symbol in front is optional when using commands</li>
					<li>Click on a username to send a private message</li>
					<li>Ctrl+click on a username to @ them</li>
				</ul>
				<br />
				<h3>Commands</h3><br />
				<table>
					<tr>
						<th>Command</th>
						<th>Example</th>
						<th>Output</th>
					</tr>
					<tr>
						<td>/me [action]<br />Shows you doing [action]</td>
						<td>/me loves ALL kids!</td>
						<td align="center"><i><span class="rainbow"><b>JerBear</b> loves ALL kids!</span></i></td>
					</tr>
					<tr>
						<td>/mes [action]<br />Shows you doing [action], with " 's " after your name</td>
						<td>/mes gonna make you some cummies</td>
						<td align="center"><i><span class="rainbow"><b>JerBear</b>'s gonna make you some cummies</span></i></td>
					</tr>
					<tr>
						<td>/rickroll [filename]<br />Fake-uploads an image called [filename] that rickrolls you</td>
						<td>/rickroll mycoolimage.jpg</td>
						<td align="center"><span class="rainbow"><b>JerBear</b></span>: Uploaded file: <a href="/redirect.php">mycoolimage.jpg</a></td>
					</tr>
					<tr>
						<td>/leakip<br />Publicly broadcast your IP address</td>
						<td>/leakip</td>
						<td align="center"><span class="rainbow"><b>JerBear</b></span>: My IP address is 192.168.0.69. PLS HACK ME</td>
					</tr>
					<tr>
						<td>/getip [username]<br />Get [username]'s IP address<br />[username] is optional and defaults to your own username<br />Only mods can see another account's IP address</td>
						<td>/getip </td>
						<td align="center"><span class="rainbow"><b></b></span>'s IP address is 127.0.0.1</td>
					</tr>
					<tr>
						<td>/rank [username] [level]<br />Get [username]'s rank<br />[username] is optional and defaults to your own username<br />Only mods can change rank using [level]<br />-1 = banned (Jew), 0 = other (Mexican), 1 = verified (Hitler Youth), 2 = mod (Gestapo)</td>
						<td>/rank </td>
						<td align="center"><span class="rainbow"><b></b></span> is rank level 2 (mod).</td>
					</tr>
					<tr>
						<td>/ban [username]<br />Ban [username], alias of "/rank [username] -1"<br />Mods only</td>
						<td>/ban spammer</td>
						<td align="center"><span class="rainbow"><b>JerBear</b></span> set <font color="red"><b>spammer</b></font> to rank level -1 (banned) from rank level 0 (other).</td>
					</tr>
					<tr>
						<td>/color [username] [color]<br />Set [username]'s color to [color]<br />[username] is optional and defaults to your own username<br />Only mods can change another account's color<br />Valid colors: black, blue, cyan, darkorange, dodgerblue, gold, gray, grey, green, maroon, magenta, navy, pink, purple, rainbow, saddlebrown, springgreen, red</td>
						<td>/color blue</td>
						<td align="center"><span class="rainbow"><b>JerBear</b></span> changed <font color="blue"><b>JerBear</b></font>'s color.</td>
					</tr>
					<tr>
						<td>/msg [recipients] [message]<br />/message [recipients] [message]<br />Privately send [message] to [recipients]<br />[recipients] are separated by commas (no spaces)<br />Mods can read ALL private messages</td>
						<td>/msg ,spammer I hate both of you</td>
						<td align="center">(to <span class="rainbow"><b></b></span>, <font color="red"><b>spammer</b></font>) <span class="rainbow"><b>JerBear</b></span>: I hate both of you</td>
					</tr>
					<tr>
						<td>/afk [reason]<br />Announce and mark yourself as AFK (away from keyboard) in the online accounts list<br />[reason] is optional and defaults to "Away from keyboard"</td>
						<td>/afk Fap break</td>
						<td align="center"><span class="rainbow"><b>JerBear</b></span> is AFK: Fap break</td>
					</tr>
					<tr>
						<td>/brb<br />Alias of "/afk Be right back"</td>
						<td>/brb</td>
						<td align="center"><span class="rainbow"><b>JerBear</b></span> is AFK: Be right back</td>
					</tr>
					<tr>
						<td>/toggle [id]<br />Toggle between deleting and undeleting message #[id]<br />Mods only</td>
						<td>/toggle 69</td>
						<td align="center">(No output)</td>
					</tr>
					<tr>
						<td>/say [message]<br />Says [message] in bold print with no username<br />Mods only</td>
						<td>/say Hitler did nothing wrong &lt;nazi&gt;</td>
						<td align="center"><b>Hitler did nothing wrong &#x5350;</b></td>
					</tr>
				</table>
				<br />
				<h3>Formatting</h3><br />
				<table>
					<tr>
						<th>Tag</th>
						<th>Example</th>
						<th>Output</th>
					</tr>
					<tr>
						<td align="center">&lt;lenny&gt;</td>
						<td align="center">Touch me, JerBear &lt;lenny&gt;</td>
						<td align="center">Touch me, JerBear <span class="cancelcs">( &#x0361;&#x00B0; &#x035C;&#x0296; &#x0361;&#x00B0;)</span></td>
					</tr>
					<tr>
						<td align="center">&lt;nazi&gt;<br />&lt;swastika&gt;</td>
						<td align="center">HEIL HITLER &lt;nazi&gt;</td>
						<td align="center"><span class="cancelcs">HEIL HITLER &#x5350;</span></td>
					</tr>
					<tr>
						<td align="center">&lt;mods&gt;</td>
						<td align="center">The mods on this webzone are basically nazis &lt;mods&gt;</td>
						<td align="center">The mods on this webzone are basically nazis <span class="cancelcs">-( &#x0361;&#x00B0; &#x035C;&#x0296; &#x0361;&#x00B0;)&#x256F;&#x2572;___&#x5350;&#x5350;&#x5350;&#x5350;</span></td>
					</tr>
					<tr>
						<td align="center">&lt;shrug&gt;</td>
						<td align="center">IDFK &lt;shrug&gt;</td>
						<td align="center">IDFK <span class="cancelcs">&#x00AF;\_(&#x30C4;)_/&#x00AF;</span></td>
					</tr>
					<tr>
						<td align="center">&lt;shades1&gt;</td>
						<td align="center">I have swag &lt;shades1&gt;</td>
						<td align="center">I have swag <span class="cancelcs">(&#8976;&#9632;_&#9632;)</span></td>
					</tr>
					<tr>
						<td align="center">&lt;shades2&gt;</td>
						<td align="center">I have double swag &lt;shades2&gt;</td>
						<td align="center">I have double swag <span class="cancelcs">( &bull;_&bull;)>&#8976;&#9632;-&#9632;</span></td>
					</tr>
					<tr>
						<td align="center">&lt;shades3&gt;</td>
						<td align="center">I have quadruple swag &lt;shades3&gt;</td>
						<td align="center">I have quadruple swag <span class="cancelcs">(&bull;_&bull;) ( &bull;_&bull;)>&#8976;&#9632;-&#9632; (&#8976;&#9632;_&#9632;)</span></td>
					</tr>
					<tr>
						<td align="center">&lt;heart&gt;</td>
						<td align="center">Hearts are hard to type so I use tags &lt;heart&gt;</td>
						<td align="center">Hearts are hard to type so I use tags &lt;3</td>
					</tr>
					<tr>
						<td align="center">&lt;ip&gt;</td>
						<td align="center">Secret Jew HQ: &lt;ip&gt;</td>
						<td align="center">Secret Jew HQ: 172.31.22.127</td>
					</tr>
					<tr>
						<td align="center">&lt;tm&gt;</td>
						<td align="center">REACT&lt;tm&gt;</td>
						<td align="center">REACT&trade;</td>
					</tr>
					<tr>
						<td align="center">&lt;b&gt;Bold&lt;/b&gt;</td>
						<td align="center">&lt;b&gt;This message is bold&lt;/b&gt;</td>
						<td align="center"><b>This message is bold</b></td>
					</tr>
					<tr>
						<td align="center">&lt;u&gt;Underline&lt;/u&gt;</td>
						<td align="center">&lt;u&gt;This message is underlined&lt;/u&gt;</td>
						<td align="center"><u>This message is underlined</u></td>
					</tr>
					<tr>
						<td align="center">&lt;s&gt;Strikethrough&lt;/s&gt;</td>
						<td align="center">&lt;s&gt;This message is crossed out&lt;/s&gt;</td>
						<td align="center"><s>This message is crossed out</s></td>
					</tr>
					<tr>
						<td align="center">&lt;i&gt;Italics&lt;/i&gt;</td>
						<td align="center">&lt;i&gt;This message is italic&lt;/i&gt;</td>
						<td align="center"><i>This message is italic</i></td>
					</tr>
					<tr>
						<td align="center">&lt;c&gt;Cancel Comic Sans&lt;/c&gt;</td>
						<td align="center">&lt;c&gt;This message is less meme&lt;/c&gt;</td>
						<td align="center"><span class="cancelcs">This message is less meme</span></td>
					</tr>
					<tr>
						<td align="center">&lt;color:[color]:[text]&gt;</td>
						<td align="center">&lt;color:blue:This message is blue&gt;</td>
						<td align="center"><font color="blue">This message is blue</font></td>
					</tr>
					<tr>
						<td align="center">&lt;color:[hex]:[text]&gt;<br /># in front of hex is optional</td>
						<td align="center">&lt;color:#00FF00:This message is green&gt;</td>
						<td align="center"><font color="#00FF00">This message is green</font></td>
					</tr>
					<tr>
						<td align="center">&lt;color:rainbow:[text]&gt;</td>
						<td align="center">&lt;color:rainbow:This message is rainbow&gt;</td>
						<td align="center"><span class="rainbow">This message is rainbow</span></td>
					</tr>
					<tr>
						<td align="center">&lt;url:[url]:[text]&gt;<br />&lt;link:[url]:[text]&gt;</td>
						<td align="center">&lt;url:https://google.com/:Look it up yourself&gt;</td>
						<td align="center"><a href="https://google.com/" target="_blank">Look it up yourself</a></td>
					</tr>
					<tr>
						<td align="center">&lt;url:rickroll:[text]&gt;<br />&lt;link:rickroll:[text]&gt;</td>
						<td align="center">&lt;url:rickroll:Not a rickroll&gt;</td>
						<td align="center"><font color="#00FF00"><a href="/redirect.php" target="_blank">Not a rickroll</a></font></td>
					</tr>
					<tr>
						<td align="center">Tagless URL<br />(Note: doesn't work if you already have a url/link tag)</td>
						<td align="center">Look it up yourself https://google.com/</td>
						<td align="center">Look it up yourself <a href="https://google.com/" target="_blank">https://google.com/</a></td>
					</tr>
					<tr>
						<td align="center">Greentext</td>
						<td align="center">&gt;realize you're looking at a hard-gay black man</td>
						<td align="center"><font color="green">&gt;realize you're looking at a hard-gay black man</font></td>
					</tr>
					<tr>
						<td align="center">Format a username so you can use it in commands</td>
						<td align="center">@JerBear<br />or Ctrl+click a username</td>
						<td align="center"><span class="rainbow"><b>@JerBear</b></span></td>
					</tr>
				</table>
			</div>
		</div>
		<div class="footer">
			<?php util_include_get("footer.php"); ?>
		</div>
	</body>
</html>
