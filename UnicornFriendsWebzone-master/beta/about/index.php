<?php require_once $_SERVER["DOCUMENT_ROOT"] . "util.php"; util_session_start(); ?>
<html>
	<head>
		<title>Unicorn Friends - About Us</title>
		<link rel="shortcut icon" href="/favicon.ico" />
		<link rel="stylesheet" type="text/css" href="/style.css" />
		<script src="https://www.gstatic.com/firebasejs/live/3.0/firebase.js"></script>
		<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
	</head>
	<body>
		<?php util_echo_sideads(); ?>
		<div class="wrapper">
			<div class="content">
				<?php util_include_get("header.php"); ?>
				<h1>About Us</h1><br />
				<p>The Unicorn Friends are a team of highly retarded individuals who have bonded together to create the most autistic web content the world has ever seen. Here is a list of our members:</p><br />
				<table>
					<tr>
						<th>Name + Picture</th>
						<th>Join Date</th>
						<th>Defining Characteristics</th>
						<th>Social Medias</th>
					</tr>
					<tr>
						<td align="center">JerBear<br /><img src="/about/jerbear.jpg" width="150px" /></td>
						<td>March 15, 2015</td>
						<td>
							<ul>
								<li>Missing 37 chromosomes</li>
								<li>Stage 5 terminal autism</li>
								<li>Lord of the unicorns</li>
							</ul>
						</td>
						<td>
							<ul>
								<li><a href="http://youtube.com/jerbearschannel" target="_blank">RedTube</a></li>
								<li><a href="http://instagram.com/jerbear3.14" target="_blank">Instagroimp</a></li>
								<li><a href="http://twitter.com/jerbear314159" target="_blank">Twiffer</a></li>
							</ul>
						</td>
					</tr>
					<tr>
						<td align="center">Mrs. Giraffe<br /><img src="/about/giraffe.jpg" width="150px" /></td>
						<td>March 15, 2015</td>
						<td>
							<ul>
								<li>Loves whipped cream more than Kanye loves Kanye</li>
								<li>Isn't actually a giraffe</li>
							</ul>
						</td>
						<td>
							<ul>
								<li><a href="http://www.youtube.com/channel/UC7jQtifEqB43Zr5gwHveI5Q" target="_blank">RedTube</a></li>
								<li><a href="http://instagram.com/edgar_allan_dope" target="_blank">Instagroimp</a></li>
							</ul>
						</td>
					</tr>
					<tr>
						<td align="center">Lolly<br /><img src="/about/lolly.jpg" width="150px" /></td>
						<td>March 15, 2015</td>
						<td>
							<ul>
								<li>Goes through 3.6 boyfriends and 2.3 girlfriends per hour</li>
								<li><a href="http://youtube.com/watch?v=pzEDeVp5A4o" target="_blank">Single female lawyer (having lots of secks)</a></li>
							</ul>
						</td>
						<td>
							<ul>
								<li><a href="http://www.youtube.com/channel/UC0VV9_KNRqxe__YLzpXWbKg" target="_blank">RedTube</a></li>
								<li><a href="http://instagram.com/rad___brad" target="_blank">Instagroimp</a></li>
							</ul>
						</td>
					</tr>
					<tr>
						<td align="center">Spacaconda<br /><img src="/about/spacaconda.jpg" width="150px" /></td>
						<td>June 11, 2015</td>
						<td>
							<ul>
								<li>World's last and greatest snake from outer space</li>
								<li>Pro gamer</li>
								<li>Born June 6, 2015</li>
							</ul>
						</td>
						<td>N/A</td>
					</tr>
					<tr>
						<td align="center">Ned<br /><img src="/about/ned.jpg" width="150px" /></td>
						<td>July 22, 2015</td>
						<td>
							<ul>
								<li>Not really a member; just likes to hijack JerBear's channel once in a while</li>
								<li>Greatest dancer the world has ever seen</li>
								<li>Probably gay</li>
							</ul>
						</td>
						<td>N/A</td>
					</tr>
					<tr>
						<td align="center">Penguin Man<br /><img src="/about/penguin.jpg" width="150px" /></td>
						<td>August 23, 2015</td>
						<td>
							<ul>
								<li>Loves KFC</li>
								<li>Known for being the front end of Box Monster</li>
								<li>Feet also make an appearance at 6:55 in the Shrek video</li>
							</ul>
						</td>
						<td>
							<ul>
								<li><a href="http://instagram.com/joshy.theboss" target="_blank">Instagroimp</a></li>
								<li><a href="http://youtube.com/channel/UCJQ1TgLJMHfHfFTo3Ti01RQ" target="_blank">RedTube</a></li>
								<li>Gamertag: i forgot lol xd</li>
							</ul>
						</td>
					</tr>
					<tr>
						<td align="center">Super Fart<br /><img src="/about/fart.jpg" width="150px" /></td>
						<td>August 23, 2015</td>
						<td>
							<ul>
								<li>Leads a rich inner life</li>
								<li>Known for being the back end of Box Monster</li>
							</ul>
						</td>
						<td>
							<ul>
								<li><a href="http://youtube.com/channel/UCgm5b4cMchwRDV_TRfOTEWQ" target="_blank">RedTube</a></li>
								<li>Gamertag: i forgot lol xd</li>
							</ul>
						</td>
					</tr>
					<tr>
						<td align="center">Mr. Wheelchair<br /><img src="/about/wheelchair.jpg" width="150px" /></td>
						<td>November 13, 2015</td>
						<td>
							<ul>
								<li>Routinely gets smacked around with Shrek posters</li>
								<li>Can't walk</li>
							</ul>
						</td>
						<td>
							<ul>
								<li>Gamertag: i forgot lol xd</li>
							</ul>
						</td>
					</tr>
					<tr>
						<td align="center">Joey<br /><img src="/about/joey.jpg" width="150px" /></td>
						<td>November 21, 2015</td>
						<td>
							<ul>
								<li>Only in it for the cake</li>
								<li>Bi</li>
							</ul>
						</td>
						<td>
							<ul>
								<li>Uhhhh...pretty sure he has...something...I think. Do you want his number? He's single.</li>
							</ul>
						</td>
					</tr>
					<tr>
						<td align="center">YuriDicMilk<br /><img src="/about/dicmilk.jpg" width="150px" /></td>
						<td>March 18, 2016</td>
						<td>
							<ul>
								<li>Spider-Man's gay cousin</li>
								<li><a href="http://youtube.com/user/danmaninc" target="_blank">Gator</a>'s favorite meme</li>
							</ul>
						</td>
						<td>
							<ul>
								<li><a href="http://youtube.com/channel/UCKenOD_MdesqSrPyn6xDfcA" target="_blank">RedTube</a></li>
								<li><a href="http://twitter.com/YuriDicMilk" target="_blank">Twiffer</a></li>
								<li><a href="http://facebook.com/YuriDicMilk" target="_blank">FaceBarf</a></li>
							</ul>
						</td>
					</tr>
					<tr>
						<td align="center">RaebRej<br /><img src="/about/raebrej.jpg" width="150px" /></td>
						<td>March 18, 2016</td>
						<td>
							<ul>
								<li>Refused to be nicknamed Chubby Chubbles</li>
								<li>Master Chef</li>
							</ul>
						</td>
						<td>
							<ul>
								<li><a href="http://youtube.com/channel/UCoF-_j7WJKRaP4_hAZ_EPHQ" target="_blank">RedTube</a></li>
								<li><a href="http://instagram.com/logn_pratt" target="_blank">Instagroimp</a></li>
							</ul>
						</td>
					</tr>
					<tr>
						<td align="center">Indiana Chromes<br /><img src="/about/chromes.jpg" width="150px" /></td>
						<td>March 18, 2016</td>
						<td>
							<ul>
								<li>Living dank meme</li>
								<li>Chef in training</li>
								<li>Dade: RaebRej, Mome: Monica, Psychiatrist: Stacy</li>
							</ul>
						</td>
						<td>
							<ul>
								<li><a href="http://illuminatiofficial.org" target="_blank">Owns the Illuminati</a></li>
							</ul>
						</td>
					</tr>
					<tr>
						<td align="center">Ritz Daddy<br /><img src="/about/ritz.jpg" width="150px" /></td>
						<td>April 13, 2016</td>
						<td>
							<ul>
								<li>Gets all teh ladies</li>
								<li>Eats honey-flavored deodorant</li>
							</ul>
						</td>
						<td>
							<ul>
								<li><a href="http://instagram.com/jmoneyisthebombdiggity" target="_blank">Instagroimp</a></li>
							</ul>
						</td>
					</tr>
					<tr>
						<td align="center">I Hate Everything<br /><img src="/about/ihe.jpg" width="150px" /></td>
						<td>June 9, 2016</td>
						<td>
							<ul>
								<li>Way swaggier than JerBear will ever be</li>
								<li>Hates Mars Bars and Jews the most</li>
							</ul>
						</td>
						<td>
							<ul>
								<li><a href="http://youtube.com/IHEOfficial" target="_blank">RedTube</a></li>
								<li><a href="http://twitter.com/IHE_OFFICIAL" target="_blank">Twiffer</a></li>
								<li><a href="http://www.facebook.com/IHateEverythingOfficial/" target="_blank">FaceBarf</a></li>
							</ul>
						</td>
					</tr>
					<tr>
						<td align="center">Gay Hipster Squid<br /><img src="/about/squid.png" width="150px" /></td>
						<td>July 1, 2016</td>
						<td>
							<ul>
								<li>Gay</li>
								<li>Hipster</li>
								<li>Squid</li>
							</ul>
						</td>
						<td>N/A</td>
					</tr>
				</table>
			</div>
		</div>
		<div class="footer">
			<?php util_include_get("footer.php"); ?>
		</div>
		<script src="/script.js"></script>
	</body>
</html>
