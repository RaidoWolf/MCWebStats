<?php

	/*
	 * Sputnik One Networks - Minecraft Web Stats - Version 0.6 alpha - stats.php
	 * copyright 2014 Alexander Barber
	 * distributed under the terms of the MIT License (see LICENSE for more info)
	 * 
	 */


	include_once 'config.php'; //include main configuration
	include_once 'uuid.php'; //include PHP-GetUUID PlayerName->UUID converter
	include_once 'lib/functions_units.php'; //include unit handling functions
	
	// -- VARIABLE COLLECTOR -- //
	if (isset($_REQUEST['player']))
	{
		if (isset($_POST['player']))
		{
			$player = $_POST['player'];
		}
		elseif (isset($_GET['player']))
		{
			$player = $_GET['player'];
		}
		else
		{
			$player = null;
		}
		$player = preg_replace("/[\s]{1}/", "_", $player); //replace all whitespace characters with underscores
		$player = preg_replace("/[^\w\d_]*/", "", $player); //delete any character that is not a letter, number, or underscore
	}
	else
	{
		$player = null;
	}
	if (isset($_REQUEST['units']))
	{
		if (isset($_POST['units']))
		{
			$units = $_POST['units'];
		}
		elseif (isset($_GET['units']))
		{
			$units = $_GET['units'];
		}
		else
		{
			$units = "metric";
		}
		if ($units != "metric" && $units != "imperial")
		{
			$units = "metric";
		}
	}
	else
	{
		$units = "metric";
	}
?>
<html>
<head>
	<title>MCWebStats - Stats</title>
	<meta charset="utf-8">
	<link type="text/css" rel="stylesheet" href="css/style.css">
</head>
<body>

	<form method='post'>
	Player: <input name='player' type='text' value='<?php echo $player; ?>' />
	<select name='units'>
		<option name='units' value='metric' <?php if($units=='metric'){echo'selected';} ?>>metric</option>
		<option name='units' value='imperial' <?php if($units=='imperial'){echo'selected';} ?>>imperial</option>
	</select>
	<input type='submit'>
	</form>
<?php
	echo "Player: ".$player."<br />";
	$playeruuid = GetUUID($player); //use GetUUID function from uuid.php to obtain the UUID from Mojang servers
	$playeruuid = strtolower($playeruuid); //convert any and all capital letters to lowercase
	if (!preg_match("/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/",$playeruuid)) //check if not formatted like a proper uuid
	{
		$playeruuidnew = substr($playeruuid,0,8); //get first 8 characters of UUID
		$playeruuidnew .= "-"; //hyphen
		$playeruuidnew .= substr($playeruuid,8,4); //get first 4 characters after character 8
		$playeruuidnew .= "-"; //hyphen
		$playeruuidnew .= substr($playeruuid,12,4); //get first 4 characters after character 12
		$playeruuidnew .= "-"; //hyphen
		$playeruuidnew .= substr($playeruuid,16,4); //get first 4 characters after character 16
		$playeruuidnew .= "-"; //hyphen
		$playeruuidnew .= substr($playeruuid,20,12); //get first 12 characters after character 20
		$playeruuid = $playeruuidnew; //copy new value back to original variable (after formatting as a proper variable)
	}
	echo "UUID: ".$playeruuid."<br />";
	if (file_exists("$mcroot/world/stats/$playeruuid.json")) #test if we have stats for that player.
		{
		$stats = file_get_contents("$mcroot/world/stats/$playeruuid.json"); #read stats file contents.
		$playerStatArray = json_decode($stats,true);

		// -- TIME PLAYED DATA -- //
		$ticksPlayed = $playerStatArray['stat.playOneMinute']; //get number of ticks played
			$secondsPlayed = ($ticksPlayed / 20); //number of seconds played
			$minutesPlayed = ($ticksPlayed / 1200); //number of minutes played
			$hoursPlayed = ($ticksPlayed / 72000); //number of hours played
			$daysPlayed = ($ticksPlayed / 1728000); //number of days played
			$ticksModuloSecondsPlayed = ($ticksPlayed % 20); //number of ticks left over after seconds floored (modulo)
			$secondsModuloMinutesPlayed = (($ticksPlayed % 1200) / 20); //number of seconds left over after minutes floored (modulo)
			$minutesModuloHoursPlayed = (($ticksPlayed % 72000) / 1200); //number of minutes left over after hours floored (modulo)
			$hoursModuloDaysPlayed = (($ticksPlayed % 1728000) / 72000); //number of hours left over after days floored (modulo) 
		$timePlayed = floor($daysPlayed)."d ".floor($hoursModuloDaysPlayed)."h ".floor($minutesModuloHoursPlayed)."m ".$secondsModuloMinutesPlayed."s";

		// -- DISTANCE TRAVELED DATA -- //
		$cmWalked = $playerStatArray['stat.walkOneCm']; //get number of centimeters walked
			if ($units == "metric")
			{
				$distWalked = distance_fancify($cmWalked, "cm", false); //convert distance walked to human-readable format
			}
			elseif ($units == "imperial")
			{
				$distWalked = distance_fancify($cmWalked, "cm", true); // ... using imperial units
			}
		$cmSprinted = $playerStatArray['stat.sprintOneCm']; //get number of centimeters sprinted
			if ($units == "metric")
			{
				$distSprinted = distance_fancify($cmSprinted, "cm", false); //convert distance sprinted to human-readable format
			}
			elseif ($units == "imperial")
			{
				$distSprinted = distance_fancify($cmSprinted, "cm", true); // ... using imperial units
			}
		$cmCrouched = $playerStatArray['stat.crouchOneCm']; //get number of centimeters sneaking/crouched
			if ($units == "metric")
			{
				$distCrouched = distance_fancify($cmCrouched, "cm", false); //convert distance sneaking/crouched to human-readable format
			}
			elseif ($units == "imperial")
			{
				$distCrouched = distance_fancify($cmCrouched, "cm", true); // ... using imperial units
			}
		$cmClimbed = $playerStatArray['stat.climbOneCm']; //get number of centimeters climbed
			if ($units == "metric")
			{
				$distClimbed = distance_fancify($cmClimbed, "cm", false); //convert distance climbed to human-readable format
			}
			elseif ($units == "imperial")
			{
				$distClimbed = distance_fancify($cmClimbed, "cm", true); // ... using imperial units
			}
		$cmFallen = $playerStatArray['stat.fallOneCm']; //get number of centimeters fallen
			if ($units == "metric")
			{
				$distFallen = distance_fancify($cmFallen, "cm", false); //convert distance fallen to human-readable format
			}
			elseif ($units == "imperial")
			{
				$distFallen = distance_fancify($cmFallen, "cm", true); // ... using imperial units
			} 
		$cmBoated = $playerStatArray['stat.boatOneCm']; //get number of centimeters boated
			if ($units == "metric")
			{
				$distBoated = distance_fancify($cmBoated, "cm", false); //convert distance boated to human-readable format
			}
			elseif ($units == "imperial")
			{
				$distBoated = distance_fancify($cmBoated, "cm", true); // ... using imperial units
			}
		$cmSwam = $playerStatArray['stat.swimOneCm']; //get number of centimeters swam
			if ($units == "metric")
			{
				$distSwam = distance_fancify($cmSwam, "cm", false); //convert distance swam to human-readable format
			}
			elseif ($units == "imperial")
			{
				$distSwam = distance_fancify($cmSwam, "cm", true); // ... using imperial units
			}
		$cmDived = $playerStatArray['stat.diveOneCm']; //get number of centimeters underwater
			if ($units == "metric")
			{
				$distDived = distance_fancify($cmDived, "cm", false); //convert distance underwater to human-readable format
			}
			elseif ($units == "imperial")
			{
				$distDived = distance_fancify($cmDived, "cm", true); // ... using imperial units
			}
		$cmCarted = $playerStatArray['stat.minecartOneCm']; //get number of centimeters ridden on a minecart
			if ($units == "metric")
			{
				$distCarted = distance_fancify($cmCarted, "cm", false); //convert distance ridden on a minecart to human-readable format
			}
			elseif ($units == "imperial")
			{
				$distCarted = distance_fancify($cmCarted, "cm", true); // ... using imperial units
			}
		$cmPig = $playerStatArray['stat.pigOneCm']; //get number of centimeters ridden on a pig
			if ($units == "metric")
			{
				$distPig = distance_fancify($cmPig, "cm", false); //convert distance ridden on a pig to human-readable format
			}
			elseif ($units == "imperial")
			{
				$distPig = distance_fancify($cmPig, "cm", true); // ... using imperial units
			}
		$cmHorse = $playerStatArray['stat.horseOneCm']; //get number of centimeters ridden on a horse
			if ($units == "metric")
			{
				$distHorse = distance_fancify($cmHorse, "cm", false); //convert distance ridden on a horse to human-readable format
			}
			elseif ($units == "imperial")
			{
				$distHorse = distance_fancify($cmHorse, "cm", true); // ... using imperial units
			}
		$cmFlown = $playerStatArray['stat.flyOneCm']; //get number of centimeters airborne
			if ($units == "metric")
			{
				$distFlown = distance_fancify($cmFlown, "cm", false); //convert distance airborne to human-readable format
			}
			elseif ($units == "imperial")
			{
				$distFlown = distance_fancify($cmFlown, "cm", true); // ... using imperial units
			}

		echo "
		<table>
			<tr>
				<td>
					<p>Time Played:</p>
				</td>
				<td>
					<p>".$timePlayed."</p>
				</td>
			</tr>
			<tr>
				<td>
					<p>Distance Walked:</p>
				</td>
				<td>
					<p>".$distWalked."</p> 
				</td>
			</tr>
			<tr>
				<td>
					<p>Distance Sprinted:</p>
				</td>
				<td>
					<p>".$distSprinted."</p>
				</td>
			</tr>
			<tr>
				<td>
					<p>Distance Sneaking:</p>
				</td>
				<td>
					<p>".$distCrouched."</p>
				</td>
			</tr>
			<tr>
				<td>
					<p>Distance Climbed:</p>
				</td>
				<td>
					<p>".$distClimbed."</p>
				</td>
			</tr>
			<tr>
				<td>
					<p>Distance Fallen:</p>
				</td>
				<td>
					<p>".$distFallen."</p>
				</td>
			</tr>
			<tr>
				<td>
					<p>Distance Swam:</p>
				</td>
				<td>
					<p>".$distSwam."</p>
				</td>
			</tr>
			<tr>
				<td>
					<p>Distance Underwater:</p>
				</td>
				<td>
					<p>".$distDived."</p>
				</td>
			</tr>
			<tr>
				<td>
					<p>Distance on Minecart</p>
				</td>
				<td>
					<p>".$distCarted."</p>
				</td>
			</tr>
			<tr>
				<td>
					<p>Distance on Pig</p>
				</td>
				<td>
					<p>".$distPig."</p>
				</td>
			</tr>
			<tr>
				<td>
					<p>Distance on Horse:</p>
				</td>
				<td>
					<p>".$distHorse."</p>
				</td>
			</tr>
			<tr>
				<td>
					<p>Distance Airborne:</p>
				</td>
				<td>
					<p>".$distFlown."</p>
				</td>
			</tr>
		</table>
		";
		$result_printr = print("<pre>".print_r($playerStatArray,true."</pre>"));
		echo $result_printr;
		}
	else
		{
		echo "Attempting legacy stats...<br />";
		if (file_exists("$mcroot/$mcworld/stats/$player.json")) #Legacy support
			{
			$stats = file_get_contents("$mcroot/$mcworld/stats/$player.json");
			$playerStatArray = json_decode($stats, true);
			$result_printr = print("<pre>".print_r($playerStatArray, true."</pre>"));
			//extract($result_printr, EXTR_PREFIX_ALL, "stat");
			echo $result_printr;
			}
		else
			{
			echo "Player $player Not Found. Remember that player names are case sensitive.";
			}
		}
?>
</body>
</html>
