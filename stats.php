<html>
<body>
<?php //Sputnik One Networks - Minecraft Web Stats - Version 0.0.2 pre-alpha - stats.php// //To customize, look for comments with prefix/suffix of ***
if (isset($_REQUEST['player'])) //check if $player variable is set
	{ //display form to input player info followed by stats as returned by the script
	echo "<form method='post' action='stats.php'>
	Player: <input name='player' type='text'<br>
	</textarea><br>
	<input type='submit'>
	</form>";
	$player = $_REQUEST['player'];
	$mcroot = "/mc/vanilla/"; //***change this to wherever your minecraft server root is***
	if (file_exists("$mcroot/world/stats/$player.json")) //test if we have stats for that player. ***CHANGE "world" to the name of your world if different***
		{
		$stats = file_get_contents("$mcroot/world/stats/$player.json"); //read stats file contents. ***CHANGE "world" to the name of your world if different***
		$json_decode = json_decode($stats,true);
		$result_printr = print("<pre>".print_r($json_decode,true."</pre>"));
		//extract($result_printr, EXTR_PREFIX_ALL, "stat"); //Currently not working. PHP Warning: extract() expects parameter 1 to be array, integer given in stats.php on line 18. Does not generate needed $stat_* variables needed to make custom format messages for each item.
		echo $result_printr;
		}
	else
		{
		echo "Player $player Not Found. Remember that player names are case sensitive.";
		}
	}
else //if $player variable is not set, display empty form
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