<?php


namespace app\classification\controller;


use cmf\controller\AdminBaseController;
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

        $list = $sql->page($pageNum, $pageSize)
            ->order('id', 'desc')
            ->select();

        $this->assign('count', $count);
        $this->assign('page', $pageNum);
        $this->assign('list', $list);

        return $this->fetch();
    }

    public function add()
    {
        return $this->fetch('add');
    }

    public function addPost()
    {
        $param = input();
        $name = $param['name'] ?? '';
        $imgUrl = $param['img_url'] ?? '';

        $model = ItemClassificationModel::getInstance();
        $model->create([
            'name' => $name,
            'img_url' => $imgUrl
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


}