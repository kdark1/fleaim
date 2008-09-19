<?
require('function.php');
CheckLogin();
header("Content-type: text/xml;charset=utf-8");
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
echo "<list>\n";
$sql = "select * from user where userid = ".$_SESSION['userid'];
$oRs=$DB->getOne($sql);
if ($oRs){
	echo ("<item>\n");
	OutNode("f",$oRs["userface"]);
	OutNode("id",$_SESSION["userid"]);
	OutNode("n",$_SESSION["username"]);
	OutNode("e",$_SESSION["useremail"]);
	OutNode("sn",$oRs["usersign"]);
	OutNode("s",$oRs["userstatus"]);
	OutNode("g","");
	OutNode("b","");
	OutNode("cn",$_SESSION["username"]);
	OutNode("u",$oRs["usergender"]);
	echo ("</item>\n");
}
echo "</list>";
$DB->Close();
?>