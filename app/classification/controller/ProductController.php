<?php


namespace app\classification\controller;


use cmf\controller\AdminBaseController;
use model\ProductClassificationModel;
use model\ProductModel;

class ProductController extends AdminBaseController
{
    /**
     * 产品分类列表
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
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

    /**
     * 跳转新增产品分类页面
     * @return mixed
     */
    public function addProductClassification()
    {
        return $this->fetch('add_product_classification');
    }

    /**
     * 新增产品分类
     */
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

    /**
     * 跳转产品分类页面
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
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

    /**
     * 修改产品分类
     */
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

    /**
     * 删除产品分类
     */
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


    /**
     * 产品列表
     */
    public function productList()
    {
        $param = input();
        $name = $param['name'] ?? '';

        $model = ProductModel::getInstance();
        $sql = $model->when($name, function ($query) use ($name) {
            // 根据 ~ 分割
            $query->where('name', $name);
        });

        $count = $sql->count();

        $list = $sql
            ->order('id', 'asc')
            ->select()->toArray();

        $this->assign('list', $list);

        return $this->fetch('product_list');
    }


    /**
     * 跳转新增产品页面
     * @return mixed
     */
    public function addProduct()
    {
        return $this->fetch('add_product');
    }

    /**
     * 新增产品
     */
    public function addProductPost()
    {
        $param = input();
        $name = $param['name'] ?? '';
        $imgUrl = $param['img_url'] ?? '';
        $newPrice = $param['new_price'] ?? '';
        $oldPrice = $param['old_price'] ?? '';
        $classificationId = $param['classification_id'] ?? '';
        $isHot = $param['is_hot'] ?? '';

        $model = ProductModel::getInstance();

        $model->create([
            'name' => $name,
            'img_url' => $imgUrl,
            'new_price' => $newPrice,
            'old_price' => $oldPrice,
            'classification_id' => $classificationId,
            'is_hot' => $isHot,
        ]);

        $this->success('创建成功', url("productList"));
    }

    /**
     * 跳转产品页面
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function editProduct()
    {
        $param = input();
        $id = $param['id'] ?? '';
        if (empty($id)) {
            $this->error('参数错误');
        }
        $model = ProductModel::getInstance();

        $data = $model->find($id)->toArray();

        return $this->fetch('edit_product', ['data' => $data]);
    }

    /**
     * 修改产品
     */
    public function editProductPost()
    {
        $param = input();
        $id = $param['id'] ?? '';
        $name = $param['name'] ?? '';
        $imgUrl = $param['img_url'] ?? '';
        $newPrice = $param['new_price'] ?? '';
        $oldPrice = $param['old_price'] ?? '';
        $classificationId = $param['classification_id'] ?? '';
        $isHot = $param['is_hot'] ?? '';

        $model = ProductModel::getInstance();

        $model->where('id', $id)->update([
            'name' => $name,
            'img_url' => $imgUrl,
            'new_price' => $newPrice,
            'old_price' => $oldPrice,
            'classification_id' => $classificationId,
            'is_hot' => $isHot,
        ]);

        $this->success('创建成功', url("productList"));
    }

    /**
     * 删除产品
     */
    public function delProductPost()
    {
        $param = input();
        $id = $param['id'] ?? 0;
        if (empty($id)) {
            $this->error('参数错误');
        }
        $model = ProductModel::getInstance();

        $model->where('id', $id)->delete();
        $this->success('删除成功');
    }
}