<?
require('../data/function.php');
CheckLogin();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../styles/webimpage.css" type="text/css" rel="stylesheet" media="all">
<script type="text/javascript" src="../js/webimhelper.js"></script>
<script type="text/javascript" src="../js/webimpage.js"></script>
<title>Add a Contact</title>
<script type="text/javascript">
var uid = 1;
function chkEmail()
{
	var email = $F("tbEmail").trim();
	if(email=="")
	{
		setTip("Email","Email","red");
		return false;
	}
	else if(!validEmail(email))
	{
		setTip("Email","Invalid Email","red");
		return false;
	}
	else if(!exsitEmail(email))
	{
		setTip("Email","Not Found","red");	
		return false;
	}
	setTip("Email","OK","gray");
	return true;
}
function chkAll()
{
	if(chkEmail())
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
<?
if($_POST['tbEmail']!=''){
	$email=GetSafeStr($_POST['tbEmail']);
	if($email==$_SESSION['useremail']){
		$strResult = "<span class='red'>You Cound NOT Add Yourself As a Contact</span>";
	}else{
		$toid = GetUserIdByEmail($email);
		if($DB->getOne("select count(*) from userfriend where userid=".$_SESSION["userid"]." and friendid=".$toid,true)>0){
			$strResult = "<span class='red'>This Contact Has Been In Your List</span>";
		}else{
			$DB->Query("insert into usersysmsg (fromid,toid,msgcontent,typeid,msgaddtime) values ('".$_SESSION["userid"]."','".$toid."','".$_SESSION["useremail"]."','7','".toDay."')");
			$strResult = "Request Rent Successfully";
		}
	}
?>
<table width="200" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="70" align="center"><? echo $strResult?></td>
  </tr>
  <tr>
    <td height="35" align="center">
        <input class="button1" type="button" name="btnCancel" id="btnCancel" onclick="winClose(event);" value="Close" /></td>
  </tr>
</table>
<? }else{ ?>
<form action="addfriend.php" method="post" name="form1" id="form1"> 
<table width="200" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="10"></td>
  </tr>
  <tr>
    <td height="20">Email Address</td>
  </tr>
  <tr>
    <td height="25">
      <input name="tbEmail" type="text" class="input1" id="tbEmail" maxlength="50" onblur="chkEmail()"/>
    </td>
  </tr>
  <tr>
    <td height="20"><span id="spanEmail">Sample - user@domain.com</span></td>
  </tr>
  <tr>
    <td height="35" align="center">
        <input class="button1" type="button" name="btnSubmit" id="btnSubmit" value="OK" onclick="chkAll()"/>&nbsp;&nbsp; 
        <input class="button1" type="button" name="btnCancel" id="btnCancel" onclick="winClose(event);" value="Cancel" /></td>
  </tr>
</table>    
</form>   
<?}?>
</body>
</html>