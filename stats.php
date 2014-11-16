<html>
<head>
	<title>MCWebStats - Stats</title>
	<meta charset="utf-8">
	<link type="text/css" rel="stylesheet" href="css/style.css">
</head>
<body>
<?php #Sputnik One Networks - Minecraft Web Stats - Version 0.4 alpha - stats.php
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
	include_once 'config.php'; //include main configuration
	include_once 'uuid.php'; //include PHP-GetUUID PlayerName->UUID converter
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
		$json_decode = json_decode($stats,true);

		// -- TIME PLAYED DATA -- //
		$ticksPlayed = $json_decode['stat.playOneMinute']; //get number of ticks played
			$secondsPlayed = ($ticksPlayed / 20); //number of seconds played
			$minutesPlayed = ($ticksPlayed / 1200); //number of minutes played
			$hoursPlayed = ($ticksPlayed / 72000); //number of hours played
			$daysPlayed = ($ticksPlayed / 1728000); //number of days played
			$ticksModuloSecondsPlayed = ($ticksPlayed % 20); //number of ticks left over after seconds floored (modulo)
			$secondsModuloMinutesPlayed = (($ticksPlayed % 1200) / 20); //number of seconds left over after minutes floored (modulo)
			$minutesModuloHoursPlayed = (($ticksPlayed % 72000) / 1200); //number of minutes left over after hours floored (modulo)
			$hoursModuloDaysPlayed = (($ticksPlayed % 1728000) / 72000); //number of hours left over after days floored (modulo) 
		$timePlayed = floor($daysPlayed)."d ".floor($hoursModuloDaysPlayed)."h ".floor($minutesModuloHoursPlayed)."m ".$secondsModuloMinutesPlayed."s";

		// -- DISTANCE WALKED DATA -- //
		$cmWalked = $json_decode['stat.walkOneCm']; //get number of centimeters walked
			$kmWalked = ($cmWalked / 100000); //number of kilometers walked
			$mWalked = ($cmWalked / 100); //number of meters walked
			$miWalked = ($cmWalked / 160934); //number of miles walked
			$ydWalked = ($cmWalked / 91.44); //number of yards walked
			$ftWalked = ($cmWalked / 30.48); //number of centimeters walked
			$inWalked = ($cmWalked / 2.54); //number of inches walked

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
					<p>".$kmWalked."km</p> 
				</td>
			</tr>
		</table>
		";
		$result_printr = print("<pre>".print_r($json_decode,true."</pre>"));
		//extract($result_printr, EXTR_PREFIX_ALL, "stat");
		echo $result_printr;
		}
	else
		{
		echo "Attempting legacy stats...<br />";
		if (file_exists("$mcroot/$mcworld/stats/$player.json")) #Legacy support
			{
			$stats = file_get_contents("$mcroot/$mcworld/stats/$player.json");
			$json_decode = json_decode($stats, true);
			$result_printr = print("<pre>".print_r($json_decode, true."</pre>"));
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
