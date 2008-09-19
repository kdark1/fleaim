<?
require('../data/function.php');
CheckLogin();
if(intval($_SESSION['userpower'])>1){
	exit();
}
$PageSize = 14;
if (isset($_GET['p'])){
	$p=intval($_GET['p']);
}else{
	$p=1;
}
if($_GET['op']=='del'){
	$sql = "select id,userid,userpower from user where id = ".(int)$_GET['id'];
	$oRs1=$DB->getOne($sql);
	if($oRs1){
		$userid = $oRs1["userid"];
		$userpower = $oRs1["userpower"];
		if($userpower>intval($_SESSION['userpower'])){
			$DB->Query("delete from user where id = ".$oRs1['id']);
			$DB->Query("delete from userfriend where (userid = ".$userid." or friendid = ".$userid." )");
			$DB->Query("delete from usermsg where (fromid = ".$userid." or toid = ".$userid." )");
			$DB->Query("delete from usersysmsg where (fromid = ".$userid." or toid = ".$userid." )"); 
			$DB->Query("delete from userconfig where userid = ".$userid); 
			$DB->Query("delete from usergroup where userid = ".$userid); 
			$DB->Query("update usernum set isok = 1 where num = ".$userid); 
		}
	}
}elseif ($_GET['op']=='chgpower'){
	$power=$_GET['pw'];
	$sql="select * from user where id = ".(int)$_GET['id'];
	$oRs1=$DB->getOne($sql);
	if($oRs1){
		if(0==$_SESSION['userpower']){
			$DB->Query("update user set userpower=".(int)$power." where id=".$oRs1['id']);
			if($power=='1'){
				$msg = "You Are Promoted To Administrator. Please Login Again To Access Admin Panel";
			}else{
				$msg = "You Are NOT Administrator Any Longer";
			}
			$DB->Query("insert into usermsg (fromid,toid,msgcontent,typeid,msgaddtime) values ('10000','".$oRs1["userid"]."','".$msg."','1','".toDay."')");
		}
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
<title>Advanced</title>
<script type="text/javascript">
var uid = 12;
function goSearch()
{
	showLoading();
	location.href = "?k="+$F("txtKey").toString().escapeEx();
}
</script>
</head>
<body> 
<div style="width:540px;height:15px;text-indent:6px">
	<span class="gray">User</span>&nbsp;&nbsp;<a onclick="showLoading()" href="othermanage.php">System Info</a>
</div>
<div style="float:left;width:100%;height:388px;overflow:auto">
<table align="center" width="98%" border="0" cellpadding="0" cellspacing="1" style="background-color:#bed6e0">
	<tr>
		<td style="background-color:#e0edff;height:21px;width:150px;text-align:center">Basic Info</td>
		<td style="background-color:#e0edff;width:55px;text-align:center">Thumb</td>
		<td style="background-color:#e0edff;text-align:center">Setting</td>
		<td style="background-color:#e0edff;width:150px;text-align:center">Basic Info</td>
		<td style="background-color:#e0edff;width:55px;text-align:center">Thumb</td>
		<td style="background-color:#e0edff;text-align:center">Setting</td>
	</tr>
<?
$sql = "select * from user order by id desc";
$key = $_GET["k"];
if(trim($key)!=''){
	$sql="select * from user where (userid like '%".$key."%' or username like '%".$key."%' or useremail like '%".$key."%') order by id desc";
}
$numrows=count($DB->getRows($sql));

$pages=intval($numrows/$PageSize);
if ($numrows%$PageSize){
	$pages++;
}

$offset=$PageSize*($p-1);
$limitSQL=$sql.' limit '.$offset.','.$PageSize;
$row=$DB->getRows($limitSQL);
if($row){
?>
	<tr>
	<?
	$I=1;
	foreach ($row as $oRs){
		if($I%2==1){
			$TdColor = "fff";
		}else {
			$TdColor = "e0edff";
		}
		echo OutItem($oRs,$p,$key,$TdColor);
		if($I==$numrows){
			echo '<td colspan="3"  style="background-color:#e0edff"></td>';
		}
		if($I%2==0){
			echo '</tr><tr>';
		}
		$I++;
	}
	?>
	</tr>	
	
<?
}else {
	echo "<tr><td  style=\"height:25px;background-color:#fff\" colspan=\"6\">&nbsp;No Records</td></tr>";
}
?>
</table>
</div>
<div style="float:left;padding-left:5px">
	<input type="text" style="width:120px;height:14px" id="txtKey" value="<? echo $key?>" />
	<input class="button1" type="button" onclick="goSearch();" value="Search" />&nbsp;
	<input class="button1" type="button" onclick="Elem.Value('txtKey');goSearch();" value="All" />
</div>
<?if($pages>0){?>
<div style="float:right;padding-right:5px">
	Go To Page
	<select style="font-size:11px" onchange="showLoading();location.href='?k=<? echo $key?>&p='+this.value" >
	<?
		for($Q=1;$Q<=$pages;$Q++){
				echo "<option value=".$Q;
				if($p==$Q) echo " selected=selected";
				echo ">".$Q."</option>";
		}
	?>
	</select>
	&nbsp;
	<? echo $p?>/<? echo $pages?>In Total
	<?if($p!=1){?>
		<a onclick="showLoading();" href="?k=<? echo $key?>&p=1">First</a>
		<a onclick="showLoading();" href="?k=<? echo $key?>&p=<?echo intval($p-1)?>">Previous</a>
	<?}else{?>
		<span class="gray">First</span>
		<span class="gray">Previous</span>
	<?}?>
	<?if($p!=$pages){?>	
		<a onclick="showLoading();" href="?k=<? echo $key?>&p=<?echo intval($p+1)?>">Next</a>
		<a onclick="showLoading();" href="?k=<? echo $key?>&p=<? echo $pages?>">Last</a>
	<?}else{?>
		<span class="gray">Next</span>
		<span class="gray">Last</span>
	<?}?>
</div>
<?}?>
</body>
</html>
<?
function OutItem($oRs,$p,$key,$TdColor)
{
	$str='<td style="background-color:#'.$TdColor.';height:51px;text-align:center">'.CutStr($oRs['username'],12).'('.$oRs["userid"].')[';
	if($oRs['usergender']==1){
		$str.='Male';
	}else{
		$str.='Female';
	}
	$str.=']<br /><a href="mailto:'.$oRs["useremail"].'">'.CutStr($oRs['useremail'],22).'</a></td>';
	
	$str.='<td style="background-color:#'.$TdColor.';text-align:center"><a target="_blank" href="../userface/'.$oRs["userface"].'"><img title="'.$oRs["username"].'" src="../userface/'.$oRs["userface"].'" style="width:50px;height:50px;border:0"/></a></td>';
	$str.='<td style="background-color:#'.$TdColor.';text-align:center"><a onclick="if(!confirm(\'Are You Sure To Remove “'.$oRs["username"].'” Permanently?\'))return false;else showLoading();" href="?p='.$p.'&op=del&id='.$oRs["id"].'&k='.$key.'">Remove</a><br />';
	if(0==$_SESSION['userpower']){
		if($oRs['userpower']==1){
			$str.='<a  onclick="shoLoading();" href="?p='.$p.'>&op=chgpower&pw=2&id='.$oRs["id"].'&k='.$key.'">Relegate To Normal User</a>';
		}elseif ($oRs['userpower']==2){
			$str.='<a onclick="showLoading();" href="?p='.$p.'&op=chgpower&pw=1&id='.$oRs["id"].'&k='.$key.'">Promote To Administrator</a>';
		}else {
			$str.='Supper Administrator';
		}
	}
	$str.='</td>';
	return $str;
}
?>