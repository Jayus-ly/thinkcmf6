<?php


namespace app\couponsfab\controller;


use cmf\controller\HomeBaseController;

class InfoController extends HomeBaseController
{

    public function index()
    {


        return $this->fetch('info');
    }
}