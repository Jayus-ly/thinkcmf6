<?php


namespace app\classification\controller;


use cmf\controller\AdminBaseController;
use model\FootContentModel;
use think\App;

class AboutController extends AdminBaseController
{

    public ?FootContentModel $model = null;

    public function __construct(App $app)
    {
        parent::__construct($app);

        $this->model = FootContentModel::getInstance();

    }

    public function index()
    {
        $param = input();
        $name = $param['name'] ?? '';

        $pageNum = $param['page'] ?? config('common.default_page_num');
        $pageSize = $param['size'] ?? config('common.default_page_size');


        $sql = $this->model->when($name, function ($query) use ($name) {
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

        return $this->fetch();
    }


    /**
     * 跳转新增
     * @return mixed
     */
    public function add()
    {
        return $this->fetch('add');
    }

    /**
     * 新增
     */
    public function addPost()
    {
        $param = input();
        $name = $param['name'] ?? '';
        $content = $param['content'] ?? '';

        $model = $this->model->where('name', $name)->find();
        if (empty($model)) {
            $this->model->create([
                'name' => $name,
                'content' => $content,
            ]);

            $this->success('创建成功', url("index"));
        }

        $this->model->where('name', $name)->update([
            'content' => $content,
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
    public function edit()
    {
        $param = input();
        $id = $param['id'] ?? '';
        if (empty($id)) {
            $this->error('参数错误');
        }

        $data = $this->model->find($id)->toArray();

        return $this->fetch('edit', ['data' => $data]);
    }

    /**
     * 修改产品分类
     */
    public function editPost()
    {
        $param = input();
        $id = $param['id'] ?? '';
        $name = $param['name'] ?? '';
        $content = $param['content'] ?? '';


        $this->model->where('id', $id)->update([
            'name' => $name,
            'content' => $content,
        ]);

        $this->success('创建成功', url("index"));
    }

    /**
     * 删除产品分类
     */
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
}