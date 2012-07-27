<?php
$username = $_POST["username"];

require_once "config.php";
require_once "functions/functions.php";

// bir curl init edek
$ch = curl_init();
$gacookie="./.gacookie";

$rt = rememberUserPassword($username);
if($rt)
{
	print "Sent";
}
else
{
	print "Error";
}

//curlu baglayaq
curl_close($ch);
//bunu da unlink edek
@unlink($gacookie);

@mysql_close($connection);
?>