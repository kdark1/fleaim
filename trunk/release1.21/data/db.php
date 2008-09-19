<?php
//*******************************************************************

Class db
{
	var $host;
	var $user;
	var $passwd;
	var $database;
	var $conn;


	function db($host,$user,$password,$database)
	{
		$this->host = $host;
		$this->user = $user;
		$this->passwd = $password;
		$this->database = $database;
		$this->conn=mysql_connect($this->host, $this->user,$this->passwd) or
		die("Could not connect to $this->host");
		mysql_select_db($this->database,$this->conn) or
		die("Could not switch to database $this->database");
	}

	function Close()
	{
		mysql_close($this->conn);
	}


	function Query($queryStr)
	{
		@mysql_query("set names utf8"); 
		$res =mysql_query($queryStr, $this->conn);
		return $res;
	}

	function getRows($sql)
	{
		$res=$this->Query($sql);
		$rowno = 0;
		$rowno = mysql_num_rows($res);
		if($rowno>0)
		{
			for($row=0;$row<$rowno;$row++ )
			{
				$rows[$row]=mysql_fetch_array($res);

			}
			return $rows;
		}
	}

	function getOne($sql,$first=false)
	{
		$rs=mysql_fetch_array($this->Query($sql));
		if($first){
			return $rs[0];
		}else {
			return $rs;
		}
	}

	function getRowsNum($res)
	{
		$rowno = 0;
		$rowno = mysql_num_rows($res);
		return $rowno;
	}


	function getFieldsNum($res)
	{
		$fieldno = 0;
		$fieldno = mysql_num_fields($res);
		return $fieldno;
	}


	function getFields($res)
	{
		$fno = $this->getFieldsNum($res);
		if($fno>0)
		{
			for($i=0;$i<$fno;$i++ )
			{
				$fs[$i]=MySQL_field_name($res,$i);
			}
			return $fs;
		}
	}

}
?>