<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
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

<body style="margin:0px;">
<form action="userLogin.php" name="formRegistrUser" method="post">
  <table align="center" cellpadding="2" cellspacing="3" style="width:500px; background-color:#CFC;">
    <tr>
      <th colspan="2" id="caption">AvtoTəbrik sisteminə giriş</th>
    </tr>
    <tr title="Pulsuz mesaj göndərmək üçün istifadə etdiyiniz istifadəçi adı">
      <td class="label">İstifadəçi adı</td>
      <td><input type="text" name="username" /></td>
    </tr>
    <tr title="Pulsuz mesaj göndərmək üçün istifadə etdiyiniz şifrə">
      <td class="label">İstifadəçi şifrəsi</td>
      <td><input type="password" name="password" /></td>
    </tr>
    <tr>
      <td colspan="3" align="center" style="border-top:1px dotted #F00"><input type="submit" value="Daxil ol" title="Məlumatları göndər" />
        &nbsp;&nbsp;
        <input type="reset" value="Yenilə" title="Məlumatları yenilə" /></td>
    </tr>
  </table>
</form>
</body>
</html>