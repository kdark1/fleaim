<?
require('function.php');
CheckLogin();
header("Content-type: text/xml;charset=utf-8");
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
echo "<list>\n";
$sql = "select a.*,b.userpower from userconfig a inner join user b on a.userid = b.userid where a.userid=".$_SESSION["userid"];
$oRs=$DB->getOne($sql);
if ($oRs){
	echo ("<item>\n");
	OutNode("DisType",$oRs["distype"]);
	OutNode("OrderType",$oRs["ordertype"]);
	OutNode("ChatSide",$oRs["chatside"]);
	OutNode("MsgSendKey",$oRs["msgsendkey"]);
	OutNode("MsgShowTime",$oRs["msgshowtime"]);
	OutNode("UserPower",$oRs["userpower"]);
	echo ("</item>\n");
}
echo "</list>";
$DB->Close();
?>