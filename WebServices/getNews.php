<?php
 /**
 * verilmis login parola uygun yazi tapildisa true eks halda false qaytarir
 * @param string $username, string $password
 * @return bool loginResult
 */
function login($username, $password) {
	require_once("../config.php");
	$username = mysql_real_escape_string($username);
	$query = "SELECT * FROM tblUser WHERE uUsername='$username' and uPassword='$password'";
	$result = @mysql_query($query);
	if($result){
		if(@mysql_num_rows($result)==1)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	else{
		return false;
	}
}

require_once("lib/nusoap/nusoap.php");
$namespace = "http://yoxlama.com/AutoCongratulate";
// create a new soap server
$server = new soap_server();
// configure our WSDL
$server->configureWSDL("AutoCongratulate");
// set our namespace
$server->wsdl->schemaTargetNamespace = $namespace;
//koding i  utf-8 edek
$server->soap_defencoding = 'UTF-8'; 
// register our WebMethod - login()
$server->register(
    'login',
    array('username'=>'xsd:string', 'password'=>'xsd:string'),
    array('return'=>'xsd:bool'),
    $ns,
    false,
    'rpc',
    false,
    'username ve password -u bazada yoxlayir uygun neticeni true ve ya false olaraq qaytarir');
                
// Get our posted data if the service is being consumed
// otherwise leave this data blank.                
$POST_DATA = isset($GLOBALS['HTTP_RAW_POST_DATA']) 
                ? $GLOBALS['HTTP_RAW_POST_DATA'] : '';

// pass our posted data (or nothing) to the soap service                    
$server->service($POST_DATA);                
exit();
?>