<?
require('../data/function.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../styles/webimpage.css" type="text/css" rel="stylesheet" media="all">
<script type="text/javascript" src="../js/webimhelper.js"></script>
<script type="text/javascript" src="../js/webimpage.js"></script>
<title>Sign Up</title>
<script type="text/javascript">
var uid = 7;
function chkEmail()
{
	var email = $F("tbEmail").trim();
	if(email=="")
	{
		setTip("Email","Required","red");
		return false;
	}
	else if(!validEmail(email))
	{
		setTip("Email","Invalid Email","red");
		return false;
	}
	else if(exsitEmail(email))
	{
		setTip("Email","Email Exists","red");	
		return false;
	}
	setTip("Email","OK","gray");
	return true;
}
function chkPass()
{
	var pass = $F("tbPass").trim();
	if(pass.length<6)
	{
		setTip("Pass","6~12 Chars","red");
		return false;
	}
	else if(pass.length>12)
	{
		setTip("Pass","6~12 Chars","red");
		return false;
	}
	setTip("Pass","OK","gray");
	return true;
}
function chkRepass()
{
	if($F("tbRepass").trim()!=$F("tbPass").trim())
	{
		setTip("Repass","Inconsistent","red");
		return false;
	}
	setTip("Repass","OK","gray");
	return true;
}
function chkNick()
{
	var nick = $F("tbNick").trim();
	if(nick.length<2)
	{
		setTip("Nick","2~20 Chars","red");
		return false;
	}
	else if(nick.length>20)
	{
		setTip("Nick","2~20 Chars","red");
		return false;
	}
	setTip("Nick","OK","gray");
	return true;
}
function chkAll()
{
	if(chkEmail()&&chkPass()&&chkRepass()&&chkNick())
	{
		showLoading();
		document.forms[0].submit();
	}
}
function setTip(s,msg,cn)
{
	var oSpan = $("span"+s);
	oSpan.className = cn;
	Elem.Value(oSpan,msg);
}
function validEmail(email)
{
    var regex = /^\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/;
    return regex.test(email);
}
function exsitEmail(email)
{
	var ajax = new Ajax();
	ajax.send("../data/service.php?t=1","email="+email,null,"POST",false);
	return parseInt(Xml.First($T(ajax.req.responseXML,"result").item(0),"num"))!=0;
}
</script>
</head>
<body> 
<form action="regresult.php" method="post" enctype="multipart/form-data" name="form1" id="form1">
<table width="330" border="0" align="center" cellpadding="0" cellspacing="1">
  <tr>
    <td height="15" colspan="3"></td>
  </tr>
  <tr>
    <td width="60" height="25" align="right">Email</td>
    <td width="170"><input name="tbEmail" type="text" class="input1" id="tbEmail" maxlength="50" onblur="chkEmail()"/>
    </td>
    <td><span id="spanEmail" class="gray"></span></td>
  </tr>
  <tr>
    <td height="25" align="right">Password</td>
    <td><input name="tbPass" type="password" class="input1" id="tbPass" maxlength="12"onblur="chkPass()"/></td>
    <td><span id= "spanPass" class="gray">6~12 Chars</span></td>
  </tr>
  <tr>
    <td height="25" align="right">Password</td>
    <td><input name="tbRepass" type="password" class="input1" id="tbRepass" maxlength="12" onblur="chkRepass()"/></td>
    <td><span id="spanRepass" class="gray">Idem</span></td>
  </tr>
  <tr>
    <td height="25" align="right">Nickname</td>
    <td><input name="tbNick" type="text" class="input1" id="tbNick" maxlength="20" onblur="chkNick()" /></td>
    <td><span id="spanNick" class="gray">2~20 Chars</span></td>
  </tr>
  <tr>
    <td height="25" align="right">Signature</td>
    <td><textarea name="tbSign" class="input1" id="tbSign" style="height:55px" maxlength="200"></textarea></td>
    <td><span class="gray">More...</span></td>
  </tr>
  <tr>
    <td height="25" align="right">Thumb</td>
    <td><input name="fileFace" type="file" class="input1" style="width:164px" size="14" id="fileFace" />
    </td>
    <td><span class="gray">Jpg|Gif|Png</span></td>
  </tr>
  <tr>
    <td height="25" align="right">Gender</td>
    <td><input name="rdGender" type="radio" id="rdMale" value="1" checked="checked" />
      <label for="rdMale">Male</label>
      <input name="rdGender" type="radio" id="rdFemale" value="2" />
      <label for="rdFemale">Female</label>
	</td>
    <td><span class="gray"></span></td>
  </tr>
  <tr>
    <td height="35" colspan="3" align="center">
        <input class="button1" type="button" name="btnSubmit" id="btnSubmit" value="OK" onclick="chkAll()"/>&nbsp;&nbsp; 
        <input class="button1" type="button" name="btnCancel" id="btnCancel" onclick="winMax(6,3);winClose(event);" value="Cancel" /></td>
  </tr>
</table>    
</form>   
</body>
</html>