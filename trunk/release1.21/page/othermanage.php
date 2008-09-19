<?
require('../data/function.php');
//Db size
$DbSize='';

$FaceSize=round(countDirSize('../userface/')/1024,1);

$FaceCount=getDirCount('../userface/');
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
</script>
</head>
<body> 
<div style="width:540px;height:15px;text-indent:6px">
	<a onclick="showLoading()" href="usermanage.php">Users</a>&nbsp;&nbsp;<span class="gray">System Info</span>
</div>
<div style="float:left;width:100%;height:388px;overflow:auto;padding-top:10px">
<ul style="line-height:150%;font-size:13px">
	<li><? echo $DB->getOne("select count(*) from user",true)?> Registered</li>
	<li><? echo $DB->getOne("select count(*) from usernum where isok=1",true)?> Left</li>
	<li><? echo $DB->getOne("select count(*) from user where userpower=0",true)?> Super Administrator(s)</li>
	<li><? echo $DB->getOne("select count(*) from user where userpower=1",true)?>Administrator(s)</li>
	<li><? echo $DB->getOne("select count(*) from usermsg",true)?> Normal Messages</li>
	<li><? echo $DB->getOne("select count(*) from usersysmsg",true)?> Broadcast Messages</li>
	<li>Database Size<? echo $DbSize?>KB</li>
	<li><?echo $FaceCount?> Thumbs, <? echo $FaceSize?>KB In Size</li>
</ul>
</div>
</body>
</html>
<? $DB->Close();?>