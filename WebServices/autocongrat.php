<?php
// -------------------------------------------User -e aid funksyalar ---------------------------
 /**
 * verilmis melumatlari bazaya daxil edir-yeni istifadeci yaradir, yarandisa 1 eks halda sehvin nomresini qaytarir
 * 0  - sorgunun icrasiyla elaqeli sehv bas verdi
 * -1 - bele nomre sistemde var
 * -2 - bele istifadeciartiq sistemde var
 * @param UserObject $userObject
 * @return int result
 */
function createUser($userObject) {
	require_once("../config.php");
	$sign      = mysql_real_escape_string($userObject["sign"]);
	$username  = mysql_real_escape_string($userObject["username"]);
	$password  = mysql_real_escape_string($userObject["password"]); //orjinal password
	$operator  = mysql_real_escape_string($userObject["mobileOperator"]);
	$telNumber = $userObject["phoneNumber"];
	
	//gorek bazada bele istifadeci varmi
	$tmpUserRes = @mysql_query("SELECT uId FROM tblUser WHERE uUsername = '$username'");
	//gorek bu nomre qeydiyyatdan kecibmi sistemde
	$tmpNumberRes = @mysql_query("SELECT uId FROM tblUser WHERE uPhoneNumber = '$telNumber'");
	
	$countUser = @mysql_num_rows($tmpUserRes);
	$countNumber = @mysql_num_rows($tmpNumberRes);
	if($countNumber>0)
	{
		//bele nomre qeydiyyatdan kecib
		return -1;
	}
	elseif($countUser>0)
	{
		//bele istifadeci var
		return -2;
	}
	else
	{
		$query = "INSERT INTO tblUser(uSign, uUsername, uPassword, uOperator, uPhoneNumber) VALUES(".
	             "'$sign', '$username', '$password', '$operator', '$telNumber')";
		$result = @mysql_query($query);
		if($result){
			return 1;
		}
		else{
			return 0;
		}
	}
	@mysql_close($connection);
}

 /**
 * uygun id-li istifadecinin melumatlarini yenileyir
 * @param UserObject $userObject, int $userId
 * @return int result
 */
function updateUser($userObject, $userId) {
	require_once("../config.php");
	
	$userId = intval($userId);
	
	$sign      = mysql_real_escape_string($userObject["sign"]);
	$username  = mysql_real_escape_string($userObject["username"]);
	$password  = mysql_real_escape_string($userObject["password"]); //orjinal password
	$operator  = mysql_real_escape_string($userObject["mobileOperator"]);
	$telNumber = $userObject["phoneNumber"];
	
		//gorek bazada bele istifadeci varmi
	$tmpUserRes = @mysql_query("SELECT uId FROM tblUser WHERE uUsername = '$username' and uId<>$userId");
	//gorek bu nomre qeydiyyatdan kecibmi sistemde
	$tmpNumberRes = @mysql_query("SELECT uId FROM tblUser WHERE uPhoneNumber = '$telNumber' and uId<>$userId");
	
	$countUser = @mysql_num_rows($tmpUserRes);
	$countNumber = @mysql_num_rows($tmpNumberRes);
	if($countNumber>0)
	{
		//bele nomre qeydiyyatdan kecib
		return -1;
	}
	elseif($countUser>0)
	{
		//bele istifadeci var
		return -2;
	}
	else
	{
	
		$query = "UPDATE tblUser SET  uSign        = '$sign', ".
		                             "uUsername    = '$username', ".
									 "uPassword    = '$password', ".
									 "uOperator    = '$operator', ".
									 "uPhoneNumber = '$telNumber' WHERE uId=$userId";
								 
		$result = @mysql_query($query);
		
		if($result){
			return 1;
		}
		else{
			return 0;
		}
	}
	
	@mysql_close($connection);
}

 /**
 * uygun id-li istifadecinin melumatlarini silir
 * @param int $userId
 * @return booloean result
 */
function deleteUser($userId) {
	require_once("../config.php");
	
	$userId = intval($userId);
	
	$query = "DELETE FROM tblUser WHERE uId=$userId";
	
	$result = @mysql_query($query);
	if($result){
		return true;
	}
	else{
		return false;
	}
	@mysql_close($connection);
}
 /**
 * verilmis login parola uygun yazi tapildisa onun id-sini eks halda sehvin kodunu(<=0) qaytarir
 * bu funksya -3 qaytarsa proqram ozu ozunu baglayacaq ve lisenziya problemi var, muellifle elaqe saxla deyecek*
 * @param string $username, string $password
 * @return int loginResult
 */
function login($username, $password) {
	require_once("../config.php");
	$username = mysql_real_escape_string($username);
	$password = mysql_real_escape_string($password);
	$query = "SELECT * FROM tblUser WHERE uUsername='$username' and uPassword='$password'";
	$result = @mysql_query($query);
	if($result){
		if(@mysql_num_rows($result)==1)
		{
			$row = @mysql_fetch_assoc($result);
			return $row["uId"];
		}
		else
		{
			return -1;
		}
	}
	else{
		return 0; //sorgunun icrasi ile elaqeli sehv bas verdi
	}
	@mysql_close($connection);
}

/**
 * verilmis userId-ye uygun yazini qaytarir
 * @param int $uId
 * @return UserObject userProfile
 */
function getUserObject($uId){
	require_once("../config.php");
	
	$uId = intval($uId);
	$query = "SELECT uSign, uUsername, uPassword, uOperator, uPhoneNumber ".
	         "FROM tblUser WHERE uId=$uId";
	$result = @mysql_query($query);
	$userObject = @mysql_fetch_object($result);	
	return array("sign"            => "$userObject->uSign",
	             "username"        => "$userObject->uUsername",
				 "password"        => "$userObject->uPassword",
				 "mobileOperator"  => "$userObject->uOperator",
				 "phoneNumber"     => "$userObject->uPhoneNumber");
	@mysql_close($connection);
}
// -------------------------------------------Dogum gunlerine(AvtoTebrik)-e aid funksyalar ---------------------------
/**
 * yeni AvtoTebrik yaradir ugurlu olanda bu avtotebrikin id sini eks halda uygun sehvin nomresini qaytarir
 * -3 qaytaranda proqram artiq tebrik yaratma limitinin dolmasini xeber verir ve emaille elaqe saxlamasini deyir*
 * @param AutoCongratObject $autoCongrat
 * @return int $result
 */

function createAutoCongrat($autoCongrat){
	require_once("../config.php");
	$title              = mysql_real_escape_string($autoCongrat["title"]);
	$receiverFullNumber = mysql_real_escape_string($autoCongrat["receiverFullNumber"]);
	$message            = mysql_real_escape_string($autoCongrat["message"]);
	$userId             = intval($autoCongrat["userId"]); //hansi istifadeci bunu gonderdiyini gosterir
	$birthDate          = mysql_real_escape_string($autoCongrat["birthDate"]);
	
	//bu istifadecinin avtotebrik yaratma limitinin dolub dolmamagini yoxlayiriq
	$fullLimit = false;
	
	if(!$fullLimit)
	{
		//yeni limiti doluyubsa yaratmaga calisiriq
		
		//bu daxil edeceyimiz avtotebrikin id sini goturek
		$res = @mysql_query("SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE  TABLE_NAME='tblBirthday'");
		$aiArr = @mysql_fetch_assoc($res);
		$ai = intval($aiArr["AUTO_INCREMENT"]);
	    //avtotebriki daxil edek	
		$query = "INSERT INTO tblBirthday(bTitle, bReceiverNumber, bMessage, uId, bDate) VALUES(".
		         "'$title', '$receiverFullNumber', '$message', '$userId', '$birthDate')";
		$result = @mysql_query($query);
		if($result){
			//daxil edildiyini gore id -sini qaytaraq
			return $ai;
		}
		else{
			//sehv bas verdi
			return 0;
		}
	}
	else
	{
		//limit dolub proqram xeberdarliq etsin
		return -3;
	}
	@mysql_close($connection);	
}
 /**
 * uygun id-li AutoCongrat(Birthday)-in melumatlarini yenileyir
 * @param AutoCongratObject $autoCongrat, int $bId
 * @return booloean result
 */
function updateAutoCongrat($autoCongrat, $bId) {
	require_once("../config.php");
	$bId = intval($bId);
	
	$title              = mysql_real_escape_string($autoCongrat["title"]);
	$receiverFullNumber = mysql_real_escape_string($autoCongrat["receiverFullNumber"]);
	$message            = mysql_real_escape_string($autoCongrat["message"]);
	$userId             = intval($autoCongrat["userId"]); //hansi istifadeci bunu gonderdiyini gosterir
	$birthDate          = mysql_real_escape_string($autoCongrat["birthDate"]);
	
	$query = "UPDATE tblBirthday SET  bTitle      = '$title', ".
								 "bReceiverNumber = '$receiverFullNumber', ".
								 "bMessage        = '$message', ".
								 "uId             = '$userId', ".
								 "bDate           = '$birthDate' WHERE bId=$bId";
								 
	$result = @mysql_query($query);
	
	if($result){
		return true;
	}
	else{
		return false;
	}
	@mysql_close($connection);
}
 /**
 * uygun id-libirthday(autocongrat) in melumatlarini silir
 * @param int $bId
 * @return booloean result
 */
function deleteAutoCongrat($bId) {
	require_once("../config.php");
	
	$bId = intval($bId);
	
	$query = "DELETE FROM tblBirthday WHERE bId=$bId";
	
	$result = @mysql_query($query);
	if($result){
		return true;
	}
	else{
		return false;
	}
	@mysql_close($connection);
}
 /**
 * bId ye uygun autoCongrat i qaytarir
 * @param int $bId
 * @return  AutoCongratObject
 */
 function getAutoCongrat($bId){
	 require_once("../config.php");
	
	$bId = intval($bId);
	$query = "SELECT bId, bTitle, bReceiverNumber, bMessage, uId, bDate, bWasSent ".
	         "FROM tblBirthday WHERE bId=$bId";
	$result = @mysql_query($query);
	$userObject = @mysql_fetch_object($result);	
	return array("id"                 => "$userObject->bId",
				 "title"              => "$userObject->bTitle",
	             "receiverFullNumber" => "$userObject->bReceiverNumber",
				 "message"            => "$userObject->bMessage",
				 "userId"             => "$userObject->uId",
				 "birthDate"          => "$userObject->bDate",
				 "wasSent"            => "$rows[bWasSent]");
				 
	@mysql_close($connection);
 }
 /**
 * verilmis istifadecinin autoCongrat-birthdaylerini qaytarir
 * @param int $userId
 * @return  AutoCongratObjectArray
 */
function getAutoCongrats($userId) {
	require_once("../config.php");
	
	$userId = intval($userId);
	
	$query = "SELECT bId, bTitle, bReceiverNumber, bMessage, uId, bDate, bWasSent ".
	         "FROM tblBirthday  WHERE uId=".$userId." ORDER BY bWasSent ASC, bDate ASC, bId DESC";
	$result = @mysql_query($query);
	$arr = array();
	while($rows = @mysql_fetch_assoc($result))
	{
		array_push($arr,array('id'=>"$rows[bId]",
						      'title'=>"$rows[bTitle]",
							  'receiverFullNumber'=>"$rows[bReceiverNumber]",
							  'message'=>"$rows[bMessage]",
							  'userId'=>"$rows[uId]",
							  'birthDate'=>"$rows[bDate]",
							  'wasSent'=>"$rows[bWasSent]"));
	}
	return $arr; /*array(array('newsTitle'=>'Ilin shok xeberi'),
	             array('newsTitle'=>'nebilim ne'));*/
	
	@mysql_close($connection);
}
// -------------------------------------------funksyalarin tesviri bitdi       ---------------------------------------------------
require_once("lib/nusoap/nusoap.php");

$namespace = "http://yoxlama.com/AutoCongratulate";

// create a new soap server
$server = new soap_server();

// configure our WSDL
$server->configureWSDL("AutoCongratulateService");

// set our namespace
$server->wsdl->schemaTargetNamespace = $namespace;

//userle islemek ucun murekkeb tip elave edek
$server->wsdl->addComplexType(
    'UserObject',
    'complexType',
    'struct',
    'all',
    '',
    array(
        'sign'           => array('name'=>'sign'           , 'type'=>'xsd:string'),
        'username'       => array('name'=>'username'       , 'type'=>'xsd:string'),
		'password'       => array('name'=>'passowrd'       , 'type'=>'xsd:string'),
        'mobileOperator' => array('name'=>'mobileOperator' , 'type'=>'xsd:string'),
        'phoneNumber'    => array('name'=>'phoneNumber'    , 'type'=>'xsd:string')
    )
);

//Birthday(AutoCongrat) la islemek ucun murekkeb tip elave edek
$server->wsdl->addComplexType(
    'AutoCongratObject',
    'complexType',
    'struct',
    'all',
    '',
    array(
		'id'                 => array('name'=>'id'                , 'type'=>'xsd:int'),
        'title'              => array('name'=>'title'             , 'type'=>'xsd:string'),
        'receiverFullNumber' => array('name'=>'receiverFullNumber', 'type'=>'xsd:string'),
		'message'            => array('name'=>'message'           , 'type'=>'xsd:string'),
		'userId'             => array('name'=>'userId'            , 'type'=>'xsd:int'),
        'birthDate'          => array('name'=>'birthDate'         , 'type'=>'xsd:string'),
		'wasSent'            => array('name'=>'wasSent'           , 'type'=>'xsd:int')
    )
);
//bir nece autoCongrat yazisi ile islemek ucun AutoCongratObject lerden ibaret array timi
$server->wsdl->addComplexType(
    'AutoCongratObjectArray',
    'complexType',
    'array',
    '',
    'SOAP-ENC:Array',
    array(),
    array(array('ref'=>'SOAP-ENC:arrayType','wsdl:arrayType'=>'tns:AutoCongratObject[]')),
    'tns:AutoCongratObject'
);
//koding i  utf-8 edek
$server->soap_defencoding = 'UTF-8'; 
//------------------------------------user funksyalarin elave edilmesi------------------------------------
// register our WebMethod - login()
$server->register(
    'login',
    array('username'=>'xsd:string', 'password'=>'xsd:string'),
    array('return'=>'xsd:int'),
    $ns,
    false,
    'rpc',
    false,
    'username ve password -u bazada yoxlayir uygun neticeni true ve ya false olaraq qaytarir');

// register our WebMethod - getUserObject()
$server->register(
    'getUserObject',
    array('userId'=>'xsd:int'),
    array('return'=>'tns:UserObject'),
    $ns,
    false,
    'rpc',
    false,
    'userId-ye uygun melumat yazisini qaytarir');

// register our WebMethod - createUser($userObjet)
$server->register(
    'createUser',
    array('userObject' =>'tns:UserObject'),
    array('return'     =>'xsd:int'),
    $ns,
    false,
    'rpc',
    false,
    'userObject deki melumatlara uygun istifadeci yaradir');
	
// register our WebMethod - updateUser($userObject, $userId)
$server->register(
    'updateUser',
    array('userObject' => 'tns:UserObject', 'userId' => 'xsd:int'),
    array('return'     => 'xsd:int'),
    $ns,
    false,
    'rpc',
    false,
    'istifadecinin melumatlarini yenileyir');

// register our WebMethod - deleteUser($userId)
$server->register(
    'deleteUser',
    array('userId' =>'xsd:int'),
    array('return' =>'xsd:boolean'),
    $ns,
    false,
    'rpc',
    false,
    'istifadecini sistemin bazasindan silir');
	
//------------------------------------autoCongrat(birthday) funksyalarin elave edilmesi------------------------------------
// register our WebMethod - createAutoCongrat($autoCongrat)
$server->register(
    'createAutoCongrat',
    array('autoCongrat' =>'tns:AutoCongratObject'),
    array('return'     =>'xsd:int'),
    $ns,
    false,
    'rpc',
    false,
    'melumatlara uygun AvtoTebrik-dogum gunu yaradir');
	
// register our WebMethod - updateAutoCongrat($autoCongrat, $bId)
$server->register(
    'updateAutoCongrat',
    array('autoCongrat' => 'tns:AutoCongratObject', 'bId' => 'xsd:int'),
    array('return'      => 'xsd:boolean'),
    $ns,
    false,
    'rpc',
    false,
    'autocongrati yenileyir');

// register our WebMethod - deleteAutoCongrat($bId)
$server->register(
    'deleteAutoCongrat',
    array('bId'    =>'xsd:int'),
    array('return' =>'xsd:boolean'),
    $ns,
    false,
    'rpc',
    false,
    'autocongrati sistemin bazasindan silir');

// register our WebMethod - getAutoCongrat($bId)
$server->register(
    'getAutoCongrat',
    array('bId'    =>'xsd:int'),
    array('return'    =>'tns:AutoCongratObject'),
    $ns,
    false,
    'rpc',
    false,
    'uygun avtotebriki qaytarir');

// register our WebMethod - getAutoCongrats($userId)
$server->register(
    'getAutoCongrats',
    array('userId'    =>'xsd:int'),
    array('return'    =>'tns:AutoCongratObjectArray'),
    $ns,
    false,
    'rpc',
    false,
    'uygun istifadecinin bazaya yazdigi avtotebrikleri qaytarir');
//-------------------------------------FUNKSYALARIN ELAVE EDILMESI SONA CATDI-------------------------------------
                
// Get our posted data if the service is being consumed
// otherwise leave this data blank.                
$POST_DATA = isset($GLOBALS['HTTP_RAW_POST_DATA']) 
                ? $GLOBALS['HTTP_RAW_POST_DATA'] : '';

// pass our posted data (or nothing) to the soap service -- utf8_encode()-u sora elave etdim xeyri deydi                   
$server->service(utf8_encode($POST_DATA));                
exit();
?>