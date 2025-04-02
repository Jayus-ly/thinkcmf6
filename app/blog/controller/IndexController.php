<?php


namespace app\blog\controller;


use cmf\controller\AdminBaseController;
use model\AdSenseModel;

class IndexController extends AdminBaseController
{

    public function index()
    {
        $param = input();

        $date = $param['date'] ?? ''; // 日期选择
        $updateTime = $param['update_time'] ?? ''; // 更新时间筛选
        $site = $param['site'] ?? ''; // 域名

        $pageNum = $param['page'] ?? config('common.default_page_num');
        $pageSize = $param['size'] ?? config('common.default_page_size');

        $model = new AdSenseModel();

        $sql = $model->when($date, function ($query) use ($date) {
            // 根据 ~ 分割
            $query->whereBetween('date', explode(' ~ ', $date));
        })->when($updateTime, function ($query) use ($updateTime) {
            // 根据 ~ 分割
            $query->whereBetween('update_time', explode(' ~ ', $updateTime));
        })->when($site, function ($query) use ($site) {
            $query->where('site', 'like', '%' . $site . '%');
        });

        $count = $sql->count();
        $list = $sql->page($pageNum, $pageSize)
            ->order('id', 'desc')
            ->select();


        $this->assign('count', $count);
        $this->assign('page', $pageNum);
        $this->assign('list', $list);
        return $this->fetch();
    }


}