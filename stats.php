<?php
	include_once 'config.php'; //include main configuration
	include_once 'uuid.php'; //include PHP-GetUUID PlayerName->UUID converter
	include_once 'lib/functions_units.php'; //include unit handling functions
?>
<html>
<head>
	<title>MCWebStats - Stats</title>
	<meta charset="utf-8">
	<link type="text/css" rel="stylesheet" href="css/style.css">
</head>
<body>
<?php #Sputnik One Networks - Minecraft Web Stats - Version 0.5 alpha - stats.php
if (isset($_REQUEST['player'])) //check if $player variable is set
	{ //display form to input player info followed by stats as returned by the script
	echo "<form method='post' action='stats.php'>
	Player: <input name='player' type='text'<br>
	</textarea><br>
	<input type='submit'>
	</form>";
	if (isset($_POST['player'])) //prefer set player via post, next use get, next fail
		{$player = $_POST['player'];}
	elseif (isset($_GET['player']))
		{$player = $_GET['player'];}
	else
		{$player = "none";}
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
			$distWalked = distance_fancify($cmWalked, "cm", false); //convert distance walked to human-readable format
		$cmSprinted = $playerStatArray['stat.sprintOneCm']; //get number of centimeters sprinted
			$distSprinted = distance_fancify($cmSprinted, "cm", false); //convert distance sprinted to human-readable format
		$cmCrouched = $playerStatArray['stat.crouchOneCm']; //get number of centimeters sneaking/crouched
			$distCrouched = distance_fancify($cmCrouched, "cm", false); //convert distance sneaking/crouched to human-readable format
		$cmClimbed = $playerStatArray['stat.climbOneCm']; //get number of centimeters climbed
			$distClimbed = distance_fancify($cmClimbed, "cm", false); //convert distance climbed to human-readable format
		$cmFallen = $playerStatArray['stat.fallOneCm']; //get number of centimeters fallen
			$distFallen = distance_fancify($cmFallen, "cm", false); //convert distance fallen to human-readable format 
		$cmBoated = $playerStatArray['stat.boatOneCm']; //get number of centimeters boated
			$distBoated = distance_fancify($cmBoated, "cm", false); //convert distance boated to human-readable format
		$cmSwam = $playerStatArray['stat.swimOneCm']; //get number of centimeters swam
			$distSwam = distance_fancify($cmSwam, "cm", false); //convert distance swam to human-readable format
		$cmDived = $playerStatArray['stat.diveOneCm']; //get number of centimeters dived
			$distDived = distance_fancify($cmDived, "cm", false); //convert distance dived to human-readable format
		$cmHorse = $playerStatArray['stat.horseOneCm']; //get number of centimeters ridden on a horse
			$distHorse = distance_fancify($cmHorse, "cm", false); //convert distance ridden on a horse to human-readable format
		$cmFlown = $playerStatArray['stat.flyOneCm']; //get number of centimeters flown/launched
			$distFlown = distance_fancify($cmFlown, "cm", false); //convert distance flown/launched to human-readable format

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
					<p>Distance on Horse:</p>
				</td>
				<td>
					<p>".$distHorse."</p>
				</td>
			</tr>
			<tr>
				<td>
					<p>Distance Airborne</p>
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
	}
else #if $player variable is not set, display empty form
	{
	echo "<form method='post' action='stats.php'>
	Player: <input name='player' type='text'<br>
	</textarea><br>
	<input type='submit'>
	</form>";
	}
?>
</body>
</html>
