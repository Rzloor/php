<?php
/**
 * Created by PhpStorm.
 * User: rzloor
 * Date: 2019/3/21
 * Time: 18:22
 */
//获取URL访问的ROOT地址 网站的相对路径
define('BASE_SITE_ROOT', str_replace('/index.php', '', \think\Request::instance()->root()));
define('PLUGINS_SITE_ROOT', BASE_SITE_ROOT.'/static/plugins');
define('ADMIN_SITE_ROOT', BASE_SITE_ROOT.'/static/admin');
define('HOME_SITE_ROOT', BASE_SITE_ROOT.'/static/home');
define("REWRITE_MODEL", FALSE); // 设置伪静态
if (!REWRITE_MODEL) {
    define('BASE_SITE_URL', \think\Request::instance()->domain() . \think\Request::instance()->baseFile());
} else {
    // 系统开启伪静态
    if (empty(BASE_SITE_ROOT)) {
        define('BASE_SITE_URL', \think\Request::instance()->domain());
    } else {
        define('BASE_SITE_URL', \think\Request::instance()->domain() . \think\Request::instance()->root());
    }
}
