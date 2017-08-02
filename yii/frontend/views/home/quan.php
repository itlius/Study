<?php
/**
 * Created by PhpStorm.
 * User: haier
 * Date: 2017/8/3
 * Time: 8:53
 * 写一个函数，可以根据各个元素的权重返回随机数 （加权随机数）
         function(Array_A，n)
    Array_A：是一个数组，表示各个元素出现的概率，
    n：为需要返回的元素个数

    如果n=1，则返回一个元素（Array_A中的key） ， n=2则返回两个元素（Array_A中的key）

    示例：

    function({20,50,30},1): 返回长度为1的数组，其中返回值为{0}的概率为20/(20+50+30)，返回值为{1}的概率为50/(20+50+30)，返回值为{2}的概率为30/(20+50+30)
     *
    function({20,50,30},2): 返回长度为2的数组，其中返回值中包含{0}的概率为20/(20+50+30)，返回值中包含{1}的概率为50/(20+50+30)，返回值中包含{2}的概率为30/(20+50+30)
     */

    //一个数组a，b，a，d，d，c，c，d。a。b 按照出现的次数，abdc这样结果
    /*while(count($new)){
        $temp=0;
        foreach( $new < $key){
            if($temp < $sum){
                $temp = $value;
            }

        }
        unset ($new[$key]);}
    */
    $w = array('a' =>1, 'b'=>10, 'c'=>14, 'e'=>20, 'f'=>30, 'h'=>6, 'g'=>70);
    function roll($weight)
    {
        $sum = array_sum($weight);
        $j = 0;
        foreach($weight as $k=>$v)
        {
            $j = mt_rand(1,$sum);
            if($j <= $v)
            {
                return $k;
            }else{
                $sum -= $v;
            }
        }
    }
  /*  $ret = array();
    $n = 1000;
    for($i=0;$i<$n;$i++)
    {
        $v = roll($w);
        $ret[$v] = isset($ret[$v]) ? $ret[$v] + 1 :1;
    }
    print_r($ret);
    foreach($ret as $k=>$v)
    {
        printf("real: %f\t", ($v / $n));
        printf("set: %f\n",($w[$k] / array_sum($w)));
    }*/




