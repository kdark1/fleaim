<?
require('function.php');
$picsStr='var aPics =[';
$picsStr.=getDirFileName('../images');
$picsStr.=','.getDirFileName('../msnface');
$picsStr.='];';
echo $picsStr;

