<?php


namespace app\couponsfab\controller;


use cmf\controller\HomeBaseController;
use model\ItemClassificationModel;
use model\ProductClassificationModel;
use model\ProductModel;

class ProductInfoController extends HomeBaseController
{

    /**
     * 商品详情
     * @return mixed|string
     * /couponsfab/productInfo/info
     */
    public function info()
    {
        $param = input();

        $id = $param['id'] ?? 0;

        $model = ProductModel::getInstance()->find($id);

        // 上级分类信息
        $classification = ProductClassificationModel::getInstance()->find($model['classification_id']);


        // 获取热门商品
        $hotProductList = ProductModel::getInstance()->where(['is_hot' => 1])->limit(10)->select()->toArray();

        // 设置了首页显示的品牌

        $itemClassification = ItemClassificationModel::getInstance()->where(['is_home' => 1])->limit(10)->select()->toArray();

        $this->assign([
            'model' => $model,
            'classification' => $classification,
            'hot_product_list' => $hotProductList,
            'item_classification' => $itemClassification,
        ]);

        return $this->fetch('productInfo');
    }

}