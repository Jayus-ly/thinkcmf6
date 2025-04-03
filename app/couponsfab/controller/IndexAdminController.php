<?php


namespace app\couponsfab\controller;


use cmf\controller\AdminBaseController;
use model\CommonConfigModel;
use model\CouponsFabModel;

/**
 * 后台页面
 * Class IndexAdminController
 * @package app\couponsfab\controller
 */
class IndexAdminController extends AdminBaseController
{

    public function index()
    {
        return $this->fetch();
    }

    public function getCarouselData()
    {
        $param = input();

        if (!isset($param['type'])) {
            $this->error('参数错误');
        }

        $model = CouponsFabModel::getInstance()
            ->where('type', $param['type'] ?? 0)
            ->select();

        $this->success('获取成功', null, $model);
    }

    /**
     * 跳转新增轮播图页面
     * @return mixed
     */
    public function addCarouselView()
    {
        return $this->fetch('index_admin/add_carousel');
    }

    /**
     * 新增轮播图
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function addCarousel()
    {
        $param = input();

        // 获取图片
        $image = $param['image'] ?? '';
        $name = $param['name'] ?? '';
        $detail = $param['detail'] ?? '';
        $sort = $param['sort'] ?? 0;

        if (empty($image)) {
            $this->error('图片不能为空');
        }

        // 本地存储图片  根据图片路径判断图片是否存在
        $fileExists = file_exists($_SERVER['DOCUMENT_ROOT']. '/upload/' . $image);
        if (!$fileExists) {
            $this->error('图片上传失败');
        } else {
            $image = '/upload/' . $image;
        }

        CouponsFabModel::getInstance()->create([
            'type' => CouponsFabModel::TYPE_CAROUSEL,
            'url' => $image,
            'name' => $name,
            'detail' => $detail,
            'sales' => 0,
            'sort' => $sort,
        ]);

        $this->success('新增图片成功');
    }

    /**
     * 删除首页轮播图
     */
    public function delCarousel()
    {
        $param = input();

        $id = $param['id'] ?? '';
        if (empty($id)) {
            $this->error('参数错误');
        }
        CouponsFabModel::getInstance()->destroy($id);

        $this->success('操作成功');
    }

    /**
     * 新增首页每日热门图片
     * @return mixed
     */
    public function addTodayTopCoupons()
    {
        return $this->fetch('index_admin/add_today_top_coupons');
    }
}