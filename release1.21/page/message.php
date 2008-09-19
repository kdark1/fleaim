<?
require('../data/function.php');
CheckLogin();
$id=(int)$_GET['id'];
if(!$id){
	$id=-1;
}
$PageSize = 17;
if (isset($_GET['p'])){
	$p=intval($_GET['p']);
}else{
	$p=1;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../styles/webimpage.css" type="text/css" rel="stylesheet" media="all">
<script type="text/javascript" src="../js/webimhelper.js"></script>
<script type="text/javascript" src="../js/webimpage.js"></script>
<title>History</title>
<script type="text/javascript">
var uid = 9;
</script>
</head>
<body> 
<div style="width:548px;height:23px">
	<div style="text-indent:5px;float:left">
		Range:<select onchange="showLoading();location.href='?id='+this.value">
			<option value="-1">All</option>
			<?
				$sql = "select a.friendid,b.username from userfriend a inner join user b on a.friendid = b.userid where a.userid = ".$_SESSION['userid'];
				$rs=$DB->getRows($sql);
				if($rs){
					foreach ($rs as $oRs){
						echo "<option value=".$oRs["friendid"];
						if($oRs["friendid"]==$id){ 
							echo " selected=selected" ;
						}
						echo ">".GetCustomNameById($_SESSION['userid'],$oRs["friendid"])."</option>";
					}
				}
			?>
		</select>
	</div>
<?
	$sql = "select * from usermsg where (fromid = ".$_SESSION["userid"]." and toid = ".$id.") or (toid = ".$_SESSION["userid"]." and fromid = ".$id.") order by id";
	if($id==-1){
		$sql="select * from usermsg where fromid = ".$_SESSION["userid"]." or toid = ".$_SESSION["userid"]." order by id";
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
	<div style="float:right;padding-right:5px">
		<a href="messagetxt.php?id=<? echo $id?>" target="_blank">Download</a>&nbsp;
		Go To Page
		<select onchange="showLoading();location.href='?id=<? echo $id?>&p='+this.value" >
		<?
			for($Q=1;$Q<=$pages;$Q++){
				echo "<option value=".$Q;
				if($p==$Q) echo " selected=selected";
				echo ">".$Q."</option>";
			}
		?>
		</select>
		&nbsp;
		<? echo $p?>/<? echo $pages?> In Totall
		<?if($p!=1){?>
			<a onclick="showLoading();" href="?p=1&id=<? echo $id?>">First</a>
			<a onclick="showLoading();" href="?p=<?echo intval($p-1)?>&id=<? echo $id?>">Previous</a>
		<?}else{?>
			<span class="gray">First</span>
			<span class="gray">Previous</span>
		<?}?>
		<?if($p!=$pages){?>	
			<a onclick="showLoading();" href="?p=<?echo intval($p+1)?>&id=<? echo $id?>">Next</a>
			<a onclick="showLoading();" href="?p=<? echo $pages?>&id=<? echo $id?>">Last</a>
		<?}else {?>
			<span class="gray">Next</span>
			<span class="gray">Last</span>
		<?}?>
	</div>
</div>
<div style="width:548px;height:400px;overflow:auto">
<table align="center" width="98%" border="0" cellpadding="0" cellspacing="1" style="background-color:#bed6e0">
	<tr>
		<td style="background-color:#e0edff;height:21px;width:90px;text-align:center">From</td>
		<td style="background-color:#e0edff;width:90px;text-align:center">To</td>
		<td style="background-color:#e0edff;width:120px;text-align:center">Time</td>
		<td style="background-color:#e0edff;text-align:center">Body</td>
	</tr>
<?
	$I=1;
	foreach ($row as $rs){
		if($I%2==0){
			$TdColor = "fff";
		}else {
			$TdColor = "e0edff";
		}
	
	
		if(intval($rs['typeid'])==2){
			if(trim($rs['msgcontent'])=='FLASH'){
				$msgContent = "<span class='gray'>Flash</span>";
			}
		}else{
			//$msgContent = htmlentities(str_replace('{br}','',$rs['msgcontent']));
			$msgContent = $rs['msgcontent'];
		}
?>
	<tr>
		<td style="background-color:#<? echo $TdColor?>;height:21px;text-align:center"><? echo GetCustomNameById($_SESSION['userid'],$rs['fromid'])?></td>
		<td style="background-color:#<? echo $TdColor?>;text-align:center"><? echo GetCustomNameById($_SESSION['userid'],$rs["toid"])?></td>
		<td style="background-color:#<? echo $TdColor?>;text-align:center"><? echo $rs['msgaddtime']?></td>
		<td style="background-color:#<? echo $TdColor?>;text-indent:5px"><? echo $msgContent?></td>
	</tr>
<?
	$I++;
	}
	?>
</table>
</div>
<?}else{
	echo "</div><div style=padding:20px>No Records</div>";
}
$DB->Close();
?>
</body>
</html>