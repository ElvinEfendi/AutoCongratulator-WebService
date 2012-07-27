<?php
$dbHost     = "dbautocongrat.db.5179961.hostedresource.com";
$dbUserName = "dbautocongrat";
$dbPassword = "QidiQudu1989";
$dbName     = "dbautocongrat";

$connection = @mysql_connect($dbHost,$dbUserName,$dbPassword) or die("Mysql ile elaqe bash tutmadi");
@mysql_select_db($dbName, $connection) or die("Baza ile elaqe bash tutmadi");
?>