<?php


namespace app\classification\controller;


use cmf\controller\AdminBaseController;
use model\CouponsModel;
use model\ItemClassificationModel;

class IndexController extends AdminBaseController
{
    public function index()
    {
        $param = input();
        $name = $param['name'] ?? '';

        $pageNum = $param['page'] ?? config('common.default_page_num');
        $pageSize = $param['size'] ?? config('common.default_page_size');

        $model = ItemClassificationModel::getInstance();

        $sql = $model->when($name, function ($query) use ($name) {
            // 根据 ~ 分割
            $query->where('name', $name);
        });

        $count = $sql->count();

        $list = $sql
            ->order('parent_id', 'asc')
            ->order('id', 'asc')
            ->select()->toArray();

//        $this->assign('count', $count);
//        $this->assign('page', $pageNum);
        $this->assign('list', $list);

        return $this->fetch();
    }

    public function add()
    {
        $param = input();
        $parentId = $param['parent_id'] ?? 0;
        $this->assign('parent_id', $parentId);
        return $this->fetch('add');
    }

    public function addPost()
    {
        $param = input();
        $name = $param['name'] ?? '';
        $imgUrl = $param['img_url'] ?? '';
        $parentId = $param['parent_id'] ?? 0;


        $model = ItemClassificationModel::getInstance();
        $model->create([
            'name' => $name,
            'img_url' => $imgUrl,
            'parent_id' => $parentId
        ]);
        $this->success('创建成功', url("index"));
    }

    public function edit()
    {
        $param = input();
        $id = $param['id'] ?? '';
        if (empty($id)) {
            $this->error('参数错误');
        }

        $model = ItemClassificationModel::getInstance();


        $data = $model->find($id)->toArray();

        // 获取所有顶级分类
        $array = $model->where('parent_id', ItemClassificationModel::PARENT_ID_LEVEL_TOP)
            ->where('id','!=', $id)
            ->select()->toArray();

        return $this->fetch('edit', ['data' => $data, 'array' => $array]);
    }

    public function editPost()
    {
        $param = input();
        $id = $param['id'] ?? '';
        $name = $param['name'] ?? '';
        $imgUrl = $param['img_url'] ?? '';
        $parentId = $param['parent_id'] ?? '';

        $model = ItemClassificationModel::getInstance();
        $model->where('id', $id)->update([
            'name' => $name,
            'img_url' => $imgUrl,
            'parent_id' => $parentId
        ]);
        $this->success('更新成功', url("index"));
    }

    public function delete()
    {
        $param = input();
        $id = $param['id'] ?? 0;
        if (empty($id)) {
            $this->error('参数错误');
        }
        $model = ItemClassificationModel::getInstance();

        $model->where('id', $id)->delete();
        $this->success('删除成功');
    }


    public function addCoupons()
    {
        return $this->fetch('add_coupons');
    }

    /**
     * 新增优惠券
     */
    public function addCouponsPost()
    {
        $param = input();
        if (!isset($param['classification_id']) && empty($param['classification_id'])) {
            $this->error('参数错误!');
        }
        $model = CouponsModel::getInstance();
        $model->create([
            'name' => $param['name'] ?? '',
            'type' => $param['type'] ?? '',
            'classification_id' => $param['classification_id'] ?? '',
            'details' => $param['details'] ?? '',
            'used' => $param['used'] ?? '',
        ]);
        $this->success('操作成功');
    }
}