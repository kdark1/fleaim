<?
require('function.php');
CheckLogin();
header("Content-type: text/xml;charset=utf-8");
$id = (int)$_GET["id"];
if(!$id) exit();
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
echo "<list>\n";
$sql = "select a.isblocked,a.groupid as gid,a.customname as cname,b.* from userfriend a inner join user b on a.friendid = b.userid where b.userid =".$id." and a.userid = ".$_SESSION['userid'];
$oRs=$DB->getOne($sql);
if ($oRs){
	echo ("<item>\n");
	OutNode("f",$oRs["userface"]);
	OutNode("id",$oRs["userid"]);
	OutNode("n",$oRs["username"]);
	OutNode("e",$oRs["useremail"]);
	OutNode("sn",$oRs["usersign"]);
	OutNode("s",$oRs["userstatus"]);
	OutNode("g",$oRs["gid"]);
	OutNode("b",$oRs["isblocked"]);
	OutNode("cn",$oRs["cname"]);
	OutNode("u",$oRs["usergender"]);
	echo ("</item>\n");
}
echo "</list>";
$DB->Close();
?>