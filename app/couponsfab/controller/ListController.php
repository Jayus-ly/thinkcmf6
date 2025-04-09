<?php


namespace app\couponsfab\controller;


use cmf\controller\HomeBaseController;

class ListController extends HomeBaseController
{

    public function list()
    {

        return $this->fetch('brandList');
    }



}