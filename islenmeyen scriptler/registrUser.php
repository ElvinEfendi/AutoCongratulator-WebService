<?php
session_start();
$operator = $_POST["operator"];             $_SESSION["operator"]  = $operator;
$telNumber = intval($_POST["telNumber"]);   $_SESSION["telNumber"] = $telNumber;
$username = addslashes($_POST["username"]); $_SESSION["username"]  = $username;
$password = addslashes($_POST["password"]); $_SESSION["password"] = $password;
$sign = addslashes($_POST["sign"]);         $_SESSION["sign"] = $sign;

$err = "";
if($operator!="Bakcell" && $operator!="Azercell")
{
	$err.="1";
}
if(strlen($telNumber)!=7)
{
	$err.="2";
}
if(strlen($username)<3)
{
	$err .="3";
}
if(strlen($password)<3)
{
	$err .="4";
}

if($err!="")
{
	header("Location:userRegistration.php?err=$err");
}
else
{
	//indi melumatlari yazaq bazaya
	require_once "config.php";
	$query = "INSERT INTO tblUser(uSign, uUsername, uOrgPassword, uPassword, uOperator, uPhoneNumber) VALUES(".
	         "'$sign', '$username', '$password', '".sha1($password)."', '$operator', '$telNumber')";
	$result = @mysql_query($query) or die("Sorğu icra oluna bilmir");
	if($result)
	{
		//ugurla elave olundu
		header("Location:userRegistration.php?success");
	}
	else
	{
		header("Location:userRegistration.php?queryErr");
	}
}

?>