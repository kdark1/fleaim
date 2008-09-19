<?
require('../data/function.php');
CheckLogin();
$sql = "select * from user where userid=".$_SESSION["userid"];
$oRs=$DB->getOne($sql);
if($oRs){
	$username = $oRs["username"];
	$usersign = $oRs["usersign"];
	$usergender = $oRs["usergender"];
}else{
	die();
}
$DB->Close();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../styles/webimpage.css" type="text/css" rel="stylesheet" media="all">
<script type="text/javascript" src="../js/webimhelper.js"></script>
<script type="text/javascript" src="../js/webimpage.js"></script>
<title>Personal Profil</title>
<script type="text/javascript">
var uid = 10;
function chkPass()
{
	var pass = $F("tbPass").trim();
	if(pass.length==0)
	{
		return true;
	}
	else if(pass.length<6)
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
	if($F("tbPass").trim().length==0)
	{
		return true;
	}
	else if($F("tbRepass").trim()!=$F("tbPass").trim())
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
	if(chkPass()&&chkRepass()&&chkNick())
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
</script>
</script>
</head>
<body> 
<form action="profilesave.php" method="post" enctype="multipart/form-data" name="form1" id="form1">
<table width="330" border="0" align="center" cellpadding="0" cellspacing="1">
  <tr>
    <td height="15" colspan="3"></td>
  </tr>
  <tr>
    <td width="60" height="25" align="right">Password</td>
    <td width="170"><input name="tbOldPass" type="password" class="input1" id="tbOldPass" maxlength="50"/>
    </td>
    <td><span id="spanOldPass" class="gray">Blank For Not Change</span></td>
  </tr>
  <tr>
    <td height="25" align="right">New Pwd</td>
    <td><input name="tbPass" type="password" class="input1" id="tbPass" maxlength="12"onblur="chkPass()"/></td>
    <td><span id= "spanPass" class="gray">6~12 Chars</span></td>
  </tr>
  <tr>
    <td height="25" align="right">New Pwd</td>
    <td><input name="tbRepass" type="password" class="input1" id="tbRepass" maxlength="12" onblur="chkRepass()"/></td>
    <td><span id="spanRepass" class="gray"></span></td>
  </tr>
  <tr>
    <td height="25" align="right">Nickname</td>
    <td><input name="tbNick" type="text" class="input1" id="tbNick" maxlength="20" onblur="chkNick()" value="<? echo $username?>"/></td>
    <td><span id="spanNick" class="gray">2~20 Chars</span></td>
  </tr>
  <tr>
    <td height="25" align="right">Signature</td>
    <td><textarea name="tbSign" class="input1" id="tbSign" style="height:55px" maxlength="200"><? echo $usersign?></textarea></td>
    <td><span class="gray"></span></td>
  </tr>
  <tr>
    <td height="25" align="right">Thumb</td>
    <td><input name="fileFace" type="file" class="input1" style="width:164px" size="14" id="fileFace" />
    </td>
    <td><span class="gray">Jpg|Gif|Png</span></td>
  </tr>
  <tr>
    <td height="25" align="right">Gender</td>
    <td><input name="rdGender" type="radio" id="rdMale" value="1" <? if($usergender=="1"){?> checked="checked" <?}?>/>
      <label for="rdMale">Male</label>
      <input name="rdGender" type="radio" id="rdFemale" value="2" <? if($usergender=="2"){?> checked="checked" <?}?>/>
      <label for="rdFemale">Female</label>
	</td>
    <td><span class="gray"></span></td>
  </tr>
  <tr>
    <td height="35" colspan="3" align="center">
        <input class="button1" type="button" name="btnSubmit" id="btnSubmit" value="OK" onclick="chkAll()"/>&nbsp;&nbsp; 
        <input class="button1" type="button" name="btnCancel" id="btnCancel" onclick="winClose(event);" value="Cancel" /></td>
  </tr>
</table>    
</form>
</body>
</html>