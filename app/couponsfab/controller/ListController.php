<?php


namespace app\couponsfab\controller;


use cmf\controller\HomeBaseController;
use model\ItemClassificationModel;

class ListController extends HomeBaseController
{

    public function list()
    {
        $param = input();

        $active = $param['active'] ?? 0;
        $name = $param['name'] ?? 'All Brands';

        $model = ItemClassificationModel::getInstance();

        // 获取分类
        $classification = $model->where(['parent_id' => ItemClassificationModel::PARENT_ID_LEVEL_TOP])
            ->select()
            ->toArray();

        return $this->fetch('brandList', [
            'classification' => $classification,
            'active' => $active,
            'name' => $name
        ]);
    }

    public function brandListPage()
    {
        $param = input();
        $model = ItemClassificationModel::getInstance();

        $active = $param['active'] ?? 0;
        $pageNum = $param['page'] ?? config('common.default_page_num');
        $pageSize = $param['size'] ?? config('common.default_page_size');
        $startStr = $param['startStr'] ?? '';

        $sql = $model->where('parent_id', '!=', ItemClassificationModel::PARENT_ID_LEVEL_TOP)
            ->when($startStr, function ($query) use ($startStr) {
                $query->where('name', 'like', $startStr . '%');
            });

        $count = $sql->count();

        $list = $sql->field(['id as Route', 'name as Name', 'count as CouponNum', 'img_url as ImgUrl'])
            ->when($active, function ($query) use ($active) {
                return $query->where('parent_id', $active);
            })
            ->page($pageNum, $pageSize)
            ->order('parent_id', 'asc')
            ->order('id', 'desc')
            ->select()->toArray();

        foreach ($list as &$value) {
            $value['ImgUrl'] = cmf_get_image_url($value['ImgUrl']);
        }
        $this->result(['PageCount' => $count, 'BrandList' => $list], 1, 'success', 'json'); // 参数含义：数据、状态码、消息
    }
}