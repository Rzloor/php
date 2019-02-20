<?php
// 应用公共文件
#冒泡排序
function bubble_sort(&$arr){
    for ($i=0;$len=count($arr),$i<$len;$i++){
        for ($j=1;$j<$len-$i;$j++){
            if ($arr[$j-1]>$arr[$j]){
                $temp = $arr[$j-1];
                $arr[$j-1] = $arr[$j];
                $arr[$j] = $temp;
            }
        }
    }
}
#顺序查找
/**
 * 顺序查找
 * @param $arr 数组
 * @param $k 要查找的元素
 * @return mixed 成功返回数组下标，失败返回-1
 */
function seq_sch($arr,$k){
    for ($i=0;$n=count($arr),$i<$n;$i++){
        if ($arr[$i] == $k){
            break;
        }
    }
    if ($i<$n){
        return $i;
    }else{
        return -1;
    }
}
#二分查找
/**
 * @param array $array 数组
 * @param int $low 数组元素起始下标
 * @param int $high 数组元素末尾下标
 * @param $k 要查找的元素
 * @return mixed 成功返回数组下标，失败返回-1
 */
function bin_search($array,$low,$high,$k){
    if ($low<=$high){
        $mid = intval(($low+$high)/2);
        if ($array[$mid] == $k){
            return $mid;
        }
        elseif ($k<$array[$mid]){
            return bin_search($array,$low,$mid-1,$k);
        }else{
            return bin_search($array,$mid+1,$high,$k);
        }
    }
    return -1;
}
#洗牌算法
$card_num = 54;//牌数
function wash_card($card_num){
    $cards = $tmp = array();
    for ($i = 0;$i<$card_num;$i++){
        $tmp[$i] = $i;
    }
    for ($i = 0;$i<$card_num;$i++){
        $index = rand(0,$card_num-$i-1);
        $cards[$i] = $tmp[$index];
        unset($tmp[$index]);
        $tmp = array_values($tmp);
    }
    return $cards;
}
//递归无限极分类
function getTreesPro($data,$pid="0",$parentField='pid',$pkField='id'){
    $tree = array();
    foreach ($data as $k=>$v){
        if ($v[$parentField] == $pid){
            $temp = $this->getTreesPro($data,$v[$pkField]);//$data是对象则改为$v－>$pkField
            if (!empty($temp)){
                //分层
                $v['son'] = $this->getTreesPro($data,$v[$pkField]);
            }
            $tree[] = $v;
        }
    }
    return $tree;
}
//数组转对象

function arrayToObject($arr){
    if (is_array($arr)){
        return (object) array_map(__FUNCTION__,$arr);
    }else{
        return $arr;
    }
}
//对象转数组

function objectToarr(&$object){
    $object = json_decode(json_decode($object,true));
    return  $object;
}
//生成唯一订单号

function generateJnlNo() {
    date_default_timezone_set('PRC');
    $yCode    = array('A','B','C','D','E','F','G','H','I','J');
    $orderSn  = '';
    $orderSn .= $yCode[(intval(date('Y')) - 1970) % 10];
    $orderSn .= strtoupper(dechex(date('m')));
    $orderSn .= date('d').substr(time(), -5);
    $orderSn .= substr(microtime(), 2, 5);
    $orderSn .= sprintf('%02d', mt_rand(0, 99));
    //echo $orderSn,PHP_EOL;     //得到唯一订单号：G107347128750079
    return $orderSn;
}
function connectRedis(){
    $redis=new \Redis();
    $redis->connect(Config("REDIS_HOST"),Config("REDIS_PORT"));
    return $redis;
}
function dsLayerOpenSuccess($msg = '',$url='') {
//    echo "<script>var index = parent.layer.getFrameIndex(window.name);parent.layer.close(index);parent.location.reload();</script>";
    $url_js = empty($url)?"parent.location.reload();":"parent.location.href='".$url."';";

    $str = "<script>";
    $str .= "parent.layer.alert('".$msg."',{yes:function(index, layero){".$url_js."},cancel:function(index, layero){".$url_js."}});";
    $str .= "</script>";
    echo $str;
    exit;
}

