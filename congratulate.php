<?php
ignore_user_abort(true);
set_time_limit(0);

date_default_timezone_set("Asia/Baku");

//bu istfadeci adi set olbusa demeli o oz tebriklerini indi gondermek istiyir
$username = $_POST["username"];

//cookie
$gacookie="./.gacookie";
	
require_once("config.php");

require_once("functions/functions.php");

if(isset($username)){
	//yalniz bu istifadecininkilere baxsin chunki sorgu ondan gelib
	$rt = sendAutoCongrats($username);
	print $rt;
}
else{
	//bu gune olan avtotebrikleri gondersin
	$rt = sendAutoCongrats();
	print $rt;
}
	
//unlink edek
@unlink($gacookie);

@mysql_close($connection);	
?>