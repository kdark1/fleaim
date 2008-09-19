<?
require('function.php');
CheckLogin();
header("Content-type: text/xml;charset=utf-8");
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
echo "<list>\n";
if(CheckSysCode($_SESSION['userid'],$_GET['code'])==0){
	echo "<item>";
	OutNode("From",10000);
	OutNode("To",$_SESSION['userid']);
	OutNode("Content","You have been signed out from another location.");
	OutNode("Type",8);
	OutNode("IsConfirm",0);
	OutNode("AddTime","");
	echo "</item>";
}else{
	CheckUserStatus();
	UpdateUserOnlineTime($_SESSION['userid']);
	//check UserMsg
	$where="isread = 2 and toid = ".$_SESSION['userid']." and fromid not in (select friendid from userfriend where isblocked=1 and userid = ".$_SESSION['userid'].")";
	$sql="select * from usermsg where ".$where;
	$rs=$DB->getRows($sql);
	if($rs){
		foreach ($rs as $oRs){
			echo "<item>";
			OutNode("From",$oRs["fromid"]);
			OutNode("To",$_SESSION["userid"]);
			OutNode("Content",$oRs["msgcontent"]);
			OutNode("Type",$oRs["typeid"]);
			OutNode("IsConfirm",$oRs["isconfirm"]);
			OutNode("AddTime",ParseDateTime($oRs["msgaddtime"]));
			echo "</item>";
			$DB->Query('update usermsg set isread=1 where id='.$oRs['id']);
		}
	}
	unset($sql,$rs,$where,$oRs);
	//check friend add info
	$DB->Query('delete from usersysmsg where isread = 1');
	$where="isread = 2 and toid = ".$_SESSION['userid'];
	$sql="select * from usersysmsg where ".$where;
	$rs=$DB->getRows($sql);
	if($rs){
		foreach ($rs as $oRs){
			echo "<item>\n";
			OutNode("From",$oRs["fromid"]);
			OutNode("To",$_SESSION["userid"]);
			OutNode("Content",$oRs["msgcontent"]);
			OutNode("Type",$oRs["typeid"]);
			OutNode("IsConfirm",$oRs["isconfirm"]);
			OutNode("AddTime",$oRs["msgaddtime"]);
			echo "</item>\n";
			$DB->Query('update usersysmsg set isread=1 where id='.$oRs['id']);
			if((int)$oRs['typeid']==7){
				break;
			}
		}
	}
}
echo "</list>";
$DB->Close();
?>