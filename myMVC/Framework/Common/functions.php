<?php

function I ( $param , $default = ''){
	if( empty($param) ){
		exit(__FUCTION.'�봫�����');
	}
	$param = explode('.', $param);

	var_dump($param);
}