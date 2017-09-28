<?php require_once $_SERVER["DOCUMENT_ROOT"] . "util.php"; util_session_start(); util_include_get("downloads/get-count.php"); ?>
<html>
	<head>
		<title>Unicorn Friends - Downloads</title>
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
				<h1>Downloads</h1><br />
				<p>Everything is free...so far....</p><br />
				<h2>Sections</h2><br />
				<ul>
					<li><a href="#musics">Musics</a></li>
					<li><a href="#games">Games</a></li>
				</ul>
				<br />
				<h3><a name="musics">Musics</a></h3><br />
				<p>Categories:</p><br />
				<ul>
					<li><b>Crap:</b> Miscellaneous mini songs (yes, I had to look up how to spell miscellaneous)</li>
					<li><b>Themes:</b> Theme songs of series</li>
					<li><b>Ned Sings:</b> One of Ned's covers</li>
					<li><b>Abandoned:</b> From an abandoned video idea</li>
					<li><b>Unused:</b> Might use it someday</li>
					<li><b>Remix:</b> Remix of a lol xd meme or whatever</li>
					<li><b>Rap Battle:</b> Potential new series?</li>
				</ul>
				<br />
				<table>
					<tr>
						<th>Name + URL</th>
						<th>File Info</th>
						<th>Description</th>
					</tr>
					<tr>
						<td align="center"><a href="/downloads/get-file.php?name=trombone farty fart">trombone farty fart</a></td>
						<td>
							<ul>
								<li>Created: June 11, 2015</li>
								<li>Format: WAV</li>
								<li>Size: 493.79 KB</li>
								<li>Length: 00:00:02.866</li>
								<li>Downloads: <?php echo get_downcount("trombone farty fart"); ?></li>
							</ul>
						</td>
						<td>
							<ul>
								<li>Used in video: <a href="http://www.youtube.com/watch?v=1wul3vNy1nk" target="_blank">JerBear and Spacaconda Play: Super Granny</a></li>
								<li>Category: Crap</li>
								<li>Created with: Trombone, GoldWave</li>
								<li>Looped trombone fart thing for comedic relief</li>
							</ul>
						</td>
					</tr>
					<tr>
						<td align="center"><a href="/downloads/get-file.php?name=Ned Chase">Ned Chase</a></td>
						<td>
							<ul>
								<li>Created: July 22, 2015</li>
								<li>Format: WAV</li>
								<li>Size: 579.69 KB</li>
								<li>Length: 00:00:03.365</li>
								<li>Downloads: <?php echo get_downcount("Ned Chase"); ?></li>
							</ul>
						</td>
						<td>
							<ul>
								<li>Used in video: <a href="http://www.youtube.com/watch?v=os7RuQU5wns" target="_blank">Epic Drone Adventure</a></li>
								<li>Category: Crap</li>
								<li>Created with: Noteflight, Microsoft GS Wavetable Synth, GoldWave</li>
								<li>I dunno, I guess Ned chased JerBear with this playing in the background, but that's about it.</li>
							</ul>
						</td>
					</tr>
					<tr>
						<td align="center"><a href="/downloads/get-file.php?name=Story Time Theme">Story Time Theme</a></td>
						<td>
							<ul>
								<li>Created: August 4, 2015</li>
								<li>Format: WAV</li>
								<li>Size: 1.36 MB</li>
								<li>Length: 00:00:08.092</li>
								<li>Downloads: <?php echo get_downcount("Story Time Theme"); ?></li>
							</ul>
						</td>
						<td>
							<ul>
								<li>Used in series: <a href="http://www.youtube.com/playlist?list=PLQ9rGE8NDTpkWCNMy9PBG7EVxsHJsk1lI" target="_blank">Story Time with JerBear</a></li>
								<li>Category: Themes</li>
								<li>Created with: Noteflight, Voice, Microsoft GS Wavetable Synth, PowerDirector, GoldWave</li>
								<li>The only theme song with lyrics because JerBear can't sing.</li>
							</ul>
						</td>
					</tr>
					<tr>
					<td align="center"><a href="/downloads/get-file.php?name=Spooky">Spooky</a></td>
						<td>
							<ul>
								<li>Created: August 16, 2015</li>
								<li>Format: WAV</li>
								<li>Size: 4.31 MB</li>
								<li>Length: 00:00:25.595</li>
								<li>Downloads: <?php echo get_downcount("Spooky"); ?></li>
							</ul>
						</td>
						<td>
							<ul>
								<li>Used in video: <a href="http://www.youtube.com/watch?v=NN9yWyvjvik" target="_blank">Derpy 12 Year Old Finds a Camera</a></li>
								<li>Category: Crap</li>
								<li>Created with: Noteflight, Microsoft GS Wavetable Synth, GoldWave</li>
								<li>This was redownloaded with KeepVid because I lost the ENTIRE video folder. The whole 2-hour digitalized tape was in there. Luckily, the best clips are still on YouTube. :c</li>
							</ul>
						</td>
					</tr>
					<tr>
						<td align="center"><a href="/downloads/get-file.php?name=Call Me Maybe">Call Me Maybe</a></td>
						<td>
							<ul>
								<li>Created: August 19, 2015</li>
								<li>Format: MP3</li>
								<li>Size: 1.36 MB</li>
								<li>Length: 00:03:12.653</li>
								<li>Downloads: <?php echo get_downcount("Call Me Maybe"); ?></li>
							</ul>
						</td>
						<td>
							<ul>
								<li>Used in video: <a href="http://www.youtube.com/watch?v=8vitR2UwmJg" target="_blank">Ned Sings - "Call Me Maybe"</a></li>
								<li>Category: Ned Sings</li>
								<li>Created with: KeepVid, Speakonia, PowerDirector, GoldWave</li>
								<li><a href="http://www.youtube.com/watch?v=v5psw84V8Xc">Original instrumental</a></li>
							</ul>
						</td>
					</tr>
					<tr>
						<td align="center"><a href="/downloads/get-file.php?name=Boo-Boo">Boo-Boo</a></td>
						<td>
							<ul>
								<li>Created: September 13, 2015</li>
								<li>Format: MP3</li>
								<li>Size: 1.33 MB</li>
								<li>Length: 00:00:58.175</li>
								<li>Downloads: <?php echo get_downcount("Boo-Boo"); ?></li>
							</ul>
						</td>
						<td>
							<ul>
								<li>Category: Abandoned</li>
								<li>Reason: Unfunny</li>
								<li>Created with: Noteflight, Microsoft GS Wavetable Synth, KeepVid, Renoise, GoldWave</li>
								<li>It would have been J+S Plays KidPix 3.0 Deluxe, with the undo baby singing. Also contains strange audio issues.</li>
								<li><a href="http://www.youtube.com/watch?v=f7DaVSdvEfQ" target="_blank">Original lyrics</a></li>
							</ul>
						</td>
					</tr>
					<tr>
						<td align="center"><a href="/downloads/get-file.php?name=Cooking Theme">Cooking Theme</a></td>
						<td>
							<ul>
								<li>Created: October 16, 2015</li>
								<li>Format: MP3</li>
								<li>Size: 370.46 KB</li>
								<li>Length: 00:00:15.830</li>
								<li>Downloads: <?php echo get_downcount("Cooking Theme"); ?></li>
							</ul>
						</td>
						<td>
							<ul>
								<li>Used in series: <a href="http://www.youtube.com/playlist?list=PLQ9rGE8NDTpnxramqVLbW3gqF3ZRo78tv" target="_blank">Cooking with JerBear</a></li>
								<li>Category: Themes</li>
								<li>Created with: Noteflight, Microsoft GS Wavetable Synth, GoldWave</li>
								<li>Uploaded almost a month later onto YouTube because PowerDirector broke</li>
							</ul>
						</td>
					</tr>
					<tr>
						<td align="center"><a href="/downloads/get-file.php?name=Shrek Posters">Shrek Posters</a></td>
						<td>
							<ul>
								<li>Created: November 13, 2015</li>
								<li>Format: WAV</li>
								<li>Size: 0.94 MB</li>
								<li>Length: 00:00:05.594</li>
								<li>Downloads: <?php echo get_downcount("Shrek Posters"); ?></li>
							</ul>
						</td>
						<td>
							<ul>
								<li>Used in video: <a href="http://www.youtube.com/watch?v=94iR6UhuVI4" target="_blank">JerBear and Spacaconda Play: Shrek 2 Activity Center</a></li>
								<li>Category: Crap</li>
								<li>Created with: Noteflight, Microsoft GS Wavetable Synth, GoldWave</li>
								<li>Great half-step apart chords</li>
							</ul>
						</td>
					</tr>
					<tr>
						<td align="center"><a href="/downloads/get-file.php?name=Sour 16">Sour 16</a></td>
						<td>
							<ul>
								<li>Created: November 9, 2015</li>
								<li>Format: WAV</li>
								<li>Size: 8.20 MB</li>
								<li>Length: 00:00:48.731</li>
								<li>Downloads: <?php echo get_downcount("Sour 16"); ?></li>
							</ul>
						</td>
						<td>
							<ul>
								<li>Used in video: <a href="http://www.youtube.com/watch?v=aPclel_rv6A" target="_blank">JerBear's Sweet 16 Party</a></li>
								<li>Category: Crap</li>
								<li>Created with: Noteflight</li>
								<li>I came with a lot of these names on the spot several months later. They were just called "Song" when I wrote them.</li>
							</ul>
						</td>
					</tr>
					<tr>
						<td align="center"><a href="/downloads/get-file.php?name=Bestiality">Bestiality</a></td>
						<td>
							<ul>
								<li>Created: November 22, 2015</li>
								<li>Format: WAV</li>
								<li>Size: 2.13 MB</li>
								<li>Length: 00:00:12.673</li>
								<li>Downloads: <?php echo get_downcount("Bestiality"); ?></li>
							</ul>
						</td>
						<td>
							<ul>
								<li>Used in video: <a href="http://www.youtube.com/watch?v=aPclel_rv6A" target="_blank">JerBear's Sweet 16 Party</a></li>
								<li>Category: Crap</li>
								<li>Created with: Noteflight, Microsoft GS Wavetable Synth, GoldWave</li>
								<li>If you ever find yourself raping a dog, this is the song to play.</li>
							</ul>
						</td>
					</tr>
					<tr>
						<td align="center"><a href="/downloads/get-file.php?name=Unnamed">Unnamed</a></td>
						<td>
							<ul>
								<li>Created: December 9, 2015</li>
								<li>Format: OGG</li>
								<li>Size: 711.37 KB</li>
								<li>Length: 00:01:01.253</li>
								<li>Downloads: <?php echo get_downcount("Unnamed"); ?></li>
							</ul>
						</td>
						<td>
							<ul>
								<li>Category: Unused</li>
								<li>Created with: Noteflight, Microsoft GS Wavetable Synth, GoldWave</li>
								<li>Very sexy</li>
							</ul>
						</td>
					</tr>
					<tr>
						<td align="center"><a href="/downloads/get-file.php?name=Talk Dirty">Talk Dirty</a></td>
						<td>
							<ul>
								<li>Created: December 20, 2015</li>
								<li>Format: OGG</li>
								<li>Size: 2.36 MB</li>
								<li>Length: 00:02:54.502</li>
								<li>Downloads: <?php echo get_downcount("Talk Dirty"); ?></li>
							</ul>
						</td>
						<td>
							<ul>
								<li>Used in video: <a href="http://www.youtube.com/watch?v=_5jTzQnfyVo" target="_blank">Ned Sings - "Talk Dirty"</a></li>
								<li>Category: Ned Sings</li>
								<li>Created with: KeepVid, Speakonia, PowerDirector, GoldWave</li>
								<li><a href="http://www.youtube.com/watch?v=tzEbxVqOc5c" target="_blank">Original instrumental</a></li>
							</ul>
						</td>
					</tr>
					<tr>
						<td align="center"><a href="/downloads/get-file.php?name=Rock">Rock</a></td>
						<td>
							<ul>
								<li>Created: January 17, 2016</li>
								<li>Format: WAV</li>
								<li>Size: 375.41 KB</li>
								<li>Length: 00:00:02.179</li>
								<li>Downloads: <?php echo get_downcount("Rock"); ?></li>
							</ul>
						</td>
						<td>
							<ul>
								<li>Used in video: <a href="http://www.youtube.com/watch?v=t5XgmG5ZXQw" target="_blank">Slightly Cold</a></li>
								<li>Category: Crap</li>
								<li>Created with: Demo song on a toy keyboard I got when I was like 8</li>
								<li><a href="/downloads/thekeyboard.jpg" target="_blank">The keyboard in question. If you have the same one, just push the Rock button.</a></li>
							</ul>
						</td>
					</tr>
					<tr>
						<td align="center"><a href="/downloads/get-file.php?name=moose">moose</a></td>
						<td>
							<ul>
								<li>Created: February 1, 2016</li>
								<li>Format: OGG</li>
								<li>Size: 523.49 KB</li>
								<li>Length: 00:00:51.833</li>
								<li>Downloads: <?php echo get_downcount("moose"); ?></li>
							</ul>
						</td>
						<td>
							<ul>
								<li>Category: Unused</li>
								<li>Created with: Noteflight, Microsoft GS Wavetable Synth, GoldWave</li>
								<li>I already had an unnamed song, so now we have moose, too.</li>
							</ul>
						</td>
						</tr>
						<tr>
						<td align="center"><a href="/downloads/get-file.php?name=dank moose">dank moose</a></td>
						<td>
							<ul>
								<li>Created: February 1, 2016</li>
								<li>Format: OGG</li>
								<li>Size: 598.73 KB</li>
								<li>Length: 00:01:01.607</li>
								<li>Downloads: <?php echo get_downcount("dank moose"); ?></li>
							</ul>
						</td>
						<td>
							<ul>
								<li>Category: Unused</li>
								<li>Created with: Noteflight, Microsoft GS Wavetable Synth, GoldWave</li>
								<li>Slowed down version of moose with trumpet added. Very dank.</li>
							</ul>
						</td>
					</tr>
					<tr>
						<td align="center"><a href="/downloads/get-file.php?name=Eye of the Spider">Eye of the Spider</a></td>
						<td>
							<ul>
								<li>Created: February 2, 2016</li>
								<li>Format: OGG</li>
								<li>Size: 3.38 MB</li>
								<li>Length: 00:03:56.617</li>
								<li>Downloads: <?php echo get_downcount("Eye of the Spider"); ?></li>
							</ul>
						</td>
						<td>
							<ul>
								<li>Category: Abandoned</li>
								<li>Reason: Unoriginal (Let me know if you still want me to make the video.)</li>
								<li>Created with: KeepVid, Voice, PowerDirector, GoldWave</li>
								<li>A beautiful cover of Eye of the Spider by JerBear. Note that even my high-pitched voice is still an octave lower than Itsoo1's.</li>
								<li><a href="http://www.youtube.com/watch?v=lBICLteuQs8" target="_blank">Original video</a></li>
								<li><a href="http://www.youtube.com/watch?v=wnZUYn6Tf9Y" target="_blank">Original instrumental</a></li>
							</ul>
						</td>
					</tr>
					<tr>
						<td align="center"><a href="/downloads/get-file.php?name=Baby">Baby</a></td>
						<td>
							<ul>
								<li>Created: February 20, 2016</li>
								<li>Format: WAV</li>
								<li>Size: 2.69 MB</li>
								<li>Length: 00:00:15.972</li>
								<li>Downloads: <?php echo get_downcount("Baby"); ?></li>
							</ul>
						</td>
						<td>
							<ul>
								<li>Used in video: <a href="http://www.youtube.com/watch?v=-x9moqTL48k" target="_blank">Truth or Dare</a></li>
								<li>Category: Ned Sings (sort of?)</li>
								<li>Created with: KeepVid, Speakonia, PowerDirector, GoldWave</li>
								<li><a href="http://www.youtube.com/watch?v=Wpsc6oGXNAM" target="_blank">Original instrumental</a></li>
							</ul>
						</td>
					</tr>
					<tr>
						<td align="center"><a href="/downloads/get-file.php?name=Bike Chase">Bike Chase</a></td>
						<td>
							<ul>
								<li>Created: February 20, 2016</li>
								<li>Format: OGG</li>
								<li>Size: 312.35 KB</li>
								<li>Length: 00:00:28.469</li>
								<li>Downloads: <?php echo get_downcount("Bike Chase"); ?></li>
							</ul>
						</td>
						<td>
							<ul>
								<li>Used in video: <a href="http://www.youtube.com/watch?v=-x9moqTL48k" target="_blank">Truth or Dare</a></li>
								<li>Category: Crap</li>
								<li>Created with: Noteflight, Microsoft GS Wavetable Synth, GoldWave</li>
								<li>Possibly the cause of Ned hitting pooberty.</li>
							</ul>
						</td>
					</tr>
					<tr>
						<td align="center"><a href="/downloads/get-file.php?name=cow">cow</a></td>
						<td>
							<ul>
								<li>Created: February 20, 2016</li>
								<li>Format: OGG</li>
								<li>Size: 283.15 KB</li>
								<li>Length: 00:00:30.281</li>
								<li>Downloads: <?php echo get_downcount("cow"); ?></li>
							</ul>
						</td>
						<td>
							<ul>
							    <li>Used in video: <a href="http://www.youtube.com/watch?v=qh5uRs0JDTg" target="_blank">The Jacob Sartorius Fan Club</a></li>
								<li>Category: Crap</li>
								<li>Created with: Noteflight, Microsoft GS Wavetable Synth, GoldWave</li>
								<li>Unnamed songs are going to be named after animals now because why not. Next up will be chicken.</li>
							</ul>
						</td>
					</tr>
					<tr>
						<td align="center"><a href="/downloads/get-file.php?name=DURR PLANT">DURR PLANT</a></td>
						<td>
							<ul>
								<li>Created: February 27, 2016</li>
								<li>Format: OGG</li>
								<li>Size: 347.31 KB</li>
								<li>Length: 00:00:37.535</li>
								<li>Downloads: <?php echo get_downcount("DURR PLANT"); ?></li>
							</ul>
						</td>
						<td>
							<ul>
								<li>Used in video: <a href="http://www.youtube.com/watch?v=w2lJ4vCPBRo" target="_blank">DURR PLANT Remix</a></li>
								<li>Category: Remix</li>
								<li>Created with: Noteflight, Microsoft GS Wavetable Synth, KeepVid, Renoise, GoldWave</li>
								<li>Remix of IHE's plant meme.</li>
								<li><a href="http://www.youtube.com/watch?v=7fu888sbW0Q" target="_blank">Original lyrics</a></li>
							</ul>
						</td>
					</tr>
					<tr>
						<td align="center"><a href="http://www.youtube.com/watch?v=zV3tpQzhnMg" target="_blank">DURR MEME</a></td>
						<td>
							<ul>
								<li>Created: March 5, 2016</li>
								<li>Length: 00:04:25.079</li>
							</ul>
						</td>
						<td>
							<ul>
								<li>Outro song by <a href="http://www.youtube.com/channel/UCKenOD_MdesqSrPyn6xDfcA" target="_blank">YuriDicMilk</a>, starting with <a href="http://www.youtube.com/watch?v=o69y6HPu6jE" target="_blank">Channel Trailer</a></li>
							</ul>
						</td>
					</tr>
					<tr>
						<td align="center"><a href="/downloads/get-file.php?name=Trailer">Trailer</a></td>
						<td>
							<ul>
								<li>Created: March 5, 2016</li>
								<li>Format: OGG</li>
								<li>Size: 203.87 KB</li>
								<li>Length: 00:00:15.258</li>
								<li>Downloads: <?php echo get_downcount("Trailer"); ?></li>
							</ul>
						</td>
						<td>
							<ul>
								<li>Used in video: <a href="http://www.youtube.com/watch?v=o69y6HPu6jE" target="_blank">Channel Trailer</a></li>
								<li>Category: Crap</li>
								<li>Created with: Noteflight, Microsoft GS Wavetable Synth, GoldWave</li>
								<li>Poopy background music in the trailer.</li>
							</ul>
						</td>
					</tr>
					<tr>
						<td align="center"><a href="/downloads/get-file.php?name=Ned Fight">Ned Fight</a></td>
						<td>
							<ul>
								<li>Created: March 19, 2016</li>
								<li>Format: OGG</li>
								<li>Size: 132.84 KB</li>
								<li>Length: 00:00:12.398</li>
								<li>Downloads: <?php echo get_downcount("Ned Fight"); ?></li>
							</ul>
						</td>
						<td>
							<ul>
								<li>Used in video: <a href="http://www.youtube.com/watch?v=xtT4fiZbshY" target="_blank">Cooking with JerBear - Chocolate Chip Cookies </a></li>
								<li>Category: Crap</li>
								<li>Created with: Noteflight, Microsoft GS Wavetable Synth, GoldWave</li>
								<li>Spoiler alert: Ned loses.</li>
							</ul>
						</td>
					</tr>
					<tr>
						<td align="center"><a href="/downloads/get-file.php?name=I Hate Dust">I Hate Dust</a></td>
						<td>
							<ul>
								<li>Created: March 24, 2016</li>
								<li>Format: OGG</li>
								<li>Size: 751.53 KB</li>
								<li>Length: 00:01:15.789</li>
								<li>Downloads: <?php echo get_downcount("I Hate Dust"); ?></li>
							</ul>
						</td>
						<td>
							<ul>
								<li>Used in video: <a href="http://www.youtube.com/watch?v=L09NOd4wy6A" target="_blank">I Hate Dust Remix</a></li>
								<li>Category: Remix</li>
								<li>Created with: Noteflight, Microsoft GS Wavetable Synth, KeepVid, Renoise, GoldWave</li>
								<li>Remix of the next great IHE meme.</li>
								<li><a href="http://www.youtube.com/watch?v=UE7I5mPHsSU" target="_blank">Original lyrics</a></li>
							</ul>
						</td>
					</tr>
					<tr>
						<td align="center"><a href="/downloads/get-file.php?name=Summer of JerBear 2016">Summer of JerBear 2016</a></td>
						<td>
							<ul>
								<li>Created: May 31, 2016</li>
								<li>Format: OGG</li>
								<li>Size: 3.16 MB</li>
								<li>Length: 00:03:40.455</li>
								<li>Downloads: <?php echo get_downcount("Summer of JerBear 2016"); ?></li>
							</ul>
						</td>
						<td>
							<ul>
								<li>Used in video: <a href="http://www.youtube.com/watch?v=iNPaKXJDps0" target="_blank">Summer of JerBear 2016 (JerBear vs. Ned Rap Battle)</a></li>
								<li>Category: Rap Battle</li>
								<li>Created with: Midiplus EK490, Microsoft GS Wavetable Synth, Renoise, Voice, Speakonia, PowerDirector, GoldWave</li>
								<li>A cringe rap battle where JerBear and Ned fight over who has the longest penis length.</li>
							</ul>
						</td>
					</tr>
					<tr>
						<td align="center"><a href="/downloads/get-file.php?name=Adventure Begins">Adventure Begins</a></td>
						<td>
							<ul>
								<li>Created: June 12, 2016</li>
								<li>Format: WAV</li>
								<li>Size: 1.01 MB</li>
								<li>Length: 00:00:06.013</li>
								<li>Downloads: <?php echo get_downcount("Adventure Begins"); ?></li>
							</ul>
						</td>
						<td>
							<ul>
								<li>Used in video: <a href="http://www.youtube.com/watch?v=WcjT7bUr1OE" target="_blank">Durr Plant: The Movie ft. I HATE EVERYTHING</a></li>
								<li>Category: Crap</li>
								<li>Created with: Noteflight, GoldWave</li>
								<li>The quest for Durr Plant begins.</li>
							</ul>
						</td>
					</tr>
					<tr>
						<td align="center"><a href="/downloads/get-file.php?name=Snake Attack">Snake Attack</a></td>
						<td>
							<ul>
								<li>Created: June 12, 2016</li>
								<li>Format: OGG</li>
								<li>Size: 191.47 KB</li>
								<li>Length: 00:00:17.489</li>
								<li>Downloads: <?php echo get_downcount("Snake Attack"); ?></li>
							</ul>
						</td>
						<td>
							<ul>
								<li>Used in video: <a href="http://www.youtube.com/watch?v=WcjT7bUr1OE" target="_blank">Durr Plant: The Movie ft. I HATE EVERYTHING</a></li>
								<li>Category: Crap</li>
								<li>Created with: Noteflight, GoldWave</li>
								<li>An army of stuffed snakes attack JerBear and friends.</li>
							</ul>
						</td>
					</tr>
					<tr>
						<td align="center"><a href="/downloads/get-file.php?name=DURR CHASE">DURR CHASE</a></td>
						<td>
							<ul>
								<li>Created: June 12, 2016</li>
								<li>Format: OGG</li>
								<li>Size: 59.04 KB</li>
								<li>Length: 00:00:06.236</li>
								<li>Downloads: <?php echo get_downcount("DURR CHASE"); ?></li>
							</ul>
						</td>
						<td>
							<ul>
								<li>Used in video: <a href="http://www.youtube.com/watch?v=WcjT7bUr1OE" target="_blank">Durr Plant: The Movie ft. I HATE EVERYTHING</a></li>
								<li>Category: Crap</li>
								<li>Created with: Noteflight, GoldWave</li>
								<li>Sped up instrumental of the classic DURR PLANT Remix.</li>
							</ul>
						</td>
					</tr>
				</table>
				<br />
				<h3><a name="games">Games</a></h3><br />
				<p>Read the requirements, dongus.</p><br />
				<table border="1">
					<tr>
						<td align="center"><b>Name + URL</b></td>
						<td align="center"><b>File Info</b></td>
						<td align="center"><b>Description</b></td>
						<td align="center"><b>Requirements</b></td>
						<td align="center"><b>Source Code</b></td>
					</tr>
					<tr>
						<td align="center"><a href="/downloads/get-file.php?name=Truth or Dare">Truth or Dare</a></td>
						<td>
							<ul>
								<li>Created: February 20, 2016</li>
								<li>Format: JAR</li>
								<li>Size: 9.67 MB</li>
								<li>Platform: Windows, Mac (untested), Linux (untested)</li>
								<li>Downloads: <?php echo get_downcount("Truth or Dare"); ?></li>
							</ul>
						</td>
						<td>
							<ul>
								<li>Used in video: <a href="http://www.youtube.com/watch?v=-x9moqTL48k" target="_blank">Truth or Dare</a></li>
								<li>Created with: Java, Eclipse, LibGDX, Paint.NET</li>
								<li>Fake truth or dare thingy. Push 1 for truth, 2 for dare. Sound not included.</li>
								<li>Nobody can get it working?</li>
							</ul>
						</td>
						<td>
							<ul>
								<li>Java</li>
								<li>1600x900 or bigger monitor</li>
							</ul>
						</td>
						<td><a href="http://www.dropbox.com/s/46vmftjeaeevk1j/TruthOrDare-src.zip?dl=1">Download</a></td>
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
