<?
require('../data/function.php');
header("Content-type:text/plain;charset=utf-8");
header("Content-Disposition:attachment;filename=Message.txt");

CheckLogin();
$br=chr(13).chr(10);
$id=(int)$_GET['id'];
if($id==0) $id=-1;
if($id==-1){
	echo '//To:All'.$br;
}else{
	echo '//To:'.GetCustomNameById($_SESSION['userid'],$id),$br;
}
echo "//Time:".toDay.$br;
echo "//Created By FleaIM".$br.$br;
$sql = "select * from usermsg where (fromid = ".$_SESSION['userid']." and toid = ".$id.") or (toid = ".$_SESSION['userid']." and fromid = ".$id.") order by id ";
if($id==-1){
	$sql = "select * from usermsg where fromid = ".$_SESSION['userid']." or toid = ".$_SESSION['userid']." order by id ";
}
$row=$DB->getRows($sql);
if($row){
	foreach ($row as $oRs){
		echo $oRs['msgaddtime'].' '.GetCustomNameById($_SESSION['userid'],$oRs['fromid']).' says:'.$br;
		if($oRs['typeid']==2){
			if(trim($oRs['msgcontent'])=='FLASH'){
				$msgContent = "Flash";
			}
		}else{
			$msgContent = str_replace('{br}',$br,$oRs['msgcontent']);
		}
		echo $msgContent.$br.$br;
	}
}else{
	echo 'Nothing';
}
$DB->Close();
?>
