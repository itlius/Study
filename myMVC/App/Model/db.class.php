<?php
class db{
	//自定义封装DB类
	//连接数据库
	function __construct(){
		$dbcon = @mysql_connect('127.0.0.1','root','root');
		mysql_select_db("week", $dbcon);
		$this->query("set names utf8");
	}
	/*
	基本操作数据库
	 */
	public function Query($sql){
		return mysql_query($sql);
	}
	/*
	获取一个查询数据的值   eg  select count(*) from week limit 1;
	 */
	public function GetOne($sql){
		$query = $this->query($sql);
		if(!$query){
			return 0;
		}
		return mysql_query($sql,0);
	}
	
}
