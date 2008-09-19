<?
require('../data/function.php');
$strEmail = GetSafeStr($_POST["tbEmail"]);
$strPass  = GetSafeStr($_POST["tbPass"]);
$strNick  = GetSafeStr($_POST["tbNick"]);
$strSign  = GetSafeStr($_POST["tbSign"]);
$intGender  = $_POST["rdGender"];
$file=$_FILES['fileFace'];

if($strEmail=="" || $strPass=="" || $strNick==""){
	$regResult = "Sorry, Registration Failed";
	$regInfo = "You Personal Profile Is NOT Integrated";
}else {
	if($file['name']==''){
		$strFace = "default.gif";
	}else{

		$picExt = $file['type'];
		if($picExt!='image/gif'&&$picExt!='image/pjpeg'&&$picExt!='image/jpeg'&&$picExt!='image/png'&&$picExt!='image/x-png'){
			$strFace = "default.gif";
		}else{
			$ext = substr($file['name'],strrpos($file['name'], '.'));
			$str = '';
			for($i = 0; $i < 9; $i++)
			{
				$str .= mt_rand(0, 9);
			}
			$strFace=time().$str.'.'.$ext;
			move_uploaded_file($file['tmp_name'],'../userface/'.$strFace);
		}
	}
	$sql = "select * from usernum where isok = 1 order by id limit 0,1";
	$oRs=$DB->getOne($sql);
	if($oRs){
		$intNum = $oRs["num"];

		$DB->Query("insert into user (username,userpass,userid,useremail,userface,usersign,usergender,lastonlinetime) values ('".$strNick."','".md5($strPass)."','".$intNum."','".$strEmail."','".$strFace."','".$strSign."','".$intGender."','".toDay."')");

		$DB->Query("insert into userconfig (userid) values ('".$intNum."')");

		$DB->Query("insert into usermsg (fromid,toid,msgcontent,typeid,msgaddtime) values ('10000','".$intNum."','Welcome To FleaIM. :)','1','".toDay."')");

		AddFriend($intNum,10000);

		$DB->Query('update usernum set isok=2 where id='.$oRs['id']);
		$regResult = "Registration Success";
		$regInfo = "Note That Password Retrieving Not Supported By Far. Please Keep Your Password In Mind";
	}else{
		$regResult = "Sorry, Registration Failed";
		$regInfo = "Registration NOT Available For This Time";
	}
	$DB->Close();
}
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
</script>
</head>
<body> 
<table width="330" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="85"align="center" style="font-size:16px;color:red"><? echo $regResult;?></td>
  </tr>
  <tr>
    <td height="45"align="center"><? echo $regInfo;?></td>
  </tr>
 <tr>
    <td height="85" align="center"><input class="button1" type="button" name="btnLogin" id="btnLogin" value="Click To Login" onclick="winMax(6,3);winClose(event);"/></td>
  </tr>
</table>
</body>
</html>