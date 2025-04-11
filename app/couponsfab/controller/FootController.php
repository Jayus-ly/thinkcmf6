<?php


namespace app\couponsfab\controller;


use cmf\controller\HomeBaseController;
use model\FootContentModel;

class FootController extends HomeBaseController
{

    public function index()
    {
        $param = input();

        $name = $param['name'] ?? 'about';

        $model = FootContentModel::getInstance()->where('name', $name)->find();

        $this->assign('model', $model);
        return $this->fetch('content');
    }
}