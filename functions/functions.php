<?php
/**
 * azercell -e login olaq
 * @param int $loginPrefix, string $userName, string $password
 * return bool $result
 */
function azLogin($loginPrefix, $userName, $password)
{
	/*global*/ $ch = curl_init();
	global $gacookie;
	
	$userName=urlencode($userName);

	$postdata="cmnd=login&loginprefix=".$loginPrefix."&login=".$userName."&pw=".$password."&Submit=Daxil et";
	
	curl_setopt ($ch, CURLOPT_URL,"http://www.azercell.com/WebModule1/mainservlet");
	curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt ($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6");
	curl_setopt ($ch, CURLOPT_TIMEOUT, 60);
	curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt ($ch, CURLOPT_COOKIEJAR, $gacookie);
	curl_setopt ($ch, CURLOPT_COOKIEFILE, $gacookie);
	curl_setopt ($ch, CURLOPT_REFERER, 'http://www.azercell.com/');
	curl_setopt ($ch, CURLOPT_POSTFIELDS, $postdata);
	curl_setopt ($ch, CURLOPT_POST, 1);
	$login_result = curl_exec ($ch);
	curl_close($ch);
	if(strpos($login_result, "Your login and password are OK")>-1)
	{
		return true;
	}
	else
	{
		return false;
	}
}

/**
 * azercell -e mesaj gonderir
 * @param int $numberPrefix, int $number, string $message
 * return bool $result
 */
function azSendMessage($numberPrefix, $number, $message)
{
	/*global*/ $ch = curl_init();
	global $gacookie;

	$message = urlencode(trim($message));
	$messageDate = ""; //yeni submit olunan gun gonderecek
	$remainderCount = 148 - strlen($message);
	$postdata="cmnd=sms&subcmnd=submit&prefix=".$numberPrefix."&sendto=".$number.
              "&messj=".$message."&smsdate=".$messageDate."&cntr=".$remainderCount."&submit=Göndər";
			  
	curl_setopt ($ch, CURLOPT_URL,"http://www.azercell.com/WebModule1/mainservlet");
	curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt ($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6");
	curl_setopt ($ch, CURLOPT_TIMEOUT, 60);
	curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt ($ch, CURLOPT_COOKIEJAR, $gacookie);
	curl_setopt ($ch, CURLOPT_COOKIEFILE, $gacookie);
	curl_setopt ($ch, CURLOPT_REFERER, 'http://www.azercell.com/WebModule1/mainservlet');
	curl_setopt ($ch, CURLOPT_POSTFIELDS, $postdata);
	curl_setopt ($ch, CURLOPT_POST, 1);
	$sendMessage_result = curl_exec ($ch);
	curl_close($ch);
	if(strpos($sendMessage_result, "Your SMS was sent.")>-1)
	{
		return true;
	}
	else
	{
		return false;
	}
}

//azercelle login olur ve sms gonderir sehv bas verende false qaytarir
function azLoginAndSendSms($loginPrefix, $userName, $password, $numberPrefix, $number, $message)
{
	if(azLogin($loginPrefix, $userName, $password))
	{
		if(azSendMessage($numberPrefix, $number, $message))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	else
	{
		return false;
	}
}
//--------------------------------------------------------------------------------------------------------------------------------
/**
 * bakcell -e login olaq
 * @param int $loginPrefix, string $userName, string $password
 * return bool $result
 */
function bkLogin($userName, $password)
{
	/*global*/ $ch = curl_init();
	global $gacookie;
	
	$userName = urlencode(trim($userName));
	
	//login csrfi goturek--------------------------------------
	curl_setopt ($ch, CURLOPT_URL,"http://bakcell.com/en/login");
	curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt ($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6");
	curl_setopt ($ch, CURLOPT_TIMEOUT, 60);
	curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt ($ch, CURLOPT_COOKIEJAR, $gacookie);
	curl_setopt ($ch, CURLOPT_COOKIEFILE, $gacookie);
	curl_setopt ($ch, CURLOPT_REFERER, 'http://bakcell.com/');
	$csrf_result = curl_exec ($ch);
	
	$csrf = substr($csrf_result, strpos($csrf_result, "signin[_csrf_token]\" value=\"")+28, 32);
	$postdata = "signin[username]=" . $userName .
	    	    "&signin[password]=" . $password .
         		"&signin[_csrf_token]=" . $csrf;
	//csrfi goturduk indi login olaq-----------------------
	curl_setopt ($ch, CURLOPT_URL,"http://bakcell.com/en/login");
	curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt ($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6");
	curl_setopt ($ch, CURLOPT_TIMEOUT, 60);
	curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt ($ch, CURLOPT_COOKIEJAR, $gacookie);
	curl_setopt ($ch, CURLOPT_COOKIEFILE, $gacookie);
	curl_setopt ($ch, CURLOPT_REFERER, 'http://bakcell.com/');
	curl_setopt ($ch, CURLOPT_POSTFIELDS, $postdata);
	curl_setopt ($ch, CURLOPT_POST, 1);
	$login_result = curl_exec ($ch);
	curl_close($ch);

	if(strpos($login_result, "Send SMS")>-1)
	{
		//login oldu
		return true;
	}
	else
	{
		//login ola bilmedi
		return false;
	}
}

/**
 * bakcell -e mesaj gonderir
 * @param int $numberPrefix, int $number, string $message
 * return bool $result
 */
function bkSendMessage($numberPrefix, $number, $message)
{
	/*global*/ $ch = curl_init();
	global $gacookie;
	
	//mesaj csrf-i goturek---------------
	curl_setopt ($ch, CURLOPT_URL,"http://bakcell.com/en/sendSMS");
	curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt ($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6");
	curl_setopt ($ch, CURLOPT_TIMEOUT, 60);
	curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt ($ch, CURLOPT_COOKIEJAR, $gacookie);
	curl_setopt ($ch, CURLOPT_COOKIEFILE, $gacookie);
	curl_setopt ($ch, CURLOPT_REFERER, 'http://bakcell.com/');
	$sms_csrf_result = curl_exec ($ch);
	
	$sms_csrf = substr($sms_csrf_result, strpos($sms_csrf_result, "sms[_csrf_token]\" value=\"") + 25, 32);
	$smsUserId = substr($sms_csrf_result, strpos($sms_csrf_result, "id=\"sms__csrf_token\"") + 39, 5);
	//mesaji gonderek----------------------------
	$message = urlencode(trim($message));
	$postdata="sms[_csrf_token]=" . $sms_csrf .
              "&sms[user_id]=" . $smsUserId .
              "&code=994" . $numberPrefix .
              "&sms[mobile]=" . $number .
              "&sms[message]=" . $message;
	curl_setopt ($ch, CURLOPT_URL,"http://bakcell.com/en/sendSMS");
	curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt ($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6");
	curl_setopt ($ch, CURLOPT_TIMEOUT, 60);
	curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt ($ch, CURLOPT_COOKIEJAR, $gacookie);
	curl_setopt ($ch, CURLOPT_COOKIEFILE, $gacookie);
	curl_setopt ($ch, CURLOPT_REFERER, 'http://bakcell.com/');
	curl_setopt ($ch, CURLOPT_POSTFIELDS, $postdata);
	curl_setopt ($ch, CURLOPT_POST, 1);
	$sendMessage_result = curl_exec ($ch);
	curl_close($ch);
	
	if(strpos($sendMessage_result, "Your sms has been sent.")>-1)
	{
		return true;
	}
	else
	{
		return false;
	}
}

//bakcell-e login olur ve sms gonderir sehv bas verende false qaytarir
function bkLoginAndSendSms($userName, $password, $numberPrefix, $number, $message)
{
	if(bkLogin($userName, $password))
	{
		if(bkSendMessage($numberPrefix, $number, $message))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	else
	{
		return false;
	}
}

//------------------------------------------------------------------------------------------------
//bazadan bu gune olan AvtoTebrikleri goturur ve onlara uygun userin adindan sms gonderir
function sendAutoCongrats($settedUsername = null)
{
	$today = date("Y-m-d");
	
	$tmpStmt = ($settedUsername != null) ? "and u.uUsername='$settedUsername'" : "";
	
	$query = "SELECT u.uUsername, u.uPassword, u.uOperator, u.uPhoneNumber, ".
	         "b.* FROM tblBirthday b, tblUser u WHERE ".
			 "b.bDate = '".$today."' and u.uId=b.uId and b.bWasSent='0' and bHasError<>'1' ".$tmpStmt." LIMIT 0,1";
			 
	$result = @mysql_query($query);
	$tmpRt = true; //gonderilesi olanlarin hamisinin gonderildiyini yoxlamaq ucun
	$rt = false;
	while($rows = @mysql_fetch_assoc($result))
	{	
		$numberPrefix = substr($rows["bReceiverNumber"],0,2);
		$number = substr($rows["bReceiverNumber"],2);
	    if($rows["uOperator"]=="Bakcell")
		{
			//bakcell ile gonderirik avtotebriki
			$rt = bkLoginAndSendSms($rows["uUsername"], $rows["uPassword"], $numberPrefix, $number, $rows["bMessage"]);
		}
		elseif($rows["uOperator"]=="Azercell")
		{
			//azercell ile gonderirik avtotebriki
			$loginPrefix = substr($rows["uPhoneNumber"], 0, 2);
			$login = substr($rows["uPhoneNumber"], 2);
			$rt = azLoginAndSendSms($loginPrefix, $login, 
			                        $rows["uPassword"], $numberPrefix,
									$number, $rows["bMessage"]);
		}
		if($rt)
		{
			//mesaj gonderildi bunu bazada qeyd edek
			@mysql_query("UPDATE tblBirthday SET bWasSent='1' WHERE bId=".$rows["bId"]);
		}
		else
		{
			//logla
			//sehv bas verdi
			@mysql_query("UPDATE tblBirthday SET bHasError='1' WHERE bId=".$rows["bId"]);
			//istifadeciye tebrikinin getmemesi barede xeber vermeye calisaq
			$numberPrefix = substr($rows["uPhoneNumber"],0,2);
			$number = substr($rows["uPhoneNumber"],2);
			$message = "Salam, sizin ".$rows["bReceiverNumber"]." nomresine olan mesajiniz gonderilmedi!";
		    if($rows["uOperator"]=="Bakcell")
			{
				//bakcell ile gonderirik avtotebriki
				$hasErRt = bkLoginAndSendSms($rows["uUsername"], $rows["uPassword"], $numberPrefix, $number, $message);
			}
			elseif($rows["uOperator"]=="Azercell")
			{
				//azercell ile gonderirik avtotebriki
				$loginPrefix = substr($rows["uPhoneNumber"], 0, 2);
				$login = substr($rows["uPhoneNumber"], 2);
				$hasErRt = azLoginAndSendSms($loginPrefix, $login, 
				                        $rows["uPassword"], $numberPrefix,
										$number, $message);
			}
			//if($hasErRt){ print "1"; } else {print "0";};
			
		}
		//gonderilesi olanlarin hamisinin gonderildiyini yoxlamaq ucun
		$tmpRt = ($tmpRt && $rt);
				
	}//while
	$tmpRt = ($tmpRt && $rt);
	return $tmpRt;
}

//yoxluyur eger sabaha dogum gunu varsa bu gun istifadeciye xeberdarliq edir
function notifyUser()
{
	$today = date("Y-m-d");
	
	$tmpDate = strtotime(" +1 day ", strtotime($today));
	$tomorrow = date("Y-m-d", $tmpDate);
	
	$query = "SELECT u.uSign, u.uUsername, u.uPassword, u.uOperator, u.uPhoneNumber, ".
	         "b.* FROM tblBirthday b, tblUser u WHERE ".
			 "b.bDate = '".$tomorrow."' and u.uId=b.uId and b.bWasSent='0' and b.bNotified='0' and bHasError='0' "." LIMIT 0,1";
			 
	$result = @mysql_query($query);
	$count = @mysql_num_rows($result);
	
	if($count>0){
		while($rows = @mysql_fetch_assoc($result))
		{
			$numberPrefix = substr($rows["uPhoneNumber"],0,2);
			$number = substr($rows["uPhoneNumber"],2);
			$greeting = (strlen($rows["uSign"])>0) ? "Salam, ".$rows["uSign"] : "Salam";
			$message = $greeting.". Sabah \"".$rows["bReceiverNumber"].
			           "\" nömresine sizden smsle tebrik gönderilecek, AvtoTebrik sistemi.";
		    if($rows["uOperator"]=="Bakcell")
			{
				//bakcell ile gonderirik
				$rt = bkLoginAndSendSms($rows["uUsername"], $rows["uPassword"], $numberPrefix, $number, $message);
			}
			elseif($rows["uOperator"]=="Azercell")
			{
				//azercell ile gonderirik
				$loginPrefix = substr($rows["uPhoneNumber"], 0, 2);
				$login = substr($rows["uPhoneNumber"], 2);
				$rt = azLoginAndSendSms($loginPrefix, $login, 
				                        $rows["uPassword"], $numberPrefix,
										$number, $message);
			}
			if($rt)
			{
				//mesaj gonderildi bunu bazada qeyd edek
				@mysql_query("UPDATE tblBirthday SET bNotified='1' WHERE bId=".$rows["bId"]);
			}
			else
			{
				//logla
				//xeberdarliq sehvi var
				@mysql_query("UPDATE tblBirthday SET bHasError='2' WHERE bId=".$rows["bId"]);
				
			}
		
		}//while
	}//if($count>0)
	else{
		//xeberdarliq etmek ucun user yoxdursa tebrik gondermeye calissin varsa
		sendAutoCongrats();
	}
}

//istifadeci sifresini unudanda bu funksyani cagiraraq sifresini smsle ala biler
function rememberUserPassword($username){
	$query = "SELECT uSign, uUsername, uPassword, uPhoneNumber, uOperator FROM tblUser WHERE uUsername = '".$username."'";
	$result = @mysql_query($query);
	$info = @mysql_fetch_assoc($result);
	$numberPrefix = substr($info["uPhoneNumber"],0,2);
	$number = substr($info["uPhoneNumber"],2);
	
	$message = "Salam, ".$info["uSign"]."\nSizin shifreniz: ".$info["uPassword"].", AvtoTebrik sistemi.";
	
	if($info["uOperator"]=="Bakcell")
	{
		//bakcell ile gonderirik
		$rt = bkLoginAndSendSms($info["uUsername"], $info["uPassword"], $numberPrefix, $number, $message);
	}
	elseif($info["uOperator"]=="Azercell")
	{
		//azercell ile gonderirik
		$loginPrefix = substr($info["uPhoneNumber"], 0, 2);
		$login = substr($info["uPhoneNumber"], 2);
		$rt = azLoginAndSendSms($loginPrefix, $login, 
		                        $info["uPassword"], $numberPrefix,
								$number, $message);
	}
	
	return $rt;
}
?>