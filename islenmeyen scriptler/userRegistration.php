<?php
ob_start();
if (ob_get_length()) ob_clean();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>AvtoTəbrik sisteminə istifadəçi qeydiyyatı</title>
<style>
.label {
	font-family:Verdana, Geneva, sans-serif;
	text-align:right;
}
#caption {
	border-bottom:1px dotted #F00;
	font-size:18px;
	color:#F00;
}
</style>
</head>

<body>
<?php
session_start();
$success = false;
$err = $_GET["err"];
$errArr = array(1=>"Operator seçin",
                2=>"Telefon nömrəsini düzgün daxil edin",
                3=>"İstifadəçi adı daxil edilməyib",
				4=>"İstifadəçi şifrəsi daxil edilməyib");
if(isset($err))
{
	print "<div style=\"margin:auto; width:500px; color:#F00\"><ul>\n";
	$len = strlen($err);
	for($i=0; $i<$len; $i++)
	{
		print "<li>".$errArr[$err[$i]]."</li>\n";
	}
	print "</ul></div>\n";
}
if(isset($_GET["queryErr"]))
{
	print "<div style=\"margin:auto; width:500px; color:#F00\"><ul>\n";
	print "<li>Məlumatınız bazaya əlavə olunmadı, bir az sonra yenidən yoxlayın</li>";
	print "</ul></div>\n";
}
if(isset($_GET["success"]))
{
	if(!isset($_GET["loginErr"]))
	{
		print "<h3 align=\"center\">Qeydiyyat uğurla tamamlandı</h3>";
     	print "<div align=\"center\">Buradan profilinizə daxil olaraq, <br />".
	     	  "təbrik etmək istədiyiniz insanların doğum günlərini daxil edə bilərsiniz</div>\n";
	}
	else
	{
		print "<div align=\"center\">";
		if($_GET["loginErr"]==1)
		{
			print "<h4>Daxil etdiyiniz istifadəçi adı və şifrə kombinasiyasına uyğun profil tapılmadı</h4>";
		}
		elseif($_GET["loginErr"]==1)
		{
			//sorgu sehvi
			print "<h4>Məlumatınız bazaya əlavə olunmadı, bir az sonra yenidən yoxlayın</h4>";
		}
		print "</div>";
	}
	require_once "loginForm.php";
	$success = true;
}
if(!$success)
{
?>
<form action="registrUser.php" name="formRegistrUser" method="post">
  <table align="center" cellpadding="2" cellspacing="3" style="width:500px; background-color:#CFC;">
    <tr>
      <th colspan="2" id="caption">AvtoTəbrik sisteminə istifadəçi qeydiyyatı</th>
    </tr>
    <tr>
      <td class="label">Operator</td>
      <td><select name="operator">
          <option value="0">Operator seçin</option>
          <option value="Bakcell" <?php	if($_SESSION["operator"]=="Bakcell") print "selected=\"selected\"" ?> >Bakcell</option>
          <option value="Azercell" <?php if($_SESSION["operator"]=="Azercell") print "selected=\"selected\""?> >Azercell</option>
        </select></td>
    </tr>
    <tr title="Mobil telefon nömrənizi buraya daxil edin">
      <td class="label">Telefon nömrəsi</td>
      <td><input type="text" name="telNumber" /></td>
    </tr>
    <tr title="Pulsuz mesaj göndərmək üçün istifadə etdiyiniz istifadəçi adı">
      <td class="label">İstifadəçi adı</td>
      <td><input type="text" name="username" /></td>
    </tr>
    <tr title="Pulsuz mesaj göndərmək üçün istifadə etdiyiniz şifrə">
      <td class="label">İstifadəçi şifrəsi</td>
      <td><input type="password" name="password" /></td>
    </tr>
    <tr title="İmza hər bir təbrik mesajının sonuna ...<imzanız> kimi əlavə ediləcək, bunu istəmirsizə xananı boş buraxın">
      <td class="label">İstifadəçi imzası</td>
      <td><input type="text" name="sign" /></td>
    </tr>
    <tr>
      <td colspan="3" align="center" style="border-top:1px dotted #F00"><input type="submit" value="Təstiqlə" title="Məlumatları göndər" />
        &nbsp;&nbsp;
        <input type="reset" value="Yenilə" title="Məlumatları yenilə" /></td>
    </tr>
  </table>
</form>
<?php
}
?>
</body>
</html>