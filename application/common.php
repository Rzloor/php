<?php
require __DIR__ . '/common_global.php';
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
//showdialog
function ds_show_dialog($message = '', $url = '', $alert_type = 'error', $extrajs = '', $time = 2)
{
    $message = str_replace("'", "\\'", strip_tags($message));

    $paramjs = null;
    if ($url == 'reload') {
        $paramjs = 'window.location.reload()';
    }
    elseif ($url != '') {
        $paramjs = 'window.location.href =\'' . $url . '\'';
    }
    if ($paramjs) {
        $paramjs = 'function (){' . $paramjs . '}';
    }
    else {
        $paramjs = 'null';
    }
    $modes = array('error' => 'alert', 'succ' => 'succ', 'notice' => 'notice', 'js' => 'js');
    $cover = $alert_type == 'error' ? 1 : 0;
    $extra = 'showDialog(\'' . $message . '\', \'' . $modes[$alert_type] . '\', null, ' . ($paramjs ? $paramjs : 'null') . ', ' . $cover . ', null, null, null, null, ' . (is_numeric($time) ? $time : 'null') . ', null);';
    $extra = '<script type="text/javascript" reload="1">' . $extra . '</script>';
    if ($extrajs != '' && substr(trim($extrajs), 0, 7) != '<script') {
        $extrajs = '<script type="text/javascript" reload="1">' . $extrajs . '</script>';
    }
    $extra .= $extrajs;
    ob_end_clean();
    @header("Expires: -1");
    @header("Cache-Control: no-store, private, post-check=0, pre-check=0, max-age=0", FALSE);
    @header("Pragma: no-cache");
    @header("Content-type: text/xml; charset=utf-8");

    $string = '<?xml version="1.0" encoding="utf-8"?>' . "\r\n";
    $string .= '<root><![CDATA[' . $message . $extra . ']]></root>';
    echo $string;
    exit;
}
//冒泡法 升降序排列数组
function arraysort($data, $order = 'asc') {
//asc升序 desc降序
    $temp = array ();
    $count = count ( $data );
    if ($count <= 0)
        return false; //传入的数据不正确
    if ($order == 'asc') {
        for($i = 0; $i < $count; $i ++) {
            for($j = $count - 1; $j > $i; $j --) {
                if ($data [$j] < $data [$j - 1]) {
//交换两个数据的位置
                    $temp = $data [$j];
                    $data [$j] = $data [$j - 1];
                    $data [$j - 1] = $temp;
                }
            }
        }
    } else {
        for($i = 0; $i < $count; $i ++) {
            for($j = $count - 1; $j > $i; $j --) {
                if ($data [$j] > $data [$j - 1]) {
                    $temp = $data [$j];
                    $data [$j] = $data [$j - 1];
                    $data [$j - 1] = $temp;
                }
            }
        }
    }
    return $data;
}
function arrBysort($data,$order = 'asc')
{
    $temp = array();
    $count = count($data);
    if ($count<=0){
        return false;
    }
   if ($order == 'asc'){
       for ($x=0;$x<$count;$x++){
           for ($y=$count-1;$y>$x;$y--){
               if ($data[$y]<$data[$y-1]){
                   $temp = $y;
                   $data[$y] = $data[$y-1];
                   $data[$y-1] = $temp;
               }
           }
       }
   }
   else {
       for ($i = 0; $i < $count; $i++) {
           for ($j = $count - 1; $j > $i; $j--) {
               if ($data [$j] > $data [$j - 1]) {
                   $temp = $data [$j];
                   $data [$j] = $data [$j - 1];
                   $data [$j - 1] = $temp;
               }
           }
       }
   }
    return $data;
}
/**
 * 二分查找
 */
function bin_search_e($arr,$low,$high,$k){
    if ($low<$high){
        $mid =intval(($low+$high)/2);
        if($arr[$mid] == $k)
        {
            return $mid;
        }
        else if($k < $arr[$mid])
        {
            return bin_search($arr,$low,$mid-1,$k);
        }
        else
        {
            return bin_search($arr,$mid+1,$high,$k);
        }
    }
    return -1;
}
function my_scandir($dir)
{
    $files = array();
    if($handle = opendir($dir))
    {
        while (($file = readdir($handle))!== false)
        {
            if($file != '..' && $file != '.')
            {
                if(is_dir($dir."/".$file))
                {
                    $files[$file]=my_scandir($dir."/".$file);
                }
                else
                {
                    $files[] = $file;
                }
            }
        }
        closedir($handle);
        return $files;
    }
}

function request_post($url = '', $param = '') {
    if (empty($url) || empty($param)) {
        return false;
    }

    $postUrl = $url;
    $curlPost = $param;
    $curl = curl_init();//初始化curl
    curl_setopt($curl, CURLOPT_URL,$postUrl);//抓取指定网页
    curl_setopt($curl, CURLOPT_HEADER, 0);//设置header
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
    curl_setopt($curl, CURLOPT_POST, 1);//post提交方式
    curl_setopt($curl, CURLOPT_POSTFIELDS, $curlPost);
    // 关闭SSL验证
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    $data = curl_exec($curl);//运行curl
    if ($data === FALSE){
        echo 'cURL Error:'.curl_error($curl);
    }
    curl_close($curl);
    return $data;
}

/**
 * 递归无限极分类实现
 */
function tree($arr,$pid = 0,$level = 0){
    static $list = [];
    foreach ($arr as $v){
        if ($v['parent_id'] == $pid){
            $v['level'] = $level;
            $list[] = $v;
            tree($arr,$v['cat_id'],$level+1);
        }
    }
    return $list;
}
//地柜无限极数据库设计

/*CREATE TABLE category(
    cat_id smallint unsigned not null auto_increment primary key comment'类别ID',
cat_name VARCHAR(30)NOT NULL DEFAULT''COMMENT'类别名称',
parent_id SMALLINT UNSIGNED NOT NULL DEFAULT 0 COMMENT'类别父ID'
)engine=MyISAM charset=utf8;*/

/**
 * 抓取网页内容
 */
//[1]
function getContents($url){
    $contents = fopen($url,'rb');
    $stream_contents = stream_get_contents($contents);
    fclose($contents);
    return $stream_contents;
}
//[2]
function getfileContents($url){
    if (empty($url))  return false;
    return file_get_contents($url);
}

/**
 *  将截止时间秒数转换为日期制
 */
function formatTime($date){
    $t = $date-time();
    $f = array(
        '31536000'=>'年',
        '2592000'=>'个月',
        '604800'=>'星期',
        '86400'=>'天',
        '3600'=>'小时',
        '60'=>'分钟',
        '1'=>'秒'
    );
        foreach($f as $k=>$v){
            $c = floor($t/(int)$k);
            if($c > 0){
                if(0 != $c){
                    return "剩余".$c.$v;
                }
            }
        }
    return "已截止";
}

/**
 * 字符串翻转
 */
function strReev($str){
    if ($str == '')
    {
        return false;
    }
    $len  = strlen($str);
    $newstr = '';
    if ($len<=0){
        return false;
    }
    for ($i=$len-1;$i>=0;$i--){
        $newstr .= $str[$i];
    }
    return $newstr;
}

/**
 * 递归循环某目录下的子目录及文件并输出
 */
function treeDir($dir,$level=1){
    $dir = opendir($dir);
    while ($dirname=readdir($dir)){
        if ($dirname == '.' || $dirname == '..') continue;
        echo '|'.str_repeat('_',$level).$dirname;
        echo '<br>';
        if (is_dir($dir.'/'.$dirname))  treeDir($dir.'/'.$dirname,$level+2);
    }
}
function hello($name) {
    return "Hello $name!";
}
?>


