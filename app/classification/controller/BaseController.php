<?php


namespace app\classification\controller;


use cmf\controller\AdminBaseController;

class BaseController extends AdminBaseController
{
    public $model = null;

    public static $name = '';

    public function setName($name)
    {
        self::$name = $name;
        return $this;
    }

    public function setModel($model)
    {
        $this->model = $model;
        return $this;
    }

    public function add($name = '')
    {
        if (!empty($name)) {
            return $this->fetch($name);
        }
        return $this->fetch('add');
    }

    public function edit()
    {
        $param = input();
        $id = $param['id'] ?? '';
        if (empty($id)) {
            $this->error('参数错误');
        }

        $data = $this->model->find($id)->toArray();
        $this->assign(['data' => $data]);

        if (!empty(self::$name)) {
            return $this->fetch(self::$name);
        }
        return $this->fetch('edit');
    }

    public function addPost($param = [])
    {
        if (empty($param)) {
            $param = input();
        }
        $this->model->create($param);

        if (!empty(self::$name)) {
            $this->success('创建成功', url(self::$name));
        }
        $this->success('创建成功', url("index"));
    }

    public function editPost($param = [])
    {
        if (empty($param)) {
            $param = input();
        }

        $id = $param['id'] ?? '';

        $this->model->where('id', $id)->update($param);

        if (!empty(self::$name)) {
            $this->success('修改成功', url(self::$name));
        }
        $this->success('修改成功', url("index"));
    }

    public function delPost()
    {
        $param = input();
        $id = $param['id'] ?? 0;
        if (empty($id)) {
            $this->error('参数错误');
        }
        $this->model->where('id', $id)->delete();
        $this->success('删除成功');
    }

    public function list()
    {
        $list = $this->model->order('id', 'asc')->select()->toArray();

        $this->assign('list', $list);
    }
}