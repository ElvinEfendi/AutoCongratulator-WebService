<?php
$username = addslashes($_POST["username"]);
$password = sha1(addslashes($_POST["password"]));

require_once "config.php";

$query = "SELECT * FROM tblUser WHERE uUsername='$username' and uPassword='$password'";
$result = @mysql_query($query) or die("Sorğu icra oluna bilmir");
if($result)
{
	if(@mysql_num_rows($result)>0)
	{
		//ugurla daxil oldu
		session_register("userObject");
		$_SESSION["userObject"] = @mysql_fetch_object($result);
		header("Location:birthday.php");
	}
	else
	{
		$loginErr = "1"; //login parol kombinasiyasi duz deyil
		header("Location:userRegistration.php?success&loginErr=$loginErr");
	}
}
else
{
	$loginErr = "2"; //sorgu icra edilende sehv bas verdi
	header("Location:userRegistration.php?success&loginErr=$loginErr");
}
?>