<?php
header("Content-type:text/html;charset=utf-8");
include_once("db.class.php");

$db = new db();

//品牌列表

$sql = "select brand_id , brand_name  from ecs_brand ";

$brand_list  =  $db->getAll($sql);

$sql  = "SELECT cat_name, cat_id FROM `ecs_category`  ";

$type_list  = $db->getAll($sql);



if(isset($_GET["key"])){
	$key  = trim($_GET["key"]);
}else{
	$key  ="";
}

if(isset($_GET["type"])){
	$type  = trim($_GET["type"]);
}else{
	$type  ="";
}

if(isset($_GET["brand"])){
	$brand  = trim($_GET["brand"]);
}else{
	$brand  ="";
}

if(isset($_GET["page"])){
	$page  = intval($_GET["page"]);
}else{
	$page  = 1;
}

$where = "";

if($brand ){

	$where .= " and brand_id = ".$brand;
}

if($type){
	$where .= " and cat_id = ".$type;
}

if($key){
	$where .= " and goods_name like '%".$key."%'" ;
}



//分页 
$sql ="select count(*) from ecs_goods where 1=1  ".$where; 

echo $sql;
$count = $db->getOne($sql);

$pagesize  = 2; 

//总页数
$total_page = ceil($count/$pagesize) ; 

$start = ($page-1)*$pagesize;

$sql = "select goods_id ,goods_name  from ecs_goods where 1=1 ".$where. " limit ".$start.",".$pagesize ;

$list = array(); 

$list = $db->getAll($sql);


?>




<style>
.red { color:red;}
</style>

<div>
<h2>搜索</h2>

<form action="?" method="get">
	关键字：<input type="text" name="key" value="<?=$key?>" > &nbsp;&nbsp; <input type="submit" >
</form>
<hr />
</div>

<?php
	
?>
<div>
品牌:
<?php
	
	if(!isset($brand) || trim($brand=="all")){
		$class  = "class='red'";
	}else{
		$class  = "";
	}
	
	$str = "<a href='?brand=all&key={$key}&type={$type}' {$class} >全部</a>&nbsp;&nbsp;";
	
	
	foreach ($brand_list as $v){
		if(isset($brand) && $brand ==$v["brand_id"]) {
			$str.="<a href='?brand=".$v["brand_id"]."&key={$key}&type={$type}' class='red'>".$v["brand_name"]."</a>&nbsp;&nbsp;" ; 
		}else{
			$str.="<a href='?brand=".$v["brand_id"]."&key={$key}&type={$type}'>".$v["brand_name"]."</a> &nbsp;&nbsp;" ;
		}
	}
	echo $str;

?>
</div>


<div>
分类: 
<?php
	if(!isset($type) || trim($type)=="all"){
		$class  = "class='red'";
	}else{
		$class  = "";
	}
	$str = "<a href='?type=all&key={$key}&brand={$brand}' {$class} >全部</a>&nbsp;&nbsp;";
	foreach ($type_list as $v){
		if(isset($type) && $type==$v["cat_id"]) {
			$str.="<a href='?type=".$v["cat_id"]."&key={$key}&brand={$brand}' class='red'>".$v["cat_name"]."</a>&nbsp;&nbsp;" ; 
		}else{
			$str.="<a href='?type=".$v["cat_id"]."&key={$key}&brand={$brand}'>".$v["cat_name"]."</a> &nbsp;&nbsp;" ;
		}
	}
	echo $str;

?>
</div>

<hr>
<div>

<?php
print_r($list);
?>
<hr />
<?php
	
	$page = "<a href='?page=1&key={$key}&brand={$brand}&type={$type}' > 首页 </a>  " ;
	
	$min = max(1, $page-1);
	
	$page.= "<a href='?page={$min}&key={$key}&brand={$brand}&type={$type}'> 上一页 </a>  " ;
	
	$max = min($total_page,$page+1);

	$page.= "<a href='?page={$max}&key={$key}&brand={$brand}&type={$type}'> 下一页 </a>  " ;
	$page.= "<a href='?page={$total_page}&key={$key}&brand={$brand}&type={$type}'> 尾页 </a>  " ;


	echo $page  ;
?>

</div>