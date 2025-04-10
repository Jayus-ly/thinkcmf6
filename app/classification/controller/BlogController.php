<?php


namespace app\classification\controller;


use cmf\controller\AdminBaseController;
use model\BlogModel;
use model\ItemClassificationModel;

class BlogController extends AdminBaseController
{

    public function index()
    {
        $param = input();
        $name = $param['name'] ?? '';

        $pageNum = $param['page'] ?? config('common.default_page_num');
        $pageSize = $param['size'] ?? config('common.default_page_size');

        $model = BlogModel::getInstance();

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

        return $this->fetch();
    }

    /**
     * 跳转新增产品分类页面
     * @return mixed
     */
    public function addBlog()
    {
        // 获取品牌列表
        $array = ItemClassificationModel::getInstance()->where('parent_id', 1)->select()->toArray();

        $this->assign('array', $array);
        return $this->fetch('add_blog');
    }

    /**
     * 新增产品分类
     */
    public function addBlogPost()
    {
        $param = input();
        $title = $param['title'] ?? '';
        $subtitle = $param['subtitle'] ?? '';
        $about = $param['about'] ?? '';
        $img_url = $param['img_url'] ?? '';
        $bind_item_classification = $param['bind_item_classification'] ?? '';
        if ($bind_item_classification) {
            $bind_item_classification = implode(',', $bind_item_classification);
        }

        $model = BlogModel::getInstance();

        $model->create([
            'title' => $title,
            'subtitle' => $subtitle,
            'about' => $about,
            'img_url' => $img_url,
            'bind_item_classification' => $bind_item_classification,
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
    public function editBlog()
    {
        $param = input();
        $id = $param['id'] ?? '';
        if (empty($id)) {
            $this->error('参数错误');
        }
        $model = BlogModel::getInstance();

        $data = $model->find($id)->toArray();
        $data['bind_item_classification'] = explode(',', $data['bind_item_classification']);

        $array = ItemClassificationModel::getInstance()->where('parent_id', 1)->select()->toArray();

        $this->assign('array', $array);

        return $this->fetch('edit_blog', ['data' => $data]);
    }

    /**
     * 修改产品分类
     */
    public function editBlogPost()
    {
        $param = input();
        $id = $param['id'] ?? '';
        $title = $param['title'] ?? '';
        $subtitle = $param['subtitle'] ?? '';
        $about = $param['about'] ?? '';
        $img_url = $param['img_url'] ?? '';
        $bind_item_classification = $param['bind_item_classification'] ?? '';

        if ($bind_item_classification) {
            $bind_item_classification = implode(',', $bind_item_classification);
        }

        $model = BlogModel::getInstance();

        $model->where('id', $id)->update([
            'title' => $title,
            'subtitle' => $subtitle,
            'about' => $about,
            'img_url' => $img_url,
            'bind_item_classification' => $bind_item_classification,
        ]);

        $this->success('创建成功', url("index"));
    }

    /**
     * 删除产品分类
     */
    public function delBlogPost()
    {
        $param = input();
        $id = $param['id'] ?? 0;
        if (empty($id)) {
            $this->error('参数错误');
        }
        $model = BlogModel::getInstance();

        $model->where('id', $id)->delete();
        $this->success('删除成功');
    }

    public function changBlogIsHome()
    {
        $param = input();
        $id = $param['id'] ?? 0;
        $isHome = $param['is_home'] ?? 0;


        BlogModel::getInstance()->where('id', $id)->update([
            'is_home' => $isHome
        ]);

        $this->result(true, 1, 'success', 'json'); // 参数含义：数据、状态码、消息
    }
}