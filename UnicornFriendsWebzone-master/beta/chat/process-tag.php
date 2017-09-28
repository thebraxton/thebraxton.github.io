<?php
	require_once $_SERVER["DOCUMENT_ROOT"] . "util.php";
	util_include_set();
	
	function startswith($haystack, $needle)
	{
		return strcasecmp(substr($haystack, 0, strlen($needle)), $needle) == 0;
	}
	
	function endswith($haystack, $needle)
	{
		return strcasecmp(substr($haystack, -strlen($needle)), $needle) == 0;
	}
	
	//Tag types
	//Singular tag: <lenny>
	//Double tags: <b></b>
	//Argument tags: <color:color:text>
	function tagprocess($msg, $db)
	{
		$msg = doubletag($msg);
		$msg = singletag($msg);
		
		$argout = argtag($msg);
		$msg = $argout[0];
		
		//Not really tags but they are processed in the same way
		if($argout[1]) $msg = urltagless($msg);
		$msg = usertagless($msg, $db);
		
		return $msg;
	}
	
	function doubletag($msg)
	{
		$accepted = "busic";
		for($i = 0; $i < strlen($accepted); $i++)
		{
			$tag = $accepted[$i];
			$tagopen = "&lt;" . $tag . "&gt;";
			$tagclose = "&lt;/" . $tag . "&gt;";
			
			$newmsg = "";
			$posnext = 0;
			
			while($posnext < strlen($msg))
			{
				$posprv = $posnext;
				$posopen = stripos($msg, $tagopen, $posnext);
				$posclose = stripos($msg, $tagclose, $posnext);
				
				if($posopen === false)
				{
					$newmsg .= substr($msg, $posnext);
					break;
				}
				
				$newmsg .= substr($msg, $posprv, $posopen - $posprv);
				
				if($posclose === false)
				{
					$tagmsg = substr($msg, $posopen + strlen($tagopen));
					$newmsg .= doubletagimpl($tag, $tagmsg);
						
					break;
				}
				
				if($posclose < $posopen)
				{
					$posnext = $posopen;
				}
				else
				{
					$tagmsg = substr($msg, $posopen + strlen($tagopen), $posclose - $posopen - strlen($tagopen));
					$posnext = $posclose + strlen($tagclose);
					$newmsg .= doubletagimpl($tag, $tagmsg);
				}
			}
			
			$msg = $newmsg;
		}
		
		return doubletagclean($msg, $accepted);
	}
	
	function doubletagimpl($tag, $msg)
	{
	    $msg = trim($msg);
		if($tag[0] == 'c')
			return tagcancelcs($msg);
		else
			return taghtml($tag, $msg);
	}
	
	//Clean up empty tags (eg. <b>   </b>)
	function doubletagclean($msg, $accepted)
	{
		do
		{
			$recurse = $msg;
			$msg = preg_replace_callback("/<([" . $accepted . "])>\s*<\/(\\1)>/i", function($tag)
			{
			    $out = trim($tag[0]);
			    if(empty(trim(strip_tags($out))))
		        	return "";
		        
		        return $out;
			}, $msg);
			
			$msg = preg_replace("/<span class=\"cancelcs\">\s*<\/span>/", "", $msg);
		}
		while(strcmp($msg, $recurse) != 0);
		
		//TODO this dirty and only fixes an empty string
		if(empty(trim(strip_tags($msg))))
			return "";
		
		return $msg;
	}
	
	function tagcancelcs($msg)
	{
		return "<span class=\"cancelcs\">" . $msg . "</span>";
	}
	
	function taghtml($tag, $msg)
	{
		return "<" . $tag . ">" . $msg . "</" . $tag . ">";
	}
	
	function singletag($msg)
	{
		return preg_replace_callback("/&lt;((?:(?!(?:&lt;))(?!(?:&gt;))[^:])+)&gt;/", function($tag)
		{
			switch(strtolower($tag[1]))
			{
				case "lenny":
					return taglenny();
				case "xenny":
					return tagxenny();
				case "nazi":
				case "swastika":
					return tagswastika();
				case "mods":
					return tagmods();
				case "shrug":
					return tagshrug();
				case "shades":
				case "shades1":
					return tagshades1();
				case "shades2":
					return tagshades2();
				case "shades3":
					return tagshades3();
		        case "heart":
		            return tagheart();
		        case "ip":
		            return tagip();
				default:
					return $tag[0];
			}
		}, $msg);
	}
	
	function taglenny()
	{
		return "<span class=\"cancelcs\">( &#x0361;&#x00B0; &#x035C;&#x0296; &#x0361;&#x00B0;)</span>";
	}
	
	function tagxenny()
	{
		return "<span class=\"cancelcs\">(&#x3065;&#x30FB;&#x3C9;&#x30FB;)&#x3065;</span>";
	}
	
	function tagswastika()
	{
		return "<span class=\"cancelcs\">&#x5350;</span>";
	}
	
	function tagmods()
	{
		return "<span class=\"cancelcs\">-( &#x0361;&#x00B0; &#x035C;&#x0296; &#x0361;&#x00B0;)&#x256F;&#x2572;___&#x5350;&#x5350;&#x5350;&#x5350;</span>";
	}
	
	function tagshrug()
	{
		return "<span class=\"cancelcs\">&#x00AF;\_(&#x30C4;)_/&#x00AF;</span>";
	}
	
	function tagshades1()
	{
		return "<span class=\"cancelcs\">(&#8976;&#9632;_&#9632;)</span>";
	}
	
	function tagshades2()
	{
		return "<span class=\"cancelcs\">( &bull;_&bull;)>&#8976;&#9632;-&#9632;</span>";
	}
	
	function tagshades3()
	{
		return "<span class=\"cancelcs\">(&bull;_&bull;) ( &bull;_&bull;)>&#8976;&#9632;-&#9632; (&#8976;&#9632;_&#9632;)</span>";
	}
	
	function tagheart()
	{
	    return "&lt;3";
	}
	
	function tagip()
	{
	    return $_SERVER["REMOTE_ADDR"];
	}
	
	function argtag($msg)
	{
		$useurltagless = true;
		return array(preg_replace_callback("/&lt;((?:(?!(?:&lt;))(?!(?:&gt;)).)+)&gt;/", function($tag) use(&$useurltagless)
		{
			$lowerargtag = strtolower($tag[1]);
			
			if(startswith($lowerargtag, "tm:") || strcmp($lowerargtag, "tm") == 0)
				return tagtm($tag[1]);
			
			if(startswith($lowerargtag, "sm:") || strcmp($lowerargtag, "sm") == 0)
				return tagsm($tag[1]);
			
			if(startswith($lowerargtag, "cr:") || strcmp($lowerargtag, "cr") == 0)
				return tagcr($tag[1]);
			
			if(startswith($lowerargtag, "r:") || strcmp($lowerargtag, "r") == 0)
				return tagr($tag[1]);
			
			if(startswith($lowerargtag, "color:"))
				return tagcolor($tag[1]);
				
			if(startswith($lowerargtag, "link:") || startswith($lowerargtag, "url:"))
			{
				$useurltagless = false;
				return tagurl($tag[1]);
			}
			
			return $tag[0];
		}, $msg), $useurltagless);
	}
	
	function tagtm($input)
	{
		$arr = explode(":", $input,2);
		$uc = ucwords($arr[1]);
		
	    return $uc . "&trade;";
	}
	
	function tagsm($input)
	{
		$arr = explode(":", $input,2);
		$uc = ucwords($arr[1]);
		
	    return $uc . "&#8480;";
	}
	
	function tagcr($input)
	{
		$arr = explode(":", $input,2);
		$uc = ucwords($arr[1]);
		
	    return "&copy; " . $uc;
	}
	
	function tagr($input)
	{
		$arr = explode(":", $input,2);
		$uc = ucwords($arr[1]);
		
	    return $uc . "&reg;";
	}
	
	function tagcolor($input)
	{
		$parts = explode(":", $input, 3);
		$parts[1] = trim($parts[1]);
		$parts[2] = trim($parts[2]);
		
		if(empty($parts[2]))
	        return "";
		
		if(empty($parts[1]))
			return $parts[2];
		
		if(strcasecmp($parts[1], "rainbow") == 0)
		    return "<span class=\"rainbow\">" . $parts[2] . "</span>";
		else
		    return "<font color=\"" . $parts[1] . "\">" . $parts[2] . "</font>";
	}
	
	function tagurl($input)
	{
		$parts = explode(":", $input);
		$args = count($parts);
		
		if($args == 2)
		{
			$parts[1] = trim($parts[1]);
			$parts[2] = $parts[1];
		}
		else if($args == 3)
		{
			if(startswith($parts[2], "//"))
			{
				$parts[1] = trim($parts[1]) . ":" . trim($parts[2]);
				$parts[2] = $parts[1];
			}
			else
			{
				$parts[1] = trim($parts[1]);
				$parts[2] = trim($parts[2]);
			}
		}
		else if($args > 3)
		{
			if(startswith($parts[2], "//"))
			{
				$parts[1] = trim($parts[1]) . ":" . trim($parts[2]);
				array_splice($parts, 2, 1);
				$args--;
			}
			
			for($i = 3; $i < $args; $i++)
				$parts[2] .= ":" . $parts[$i];
			
			$parts[2] = trim($parts[2]);
		}
		
		if(strcasecmp($parts[1], "rickroll") == 0)
			$parts[1] = "/redirect.php";
		else if(strpos($parts[1], "://") === false)
			$parts[1] = "http://" . $parts[1];
		
		if(empty($parts[2]))
			return "";
		else
			return "<a href=\"" . $parts[1] . "\" target=\"_blank\">" . $parts[2] . "</a>";
	}
	
	function urltagless($msg)
	{
		return preg_replace_callback("/[A-z]+:\/\/[^ ]+/", function($url)
		{
			return "<a href=\"" . $url[0] . "\" target=\"_blank\">" . $url[0] . "</a>";
		}, $msg);
	}
	
	function usertagless($msg, $db)
	{
		return preg_replace_callback("/(?:^|(?<=\s))@([[:alnum:]\-_]+)(?:$|(?=[^[:alnum:]\-_]))/", function($user) use(&$db)
		{
			if(util_get_userexists($db, $user[1]))
				return util_format_user($user[0], util_get_usercolor($db, $user[1]), true);
			else
				return $user[0];
		}, $msg);
	}
?>
