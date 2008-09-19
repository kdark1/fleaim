<?
require('function.php');
header("Content-type: text/xml;charset=utf-8");
$t=$_GET['t'];
$ranNum = rand(0,90000)+10000;
switch ((int)$t)
{
	case 0: 
		$email=GetSafeStr($_POST['email']);
		$pass=GetSafeStr($_POST['pass']);
		$us=$_POST['us'];
		$num=0;
		if($email==''||$pass==''){
			$num=4;
		}else{
			$where="useremail='".$email."' and userpass='".md5($pass)."'";
			$oRs=$DB->getOne("select * from user where ".$where);
			if($oRs){

				if(session_is_registered("userid"))session_unregister("userid");
				session_register("userid");
				$_SESSION['userid']=$oRs['userid'];
				if(session_is_registered("username"))session_unregister("username");
				session_register("username");
				$_SESSION['username']=$oRs['username'];
				if(session_is_registered("useremail"))session_unregister("useremail");
				session_register("useremail");
				$_SESSION['useremail']=$oRs['useremail'];
				if(session_is_registered("userpower"))session_unregister("userpower");
				session_register("userpower");
				$_SESSION['userpower']=$oRs['userpower'];
				if(session_is_registered("syscode"))session_unregister("syscode");
				session_register("syscode");
				$_SESSION['syscode']=$ranNum;
				$num=1;
				$DB->Query("update user set syscode='".$ranNum."' where ".$where);
				UpdateUserOnlineTime($_SESSION['userid']);
				UpdateUserProfile($oRs['userid'],'','','',$us);
			}else {
				$num=2;
			}
		}		
		echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
		echo "<result>\n";
		echo "<num>$num</num>\n";
		echo "<code>".(int)$ranNum."</code>\n";
		echo "</result>";
		break;
	case 1: 
		$num = $DB->getOne("select count(*) from user where useremail = '".GetSafeStr($_POST["email"])."'",true);
		echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
		echo "<result>\n";
		echo "<num>$num</num>\n";
		echo "</result>";
		break;
	case 2: 
		UpdateUserOnlineTime($_SESSION['userid']);
		UpdateUserProfile($_SESSION['userid'],'','','',7);
		$_SESSION['userid']='';
		$_SESSION['username']='';
		$_SESSION['useremail']='';
		$_SESSION['syscode']='';
		break;
	case 3: 
		$fromid = GetSafeStr($_POST["from"]);
		$toid = GetSafeStr($_POST["to"]);
		$msgcontent = GetSafeStr($_POST["content"]);
		$typeid = GetSafeStr($_POST["type"]);
		$DB->Query("insert into usermsg (fromid,toid,msgcontent,typeid,msgaddtime) values ('".$fromid."','".$toid."','".$msgcontent."','".$typeid."','".toDay."')");
		break;
	case 4: 
		$username = GetSafeStr($_POST["username"]);
		$usersign = GetSafeStr($_POST["usersign"]);
		$userface = GetSafeStr($_POST["userface"]);
		$userstatus = GetSafeStr($_POST["userstatus"]);
		UpdateUserProfile($_SESSION['userid'],$username,$usersign,$userface,$userstatus);
		break;
	case 5: 
		$toid = GetSafeStr($_POST["to"]);
		AddFriend($_SESSION['userid'],$toid) ;
		break;
	case 6: 
		$toid = GetSafeStr($_POST["to"]);
		DelFriend($_SESSION['userid'],$toid);
		break;
	case 7: 
		$toid = GetSafeStr($_POST["to"]);
		$isblock = GetSafeStr($_POST["s"]);
		$DB->Query("update userfriend set isblocked = ".$isblock." where userid = ".$_SESSION['userid']." and friendid = ".$toid);
		break;
	case 8: 
		$toid = GetSafeStr($_POST["to"]);
		$customname = GetSafeStr($_POST["n"]);
		$DB->Query("update userfriend set customname = '".$customname."' where userid = ".$_SESSION['userid']." and friendid = ".$toid);
		break;
	case 9: 
		$groupname = GetSafeStr($_POST["n"]);
		if(round($DB->getOne("select count(*) from usergroup where groupname='".$groupname."' and (userid=-1 or userid=".$_SESSION['userid'].")",true))<1){ 
			$DB->getOne("insert into usergroup (userid,groupname) values (".$_SESSION['userid'].",'".$groupname."')");
		}
		break;
	case 10: 
		$gid = GetSafeStr($_POST["id"]);
		$DB->Query("update userfriend set groupid=1 where userid = ".$_SESSION['userid']." and groupid=".$gid);
		$DB->Query("delete from usergroup where id=".$gid." and userid=".$_SESSION['userid']);
		break;
	case 11: 
		$gid = GetSafeStr($_POST["id"]);
		$groupname = GetSafeStr($_POST["n"]);
		$DB->Query("update usergroup set groupname='".$groupname."' where id=".$gid." and userid=".$_SESSION['userid']);
		break;
	case 12: 
		$id = GetSafeStr($_POST["id"]);
		$gid = GetSafeStr($_POST["gid"]);
		$DB->Query("update userfriend set groupid=".$gid." where userid = ".$_SESSION['userid']." and friendid=".$id);
		break;
}
$DB->Close();
?>