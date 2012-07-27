<?php
$dbHost     = "";
$dbUserName = "";
$dbPassword = "";
$dbName     = "";

$connection = @mysql_connect($dbHost,$dbUserName,$dbPassword) or die("Mysql ile elaqe bash tutmadi");
@mysql_select_db($dbName, $connection) or die("Baza ile elaqe bash tutmadi");
?>
