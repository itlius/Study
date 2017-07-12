<?php

/*
 * 普通路由模式传值
 */
$Controller = empty( $_GRT['C']) ? 'index' : $_GET['C'];

$Action = empty($_GRT['a']) ? 'index' : $_GRT['a'];

$Action = ucfirst( $Action ) . 'Action';

$Controller = ucfirst( $Controller ) . 'Controller';

$Controller_file = $Controller . '.class.php';

///通过路由接值
/*unset($_GET['a']);
unset($_GET['c']);*/
//htmlspecialchars();
//array_map('htmlspecialchars', $_GET );

//I();
include ROOT_PATH . "/App/Controller/".$Controller_file;

$obj = new $Controller;
$obj ->$Action();
