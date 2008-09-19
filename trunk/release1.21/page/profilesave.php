<?
require('../data/function.php');
$strOldPass  = GetSafeStr($_POST["tbOldPass"]);
$strPass  = GetSafeStr($_POST["tbPass"]);
$strNick  = GetSafeStr($_POST["tbNick"]);
$strSign  = GetSafeStr($_POST["tbSign"]);
$intGender  = $_POST["rdGender"];
$file=$_FILES['fileFace'];

$flag = false;


if($strNick==''){
	$modifyResult = "Sorry, An Error Occurs While Saving Data";
	$modifyInfo = "You Personal Profile Is NOT Integrated";
}else{
	if($file['name']==''){
		$strFace = "default.gif";
	}else {

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
	$sql = "select * from user where userid = ".$_SESSION["userid"];
	$oRs=$DB->getOne($sql);
	if($oRs){
		$upSql="update user set username='".$strNick."',usersign='".$strSign."',usergender='".$intGender."'";
		if($strFace!=''){
			$upSql.=",userface='".$strFace."'";
		}

		if($strPass!=''){
			if(md5($strOldPass)==$oRs["userpass"]){
				$upSql.=",userpass='".md5($strPass)."'";
				$modifyInfo = "Password Changed. Please Login With The New One Next Time";
			}else{
				$modifyInfo = "Incorrect Password";
			}
		}

		$upSql.=" where id=".$oRs['id'];
		$DB->Query($upSql);
		$modifyResult = "Profile Saved Successfully";
		UpdateUserProfile($_SESSION['userid'],$strNick,$strSign,$strFace,"");
		$flag = true;
	}else {
		$modifyResult = "Sorry, An Error Occurs While Saving Data";
		$modifyInfo = "Internal Error";
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../styles/webimpage.css" type="text/css" rel="stylesheet" media="all">
<script type="text/javascript" src="../js/webimhelper.js"></script>
<script type="text/javascript" src="../js/webimpage.js"></script>
<title>Profile</title>
<script type="text/javascript">
	var uid = 10;
</script>
</head>
<body> 
<table width="330" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="85"align="center" style="font-size:16px;color:red"><? echo $modifyResult?></td>
  </tr>
  <tr>
    <td height="45"align="center"><? echo $modifyInfo?></td>
  </tr>
  <tr>
    <td height="85" align="center"><input class="button1" type="button" name="btnLogin" id="btnLogin" value="Close" onclick="winClose(event);"/></td>
  </tr>
</table>
<?if($flag==true){?>
<script type="text/javascript">
	parent._webIM.Profile.UserName = "<? echo $strNick?>";
	parent._webIM.Profile.UserSign = "<? echo $strSign?>";
	parent._webIM.Profile.UserFace = "<? echo $strFace?>";
	parent._webIM.CMD.renderMyUserInfo();
</script>
<?}?>
</body>
</html>