<?php
/**
 * vip 在线解析站
 * author rzloor
 * email torucc@foxmail.com
 */

namespace app\vip\controller;


use think\Controller;

class Index extends Controller
{
    public function indexIni()
    {
        return $this->fetch('index/index');
    }
    public function startPlay()
    {
        session_start();
        error_reporting(E_ALL);
        date_default_timezone_set("PRC");
        header("Content-Type: text/html; charset=UTF-8");

        return $this->fetch('index/startPlay');
    }
}