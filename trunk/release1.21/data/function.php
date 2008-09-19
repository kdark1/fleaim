<?
session_start();
require('db.php');
require('inc.php');
header("Content-type: text/html;charset=utf-8");
define('PreloadFriendFace',false);
define('toDay',date('Y-m-d H:i:s'));

//*************************Change the following line to yours*****************//
$DB = new db("localhost","root","","fleaim");
//*************************Change the following line to yours*****************//

function CheckLogin(){
	if($_SESSION['userid']==''||!isset($_SESSION['userid'])){
		die();
	}
}
/**
 *
 * @param int $id
 */
function UpdateUserOnlineTime($id)
{
	global $DB;
	$DB->Query("update user set lastonlinetime='".toDay."' where userid = ".$id);
}
/**
 *
 * @param int $id
 * @param string $username
 * @param string $usersign
 * @param string $userface
 * @param int $userstatus
 */
function UpdateUserProfile($id,$username,$usersign,$userface,$userstatus)
{
	global $DB;
	$sql = "update user set userid = ".$id;
	if ($userstatus!="") $sql.= " ,userstatus='".$userstatus."'";
	if ($username!="")   $sql.= " ,username='".$username."' ";
	if ($usersign!="")   $sql.= " ,usersign='".$usersign."' ";
	if ($userface!="")   $sql.= " ,userface='".$userface."' ";
	$sql.= " where userid = ".$id;
	$DB->Query($sql);
	$sql = "select a.*,b.userid as uid,b.userstatus from userfriend a inner join user b on a.friendid = b.userid where a.userid = ".$id; 
	$row=$DB->getRows($sql);
	if($row){
		foreach ($row as $rs){
			if(intval($rs["userstatus"])!=7){ 
				if(intval($DB->getOne("select count(*) from usersysmsg where (fromid=".$id." and toid=".$rs["uid"]." and typeid=5)",true))<1){  
					$DB->Query("insert into usersysmsg (fromid,toid,msgcontent,typeid,msgaddtime) values ('".$id."','".$rs["uid"]."','','5','".toDay."')");
				}
			}
		}
	}
}

/**
 *
 */
function CheckUserStatus(){
	global $DB;
	$sql = "select * from user where userstatus !=7"; 
	$row=$DB->getRows($sql);
	if($row){
		foreach ($row as $rs){
			if(DateLast($rs['lastonlinetime'],toDay,'m')>1)
			{
				UpdateUserProfile($rs["userid"],"","","",7);
			}
		}
	}
}

/**
 *
 * @param int $fromid
 * @param int $toid
 * @param int $t
 */
function ChangeFriendList($fromid,$toid,$t){ 
	global $DB;
	if(round($DB->getOne("select userstatus from user where userid=".$toid,true))<7){
		$DB->Query("insert into usersysmsg (fromid,toid,msgcontent,typeid,msgaddtime) values ('".$fromid."','".$toid."','','".$t."','".toDay."')");
	}
}

/**
 *
 * @param int $fromid
 * @param int $toid
 */
function AddFriend($fromid,$toid){
	global $DB;
	if(round($DB->getOne("select count(*) from userfriend where userid =".$fromid." and friendid =".$toid,true))<1){
		$DB->Query("insert into userfriend (userid,friendid) values ('".$fromid."','".$toid."')");
		$DB->Query("insert into userfriend (userid,friendid) values ('".$toid."','".$fromid."')");
		ChangeFriendList($fromid,$toid,3); 
	}
}
/**
 *
 * @param int $fromid
 * @param int $toid
 */
function  DelFriend($fromid,$toid){
	global $DB;
	IF(round($DB->getOne("select count(*) from userfriend where userid =".$fromid." and friendid =".$toid,true))>0){
		$DB->Query("delete from userfriend where userid =".$fromid." and friendid = ".$toid);
		$DB->Query("delete from userfriend where userid =".$toid." and friendid = ".$fromid);
		ChangeFriendList($fromid,$toid,4); 
	}
}
/**
 *
 * @param string $name
 * @param string $value
 */
function OutNode($name,$value){
	echo "<$name>";
	if(trim($value)!=''){
		echo trim(htmlspecialchars($value));
	}
	echo "</$name>";
}
/**
 *
 * @param int $uid
 * @param int $code
 * @return int
 */
function CheckSysCode($uid,$code){
	global $DB;
	$sql = "select * from user where userid = ".$uid;
	$rs =$DB->getOne($sql);
	if($rs){
		if($code!=$rs["syscode"]){
			$CheckSysCode = 0;
		}else{
			$CheckSysCode = 1;
		}
	}else{
		$CheckSysCode = 0;
	}
	return $CheckSysCode;
}

/**
 *
 * @param string $email
 * @return string
 */
function GetUserIdByEmail($email){
	global $DB;
	return $DB->getOne("select userid from user where useremail = '".$email."'",true);
}
/**
 *
 * @param int $fromid
 * @param int $toid
 * @return string
 */
function GetCustomNameById($fromid,$toid){
	global $DB;
	$username = $DB->getOne('select username from user where userid = '.$toid,true);
	$customname = "";
	if(round($DB->getOne("select count(*) from userfriend where friendid = ".$toid." and userid = ".$fromid,true))>0){
		$customname = $DB->getOne("select customname from userfriend where friendid = ".$toid." and userid = ".$fromid,true);
	}
	if(trim($customname)!=''){
		$GetCustomNameById = $customname;
	}else{
		$GetCustomNameById = $username;
	}
	return $GetCustomNameById;
}
?>