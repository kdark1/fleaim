<?
require('function.php');
CheckLogin();
header("charset=utf-8");
echo "var aPics =[";
$pics = "";
if(PreloadFriendFace == True){
	$sql = "select a.isblocked,a.groupid as gid,a.customname as cname,b.* from userfriend a inner join [user] b on a.friendid = b.userid where a.userid = ".$_SESSION["userid"];
	$rs=$DB->getRows($sql);
	if($rs){
		foreach ($rs as $oRs){
			$pics.="'".$oRs["userface"]."',";
		}
	}
	echo substr($pics,0,-1)."];";
}else {
	echo "];";
}
?>