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
<title>Options</title>
<script type="text/javascript">
var uid = 8;
</script>
</head>
<body> 
<?
if($_POST['btnSubmit']!=''){
	$disType = $_POST["rddistype"];
	$orderType = $_POST["rdordertype"];
	$chatSide = $_POST["rdchatside"];
	$msgSendKey = $_POST["rdmsgsendkey"];
	$msgShowTime = $_POST["rdmsgshowtime"];
	$DB->Query("update userconfig set distype=".$disType.",ordertype=".$orderType.",chatside=".$chatSide.",msgsendkey=".$msgSendKey.",msgshowtime=".$msgShowTime." where userid = ".$_SESSION['userid']);
	$saveResult = "You Changes Have Been Saved Successfully";
	$saveInfo = "Some Settings Will NOT Be Effective Until Next Login";
?>
<script type="text/javascript">
	parent._webIM.Config.ChatSide = parseInt("<? echo $chatSide?>");
	parent._webIM.Config.MsgSendKey = parseInt("<? echo $msgSendKey?>");
	parent._webIM.Config.MsgShowTime = parseInt("<? echo $msgShowTime?>");
	parent._webIM.CMD.renderMyFriend(<? echo $orderType?>,<? echo $disType?>,true);
</script>
<table width="400" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="85" align="center" style="font-size:16px;color:red"><? echo $saveResult?></td>
  </tr>
  <tr>
    <td height="45" align="center"><? echo $saveInfo?></td>
  </tr>
  <tr>
    <td height="170"></td>
  </tr>
  <tr>
    <td height="85" align="center"><input class="button1" type="button" name="btnLogin" id="btnLogin" value="Close" onclick="winClose(event);"/></td>
  </tr>
</table>
<?}else{
	$sql = "select * from userconfig where userid=".$_SESSION['userid'];
	$oRs=$DB->getOne($sql);
	if($oRs){
		$distype = $oRs["distype"];
		$ordertype = $oRs["ordertype"];
		$chatside = $oRs["chatside"];
		$msgsendkey = $oRs["msgsendkey"];
		$msgshowtime = $oRs["msgshowtime"];
	}else{
		exit();
	}
?>
<form action="option.php" method="post" name="form1" id="form1">
<table width="400" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="15" colspan="2"></td>
  </tr>
  <tr>
    <td height="25">Contacts</td>
    <td><input name="rdordertype" type="radio" id="rdOrderType1" value="1" <?if($ordertype=='1'){?> checked="checked" <?}?>/>
      <label for="rdOrderType1">Sort By Status</label>
      <input name="rdordertype" type="radio" id="rdOrderType2" value="2" <?if($ordertype=='2'){?> checked="checked" <?}?>/>
      <label for="rdOrderType2">Sort By Group</label></td>
  </tr>
  <tr>
    <td width="70" height="25">Contacts</td>
    <td><input name="rddistype" id="rdDisType1" type="radio" value="1" <?if($distype=='1'){?> checked="checked" <?}?>/>
      <label for="rdDisType1">List</label>
      <input name="rddistype" id="rdDisType2" type="radio" value="2" <?if($distype=='2'){?> checked="checked" <?}?>/>
      <label for="rdDisType2">Details</label></td>
  </tr>
  <tr>
    <td height="25">Participants</td>
    <td><input name="rdchatside" type="radio" id="rdChatSide1" value="1" <?if($chatside=='1'){?> checked="checked" <?}?>/>
      <label for="rdchatSide1">Show Thumb</label>
      <input name="rdchatside" type="radio" id="rdChatSide2" value="2" <?if($chatside=='1'){?> checked="checked" <?}?>/>
      <label for="rdChatSide2">Hide Thumb</label></td>
  </tr>
  <tr>
    <td height="25">Timestamp</td>
    <td><input name="rdmsgshowtime" type="radio" id="rdMsgShowTime1" value="1" <?if($msgshowtime=='1'){?> checked="checked" <?}?>/>
      <label for="rdMsgShowTime1">Log</label>
      <input name="rdmsgshowtime" type="radio" id="rdMsgShowTime2" value="2" <?if($msgshowtime=='2'){?> checked="checked" <?}?>/>
      <label for="rdMsgShowTime2">Ignore</label></td>
  </tr>
  <tr>
    <td height="25">Send Text</td>
    <td><input name="rdmsgsendkey" type="radio" id="rdMsgSendKey1" value="1" <?if($msgsendkey=='1'){?> checked="checked" <?}?>/>
      <label for="rdMsgSendKey1">By Enter</label>
      <input name="rdmsgsendkey" type="radio" id="rdMsgSendKey2" value="2" <?if($msgsendkey=='2'){?> checked="checked" <?}?>/>
      <label for="rdMsgSendKey2">By Ctrl+Enter</label></td>
  </tr>

  <tr>
    <td height="10" colspan="2" align="center"></td>
  </tr>
  <tr>
    <td height="35" colspan="2" align="center">
        <input class="button1" type="submit" name="btnSubmit" id="btnSubmit" value="OK"/>&nbsp;&nbsp; 
        <input class="button1" type="button" name="btnCancel" id="btnCancel" onclick="winClose(event);" value="Cancel" /></td>
  </tr>
</table>    
</form>
<?}
$DB->Close();
?>
</body>
</html>