<?
require('../data/function.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../styles/webimpage.css" type="text/css" rel="stylesheet" media="all">
<script type="text/javascript" src="../js/webimhelper.js"></script>
<script type="text/javascript" src="../js/webimpage.js"></script>
<title>Send Email</title>
<script type="text/javascript">
var uid = 11;
</script>
</head>
<body> 

<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="15" align="center"></td>
  </tr>
    <tr>
    <td height="25" align="center"><? echo $_GET['e']?>
&nbsp;<a class="gray" href="mailto:<? echo $_GET['e']?>">Click To Send Email</a></td>
  </tr>
  <tr>
    <td height="80" align="center"></td>
  </tr>
  <tr>
    <td height="35" align="center"><input class="button1" type="button" name="btnLogin" id="btnLogin" value="Close" onclick="winClose(event);"/></td>
  </tr>
</table>
</div>
</body>
</html>