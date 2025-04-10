<?php


namespace app\couponsfab\controller;


use cmf\controller\HomeBaseController;
use model\ProductClassificationModel;
use model\ProductModel;

class ProductListController extends HomeBaseController
{

    /**
     * 商品列表
     * @return mixed|string
     * /couponsfab/productList/list
     */
    public function list()
    {
        $param = input();
        $classification_id = $param['classification_id'] ?? 0;

        $model = ProductClassificationModel::getInstance()->find($classification_id);

        // 获取商品分类
        $productClassification = ProductClassificationModel::getInstance()->select()->toArray();
        // 获取商品列表

        $this->assign('product_classification', $productClassification);
        $this->assign('model', $model);
        $this->assign('classification_id', $classification_id);

        return $this->fetch('productList');
    }

    /**
     * 获取商品列表分页
     */
    public function getProductListPost()
    {
        $param = input();

        $classification_id = $param['classification_id'] ?? 0;

        $pageNum = $param['page'] ?? config('common.default_page_num');
        $pageSize = $param['size'] ?? config('common.default_page_size');

        // 获取品牌优惠券列表
        $sql = ProductModel::getInstance()->when($classification_id, function ($query) use ($classification_id) {
           return $query->where('classification_id', $classification_id);
        });

        $count = $sql->count();

        $coupons = $sql->page($pageNum, $pageSize)
            ->select()
            ->toArray();
        foreach ($coupons as &$value) {
            $value['img_url'] = cmf_get_image_preview_url($value['img_url']);
        }
        unset($value);
        $this->result(['PageCount' => $count, 'Coupons' => $coupons], 1, 'success', 'json');
    }
}