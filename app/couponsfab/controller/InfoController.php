<?php


namespace app\couponsfab\controller;


use cmf\controller\HomeBaseController;
use model\CouponsModel;
use model\ItemClassificationModel;

class InfoController extends HomeBaseController
{
    /**
     * 品牌详情
     * @return mixed|string
     */
    public function index()
    {
        $param = input();
        $id = $param['id'] ?? 0;
        if (empty($id)) {
            $this->error(404, '/');
        }
        // 获取品牌详情
        $model = ItemClassificationModel::getInstance()->find($id);
        if (empty($model)) {
            $this->error(404, '/');
        }
        $model = $model->toArray();

        // 获取品牌分类
        $classification = ItemClassificationModel::getInstance()->find($model['parent_id']);

        return $this->fetch('info', ['data' => $model, 'classification' => $classification, 'id' => $id]);
    }

    public function getCouponsListPost()
    {
        $param = input();
        $id = $param['id'] ?? 0;


        $pageNum = $param['page'] ?? config('common.default_page_num');
        $pageSize = $param['size'] ?? config('common.default_page_size');

        // 获取品牌优惠券列表
        $sql = CouponsModel::getInstance()
            ->where('classification_id', $id);

        $count = $sql->count();

        $coupons = $sql->page($pageNum, $pageSize)
            ->select()
            ->toArray();


        $this->result(['PageCount' => $count, 'Coupons' => $coupons], 1, 'success', 'json'); // 参数含义：数据、状态码、消息
    }
}