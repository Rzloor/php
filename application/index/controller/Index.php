<?php
namespace app\index\controller;

use think\Controller;
use think\Db;
use think\Request;

class Index extends Controller
{
    public function index()
    {
        return view('/index');
    }
    public function getdata()
    {
        if (Request::instance()->isAjax())
        $p=input('param.p',1,'intval');
        $size=input('param.size',1,'intval');
        $data = Db::table('article')
            ->page($p,$size)
            ->select();
        if ($data)
        {
            return json($data,200);
        }
    }
    //本地测试分布式数据库读写分离
    //写入主库
    public function baseinsert()
    {
        $data  = ["id"=>3,"sex"=>"男","age"=>25];
        $res = db("user")->insert($data);
        if ($res)  $this->success("入库成功!");else $this->error("入库失败!");
    }
    //读取从库
    public function baseselect()
    {
        $data = db("user")->select();
        print_r($data);
    }
}
