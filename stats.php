<html>
<head>
	<title>MCWebStats - Stats</title>
	<meta charset="utf-8">
	<link type="text/css" rel="stylesheet" href="css/style.css">
</head>
<body>
<?php #Sputnik One Networks - Minecraft Web Stats - Version 0.3 alpha - stats.php
if (isset($_REQUEST['player'])) #check if $player variable is set
	{ #display form to input player info followed by stats as returned by the script
	echo "<form method='post' action='stats.php'>
	Player: <input name='player' type='text'<br>
	</textarea><br>
	<input type='submit'>
	</form>";
	$player = $_REQUEST['player'];
	include 'config.php'; #include main configuration
	include 'uuid.php'; #include PHP-GetUUID PlayerName->UUID converter
	$playeruuid = GetUUID($player);
	if (file_exists("$mcroot/world/stats/$playeruuid.json")) #test if we have stats for that player.
		{
		$stats = file_get_contents("$mcroot/world/stats/$playeruuid.json"); #read stats file contents.
		$json_decode = json_decode($stats,true);
		$result_printr = print("<pre>".print_r($json_decode,true."</pre>"));
		//extract($result_printr, EXTR_PREFIX_ALL, "stat");
		echo $result_printr;
		}
	else
		{
		if (file_exists("$mcroot/world/stats/$player.json")) #Legacy support
			{
			$stats = file_get_contents("$mcroot/world/stats/$player.json");
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