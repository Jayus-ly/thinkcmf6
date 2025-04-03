<?php


namespace app\couponsfab\controller;

use cmf\controller\HomeBaseController;

/**
 * 前台页面
 * Class IndexController
 * @package app\couponsfab\controller
 */
class IndexController extends HomeBaseController
{

    public function index()
    {

        return $this->fetch();
    }
}