<?php


namespace app\couponsfab\controller;


use cmf\controller\HomeBaseController;
use model\ItemClassificationModel;

class ListController extends HomeBaseController
{

    public function list()
    {
        $model = ItemClassificationModel::getInstance();

        // 获取分类
        $classification = $model->where(['parent_id' => ItemClassificationModel::PARENT_ID_LEVEL_TOP])->select()->toArray();

        return $this->fetch('brandList', [
            'classification' => $classification
        ]);
    }



}