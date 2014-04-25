mcwebstats
==========
By Alex Barber and Sputnik One Networks
Minecraft server/player statistics standalone web application suite.
==========

Configuration:
	*stats.php
		$mcroot - Line 12. This variable needs to be set manually. It should be the location of the root of the minecraft server (the folder containing the server.jar file).
		Line 13 - This contains a path to the stats files of the world. The path may need to be changed if your world folder is not named "world".
		$stats - Line 15. This contains a path to the stats files of the world as well. It will also need to be changed if the world has been given a custom name.

Known Issues:
	*stats.php
		- Player names are case sensitive. Although not a bug, it is an issue which creates a bit of an inconvenience.
		- json_decode line is not producing a valid array according to the error logs, and therefore extract() function cannot generate valid variables based on individual stats. Rather, calling one of those variables returns "1".
		- NOTE: this script has not been tested extensively for security, and does not have any foolproof input sanitization, so be cautious using this script on servers with important data, and use it at your own risk.

//END