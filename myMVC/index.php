<?php
//设置时区
ini_set('date.time_zone','Asia/Shanghai');
//设置页面显示错误级别
ini_set('display_errors','off');
//封装入口文件;
//ini_set();
//var_dump($_GET);
//exit;

//路由器V    加载自动加载文件include
//定义ROOT_PATH
define('ROOT_PATH', str_replace('\\', '/', __DIR__));

//自定义框架目录
define('FRAMEWORK_PATH', str_replace('\\', '/', __DIR__) .DIRECTORY_SEPARATOR.'Framework');
//打印
//var_dump( ROOT_PATH );
include ROOT_PATH . DIRECTORY_SEPARATOR . 'Framework' . DIRECTORY_SEPARATOR .'core'. DIRECTORY_SEPARATOR. 'route.php';
//var_dump( DIRECTORY_SEPARATOR );push
