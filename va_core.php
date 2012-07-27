<?php
ignore_user_abort(true);
set_time_limit(0);

date_default_timezone_set("Asia/Baku");

$m = intval(date("i"));

if($m==00){	
	//xeberdarliq etmek ucun
	include("/home/content/h/e/r/hers19/html/AutoCongratulate/notify.php");
}
else{
	//mesajlari gondermek ucun
	include("/home/content/h/e/r/hers19/html/AutoCongratulate/congratulate.php");
}

?>