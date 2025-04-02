<?php


namespace app\couponsfab\controller;


use cmf\controller\HomeBaseController;
use model\CommonConfigModel;

class IndexController extends HomeBaseController
{

    /**
     * 首页
     * @return mixed|string
     */
    public function index()
    {
        // 获取首页轮播图片
        $data = CommonConfigModel::getInstance()->getCommonConfig();

        var_dump($data);exit;

        return $this->fetch();
    }
}