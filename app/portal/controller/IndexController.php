<?php


namespace app\portal\controller;


use cmf\controller\HomeBaseController;
use model\BlogModel;
use model\CouponsModel;
use model\ItemClassificationModel;
use model\ProductModel;

class IndexController extends HomeBaseController
{

    public function index()
    {
        // 获取品牌列表
        $itemClassification = ItemClassificationModel::getInstance()->where('is_home', 1)->where('parent_id', '!=', 0)->select()->toArray();

        foreach ($itemClassification as &$value) {
            // 获取品牌的第一个优惠券内容
            $model = CouponsModel::getInstance()->where(['classification_id' => $value['id']])->find();
            $value['details'] = $model['details'] ?? '';
            $value['coupons_name'] = $model['name'] ?? '';

        }
        unset($value);

        // 获取产品列表
        $productList = ProductModel::getInstance()->where('is_home', 1)->select()->toArray();

        foreach ($productList as &$value) {
            $value['coupon_text'] = intval(($value['old_price'] - $value['new_price']) / $value['old_price'] * 100);
        }

        // 优惠券列表
        $couponsList = CouponsModel::getInstance()->where('is_home', 1)->select()->toArray();

        // 特色优惠卷


        // 分类列表
        $classificationList = ItemClassificationModel::getInstance()->where(['parent_id' => 0, 'is_home' => 1])->select()->toArray();

        // 获取博客列表
        $blog_list = BlogModel::getInstance()->where('is_home' , 1)->select()->toArray();

        $this->assign([
            'item_classification' => $itemClassification,
            'product_list' => $productList,
            'coupons_list' => $couponsList,


            'classification_list' => $classificationList,
            'blog_list' => $blog_list,
        ]);
        return $this->fetch('/index');
    }
}