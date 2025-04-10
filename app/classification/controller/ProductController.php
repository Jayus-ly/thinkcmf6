<?php


namespace app\classification\controller;


use cmf\controller\AdminBaseController;
use model\ItemClassificationModel;
use model\ProductClassificationModel;

class ProductController extends AdminBaseController
{

    public function index()
    {
        $param = input();
        $name = $param['name'] ?? '';

        $model = ProductClassificationModel::getInstance();
        $sql = $model->when($name, function ($query) use ($name) {
            // 根据 ~ 分割
            $query->where('name', $name);
        });
        $count = $sql->count();

        $list = $sql
            ->order('id', 'asc')
            ->select()->toArray();

//        $this->assign('count', $count);
//        $this->assign('page', $pageNum);
        $this->assign('list', $list);

        return $this->fetch('product_classification_list');
    }

    public function addProductClassification()
    {
        return $this->fetch('add_product_classification');
    }

    public function addProductClassificationPost()
    {
        $param = input();
        $name = $param['name'] ?? '';
        $imgUrl = $param['img_url'] ?? '';

        $model = ProductClassificationModel::getInstance();

        $model->create([
            'name' => $name,
            'img_url' => $imgUrl,
        ]);

        $this->success('创建成功', url("index"));
    }

    public function editProductClassification()
    {
        $param = input();
        $id = $param['id'] ?? '';
        if (empty($id)) {
            $this->error('参数错误');
        }
        $model = ProductClassificationModel::getInstance();

        $data = $model->find($id)->toArray();

        return $this->fetch('edit_product_classification', ['data' => $data]);
    }

    public function editProductClassificationPost()
    {
        $param = input();
        $id = $param['id'] ?? '';
        $name = $param['name'] ?? '';
        $imgUrl = $param['img_url'] ?? '';

        $model = ProductClassificationModel::getInstance();

        $model->where('id', $id)->update([
            'name' => $name,
            'img_url' => $imgUrl,
        ]);

        $this->success('创建成功', url("index"));
    }

    public function delProductClassificationPost()
    {
        $param = input();
        $id = $param['id'] ?? 0;
        if (empty($id)) {
            $this->error('参数错误');
        }
        $model = ProductClassificationModel::getInstance();

        $model->where('id', $id)->delete();
        $this->success('删除成功');
    }

}