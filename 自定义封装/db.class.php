<?php
class db {

	//连接数据库
	//设置编码 utf8 
	function __construct(){
		$dbcon  =  @mysql_connect("127.0.0.1","root","");
		mysql_select_db("ecshop",$dbcon);
		$this->query("set names utf8 ");
	}

	/*
	基本sql操作方法
	*/
	//query($sql)  执行一个sql语句
	public function query($sql){
		return mysql_query($sql);
	}

	//getOne($sql)  获取一个字段的值 ， eg： select count(*) from 表  limit 1  。
	public function getOne($sql){
		$query = $this->query($sql);
		
		if(!$query){
			return 0 ;
		}

		return mysql_result($query,0);
	}

	//getRow($sql)  获取一行记录的值 。 
	public function getRow($sql ,$type = "array"){
		//mysql_fetch_array()  //返回 索引数组和关联数组
		//mysql_fetch_row()    //返回 索引数组 
		//mysql_fetch_assoc()  //返回 关联数组

		$query = $this->query($sql);

		$function_name = "mysql_fetch_".$type ; 
		
		return $function_name($query);

	}
	//getAll($sql)  获取一组数据列表 。 
	public function getAll($sql ,$type="array"){
		$query = $this->query($sql);
		$function_name = "mysql_fetch_".$type ;
		$list = array();
		if($query){
			while( $r = $function_name($query)){
				$list[]  = $r; 
			}
		}

		return $list; 
	}
	
	//getLastInsertId()   获取最近的插入id 值 
	public function getLastInsertId(){
	
		return mysql_insert_id();
	}
/*
高级 增删改查 方法
*/

//insert($table , $data )  //插入一条新的数据 ，返回 insert_id      eg : $data = array("title"=>"adsfasf","content"=>"asdfad") ; 



//delete($table, $ids )  // 删除记录 ids对应的 。  eg: $ids =  array( 1,3,4,5); 

//update($table, $where , $data )  //修改条件对应的数据   $data();   eg : $data = array("title"=>"adsfasf","content"=>"asdfad") ;  $where = array("id"=>1) 

//select($table, $f ,  $where , $group   ,  $order  , $limit , $pagesize );


}

