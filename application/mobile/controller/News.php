<?php
/**
 * 测试新闻分页加载数据
 */

namespace app\mobile\controller;

use think\Controller;

class News extends Controller
{
    public function getNews()
    {
        return $this->fetch('news/list-news');
    }
}