<?php


namespace app\couponsfab\controller;


use cmf\controller\HomeBaseController;
use model\CouponsModel;
use model\ItemClassificationModel;
use model\ProductModel;

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

        // 获取支付分类
        $paymentOptions = $model['payment_options'] ?? '';
        if (!empty($paymentOptions)) {
            $paymentOptions = explode('/', $paymentOptions);
        }

        // 获取该品牌关联的商品
        $productList = ProductModel::getInstance()->where('item_classification_id', $id)->select()->toArray();
        foreach ($productList as &$value) {
            $value['coupon_text'] = ($value['new_price'] - $value['old_price']) / $value['new_price'] * 100;
        }
        unset($value);

        // 获取该品牌的优惠券
        $couponsList = CouponsModel::getInstance()
            ->page(1, 5)
            ->where('classification_id', $id)
            ->select()
            ->toArray();


        $this->assign([
            'data' => $model,
            'classification' => $classification,
            'id' => $id,
            'payment_options' => $paymentOptions,
            'product_list' => $productList,
            'coupons_list' => $couponsList
        ]);

        return $this->fetch('info');
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


        $this->result(['PageCount' => $count, 'Coupons' => $coupons], 1, 'success', 'json');
    }


    public function getProductListPost()
    {
        $param = input();
        $id = $param['id'] ?? 0;

        $pageNum = $param['page'] ?? config('common.default_page_num');
        $pageSize = $param['size'] ?? config('common.default_page_size');

        // 获取品牌优惠券列表
        $sql = ProductModel::getInstance()
            ->where('is_hot', 1)->whereOr('is_home', 1);

        $count = $sql->count();
        
        $productList = $sql->page($pageNum, $pageSize)
            ->select()
            ->toArray();

        foreach ($productList as &$value) {
            $value['img_url'] = cmf_get_image_preview_url($value['img_url']);
        }
        unset($value);
        $this->result(['count' => $count, 'product_list' => $productList], 1, 'success', 'json');
    }
}