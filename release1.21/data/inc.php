<?
/**
 *
 * @param datetime $BeginTime
 * @param datetime $EndTime
 * @param string $elaps
 * @return int
 */
function DateLast($BeginTime,$EndTime,$elaps = "d")
{
	$__DAYS_PER_WEEK__       = (7);
	$__DAYS_PER_MONTH__      = (30);
	$__DAYS_PER_YEAR__       = (365);
	$__HOURS_IN_A_DAY__      = (24);
	$__MINUTES_IN_A_DAY__    = (1440);
	$__SECONDS_IN_A_DAY__    = (86400);

	$__DAYSELAPS = (strtotime($BeginTime) - strtotime($EndTime)) / $__SECONDS_IN_A_DAY__ ;
	switch ($elaps) {
		case "y":
		$__DAYSELAPS =  $__DAYSELAPS / $__DAYS_PER_YEAR__;
		break;
		case "M":
		$__DAYSELAPS =  $__DAYSELAPS / $__DAYS_PER_MONTH__;
		break;
		case "w":
		$__DAYSELAPS =  $__DAYSELAPS / $__DAYS_PER_WEEK__;
		break;
		case "h":
		$__DAYSELAPS =  $__DAYSELAPS * $__HOURS_IN_A_DAY__;
		break;
		case "m":
		$__DAYSELAPS =  $__DAYSELAPS * $__MINUTES_IN_A_DAY__;
		break;
		case "s":
		$__DAYSELAPS =  $__DAYSELAPS * $__SECONDS_IN_A_DAY__;
		break;
	}
	return round($__DAYSELAPS);
}
/**
 *
 * @param string $str
 * @return string
 */
function GetSafeStr($str){
	$GetSafeStr=str_replace("'","",trim($str));
	$GetSafeStr=str_replace('"','',trim($str));
	$GetSafeStr=str_replace(';','',trim($str));
	return $GetSafeStr;
}

/**
 *
 * @param string $title
 * @param int $length
 * @return string
 */
function CutStr($title,$length=12)
{
	if(empty($title)) {
		return '...';
	}
	return msubstr($title,0,$length,'utf-8');
}
/**
 +----------------------------------------------------------
 * 
 +----------------------------------------------------------
 * @static
 * @access public 
 +----------------------------------------------------------
 * @param string $str 
 * @param string $start 
 * @param string $length 
 * @param string $charset 
 * @param string $suffix 
 +----------------------------------------------------------
 * @return string
 +----------------------------------------------------------
 */
function msubstr($str, $start=0, $length, $charset="utf-8", $suffix=true)
{
	if(function_exists("mb_substr"))
	return mb_substr($str, $start, $length, $charset);
	elseif(function_exists('iconv_substr')) {
		return iconv_substr($str,$start,$length,$charset);
	}
	$re['utf-8']   = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
	preg_match_all($re[$charset], $str, $match);
	$slice = join("",array_slice($match[0], $start, $length));
	if($suffix) return $slice."…";
	return $slice;
}
/**
 *
 * @param date $str
 * @return string
 */
function ParseDateTime($str){
	return date('Y/m/d H:m',strtotime($str));
}
/**
 *
 * @param string $dir
 * @return int
 */
function countDirSize($dir)
{
	$handle = opendir($dir);
	while (false!==($FolderOrFile = readdir($handle)))
	{
		if($FolderOrFile != "." && $FolderOrFile != "..")
		{
			if(is_dir("$dir/$FolderOrFile")) {
				$sizeResult += getDirSize("$dir/$FolderOrFile");
			} else {
				$sizeResult += filesize("$dir/$FolderOrFile");
			}
		}
	}
	closedir($handle);
	return $sizeResult;
}
/**
 *
 * @param string $dir_name
 * @return int
 */
function getDirCount($dir_name)               
{
	global $files;                                 
	$od = opendir($dir_name);                      
	while ($name = readdir($od))                   
	{
		$file_path = $dir_name.'/'.$name;            
		if (is_file($file_path))                     
		$files[] = $file_path;                     
		else if (($name !='.') && ($name !='..'))    
		get_file_count($file_path);              
	}
	return count($files);                          
}
/**
 *
 * @param string $dir 
 * @return string
 */
function getDirFileName($dir){
	global $files;
	$od=opendir($dir);
	$str='';
	while ($name=readdir($od)) {
		if($name!='.'&& $name!='..'){
			$str.="'".substr($dir,3)."/".$name."',";
		}
	}
	return substr($str,0,-1);
}
?>