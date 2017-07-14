<?php

function I ( $param , $default = ''){
	if( empty($param) ){
		exit(__FUCTION.'请传入参数');
	}
	$param = explode('.', $param);

	var_dump($param);
}