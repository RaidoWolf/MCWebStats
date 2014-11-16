<?php

// -- MAIN CONFIGURATION FILE -- //

# VARIABLES
$mcroot = '/mc/vanilla/'; //root of Minecraft server
$mcworld = 'world'; //name of the world (more specifically, the name of the save folder)
# END OF SECTION

# STAT MODIFICATION VIA EDITOR.PHP
$enableModify = 0; //allow modification of stats via editor.php? (bit)
$enableModifyAuth = 1; //require authentication to modify stats via editor.php? (bit)
$modifyAuth = array( //list of user/password combinations for editor.php (associative array)
	'username1' => 'password1', //if you're going to use this, delete these demo users.
	'username2' => 'password2',
	'username3' => 'password3'
);
# END OF SECTION

# AUTOFIXES
$autoCombineLegacyStats = 1; //automatically combine old stat values with their new equivalents (on user lookup)
$autoFixUnsignedAnomaly = 1; //automatically convert odd unsigned number anomalies (negative scores) back to their correct signed forms (on user lookup)

// -- END OF CONFIGURATION FILE -- //

?>
