<?php
ignore_user_abort(true);
set_time_limit(0);

date_default_timezone_set("Asia/Baku");

require_once("config.php");

//cookie
$gacookie="./.gacookie";

require_once("functions/functions.php");

//bu gune olan xeberdarliqlari gondersin
notifyUser();

//bunu da unlink edek
@unlink($gacookie);

@mysql_close($connection);	
?>