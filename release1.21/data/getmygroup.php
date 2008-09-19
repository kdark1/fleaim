<?
require('function.php');
CheckLogin();
header("Content-type: text/xml;charset=utf-8");
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
echo "<list>\n";
$sql = "select * from usergroup where userid = -1 or userid =  ".$_SESSION['userid'];
$row=$DB->getRows($sql);
if ($row){
	foreach ($row as $oRs){
		echo ("<item>\n");
		OutNode("Name",$oRs["groupname"]);
		OutNode("ID",$oRs["id"]);
		echo ("</item>\n");
	}
}
echo "</list>";
$DB->Close();
?>