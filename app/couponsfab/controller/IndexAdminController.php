<?php


namespace app\couponsfab\controller;


use cmf\controller\AdminBaseController;

class IndexAdminController extends AdminBaseController
{

    public function index()
    {



        return $this->fetch();
    }
}