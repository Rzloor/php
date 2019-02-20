<?php
namespace app\index\controller;
use think\Controller;

class Js extends Controller
{
    public function index()
    {
        #冒泡排序
       /* $arr = array(10,2,36,14,10,25,23,85,99,45);
        bubble_sort($arr);
        print_r($arr);*/
       #顺序查找
       /* $arr1 = array(9,15,34,76,25,5,47,55);
        echo seq_sch($arr1,47);*/
       #二分查找
        /*$arr2 = array(5,9,15,25,34,47,55,76);
        echo bin_search($arr2,0,7,47);*/
        #洗牌算法测试
//        dump(wash_card(54));
        //将一个二维数组转换为 HashMap，并返回结果

//        return view('/js');
//        echo strlen("你好");
//        echo strpos("Hello world!","world");
//        $str = addcslashes("A001 A002 A003","A");echo $str;
        /*$num = 1;
        $str = "上海";*/
//        printf("在%s有%u百万辆车",$str,$num);
       /* parse_str("name=ranzhen&age=30&sex=1",$arr);
        print_r($arr);*/


       //php 常用几种循环方式
//        while
//        $x = 6;
        /*while ($x<=5){
            echo "这个数字是：$x <br>";
            $x++;
        }*/
//        do while
      /*  do{
            echo "这个数字是：$x <br>";
            $x++;
        }while($x<=5);*/
      //php 将数组索引从0开始整合起来输出
        $arr = array('1'=>11,'2'=>22,'5'=>66);
        $arr1 = array("name"=>"冉珍","sex"=>25,"height"=>"190cm");
        #print_r(array_values($arr));echo "<br>";print_r(array_values($arr1));
        #print_r(array_merge($arr));echo "<br>";print_r(array_merge($arr1));
//        print_r($this->resetArr($arr));echo "<br>";print_r($this->resetArr($arr1));
        echo mt_rand(10,2000);

    }
    function resetArr($arr){
        $temp = array();
        foreach ($arr as $k => $v){
            $temp[] = $v;
        }
        return $temp;
    }
    //php数组打乱，反向排序出来
    public function sortFun(){
        //[1]
        /*$arr = array("4","3","5","85","66");
        $arr1 = array_reverse($arr);
        for ($x=0;$x<count($arr1);$x++){
            echo $arr1[$x]."<br>";
        }*/
        //[2]
        /*/$number = range(1,10);
        print_r(array_reverse($number));*/
        //[3]
        /*$num = array();
        for ($x=10;$x>0;$x--){
            array_push($num,$x);
        }
        print_r($num);*/
        //生成唯一订单号
//        echo date("Ymd").uniqid().mt_rand(0,10000);


        //123
        $items = array(
            1 => array('id' => 1, 'pid' => 0, 'name' => '安徽省'),
            2 => array('id' => 2, 'pid' => 0, 'name' => '浙江省'),
            3 => array('id' => 3, 'pid' => 1, 'name' => '合肥市'),
            4 => array('id' => 4, 'pid' => 3, 'name' => '长丰县'),
            5 => array('id' => 5, 'pid' => 1, 'name' => '安庆市'),
        );
        var_dump($this->make_tree1($items));
    }
    function make_tree1($list,$pk='id',$pid='pid',$child='_child',$root=0){
        $tree=array();
        foreach($list as $key=> $val){
            if($val[$pid]==$root){
                //获取当前$pid所有子类
                unset($list[$key]);
                if(! empty($list)){
                    $child=make_tree1($list,$pk,$pid,$child,$val[$pk]);
                    if(!empty($child)){
                        $val['_child']=$child;
                    }
                }
                $tree[]=$val;
            }
        }
        return $tree;
    }
    function generateTree($items){
        $tree = array();
        foreach($items as $item){
            if(isset($items[$item['pid']])){
                $items[$item['pid']]['son'][] = &$items[$item['id']];
            }else{
                $tree[] = &$items[$item['id']];
            }
        }
        return $tree;
    }
    //php 原生学习
    public function old_php()
    {
       /* $arr = array(0=>"1",1=>"3",2=>"5",3=>"90",4=>"102");
        for ($x=count($arr);$x>0;$x--){
            echo $arr[$x].PHP_EOL;
        }*/
       $a = 3;
//       $b = $a++;echo $a."=".$b;
//        $b = $a--;echo $a."=".$b;
//        $b = --$a;echo $a."=".$b;
//        $b = ++$a;echo $a."=".$b;
        $start = "02";
        $start++;
        print $start;
    }
}