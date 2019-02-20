<?php
namespace app\index\controller;
use think\Controller;
use think\Exception;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/17
 * Time: 15:05
 */
class Three extends  Controller
{
    public function three()
    {
        return $this->fetch("360");
    }
    public function Jspush_arr()
    {
        return $this->fetch("js_arr");
    }
    //redis test
    public function redis()
    {
        $redis = connectRedis();
        $redis->set("author","Rzloor");
        echo $redis->get("author");
    }
    //秒杀入口
    public function index()
    {
        $id =1;//商品编号
        if (!$id)
        {
            return $this->insertlog("参数错误",0,0);//记录失败日志
        }
        $redis = connectRedis();
        $count = $redis->lPop("goods_store");//减少库存，返回商品库存数
        if (!$count){
            $this->insertlog("减少库存error",0,$count);//记录秒杀失败日志
            return false;
        }else{//有库存
            $order_sn = generateJnlNo();
            $uid = mt_rand(0,99999);
            $status = 1;
            $goodsInfo = db("goods")->where(["id"=>$id])->field("count,amount")->find();//商品信息
            if (!$goodsInfo){
                return $this->insertlog("商品不存在",0,0);//商品不存在
            }
            $result = db("order")->insert(array("order_sn"=>$order_sn,"user_id"=>$uid,"goods_id"=>$id,"price"=>1000,"status"=>0));
            //库存减少
            $res = db("goods")->where("id",$id)->setDec("count",$count);
            if ($res){
                $this->insertlog("库存减少成功！",0,$count);
                return $this->redisinit();
            }
            else{
                $this->insertlog("库存减少失败！",0,0);
            }
        }
    }
    //采用队列的方式加入库存
    //初始化redis数据列表 模拟库存50
    public function redisinit()
    {
        $score = db("goods")->where(["id"=>1])->value("count");//库存
        $redis = connectRedis();
        $redis->del("goods_store");//删除库存列表
        $res = $redis->lLen("goods_store");
        $count = $score-$res;
        for ($i=0;$i<$count;$i++){
            $redis->lPush("goods_store",1);//模拟50个库存，列表推进
        }
        echo $redis->lLen("goods_store");

    }
    protected final function insertlog($content='',$status=1,$count=0) {
        $data = array();
        $data['content'] = $content;
        $data['status'] = $status;
        $data['count'] = $count;
        $data['ip'] = request()->ip();
        return db("log")->insert($data);
    }
    public function redisMuch()
    {
        $redis = new \Redis();
        $redis->connect("127.0.0.1",6379);
        for ($i=0;$i<1000;$i++){
            try{
                $redis->lPush("click",rand(1000,5000));
            }catch (Exception $e){
                echo $e->getMessage();
            }
        }
    }
    public function redisMuchout()
    {
        $redis = new \Redis();
        $redis->pconnect("127.0.0.1",6379);
        while(true){
            try{
                $value = $redis->lPop("click");
                if (!$value){
                    break;
                }
                var_dump($value)."\n\r";
            }catch(Exception $e){
                echo $e->getMessage();
            }
        }
    }
}