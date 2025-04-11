<?php


namespace app\classification\controller;


use model\FreeStuffModel;
use model\FreeStuffTagModel;
use think\App;

class ArticleController extends BaseController
{
    public function __construct(App $app)
    {
        parent::__construct($app);
        $this->model = FreeStuffModel::getInstance();
    }

    public function freeStuffList()
    {
        $this->list();
        return $this->fetch();
    }

    public function addFreeStuff()
    {
        // 获取文章标签列表
        $tags = FreeStuffTagModel::getInstance()->select()->toArray();

        $this->assign(['tags' => $tags]);
        return $this->add('add_free_stuff');
    }

    public function editFreeStuff()
    {
        // 获取文章标签列表
        $tags = FreeStuffTagModel::getInstance()->select()->toArray();

        $this->assign(['tags' => $tags]);

        $param = input();
        $id = $param['id'] ?? '';
        if (empty($id)) {
            $this->error('参数错误');
        }

        $data = $this->model->find($id)->toArray();
        $data['tag'] = explode(',', $data['tag']);
        return $this->fetch('edit_free_stuff', ['data' => $data]);
    }

    public function addFreeStuffPost()
    {
        $param = input();

        $param['tag'] = implode(',', $param['tag'] ?? []);

        $this->setName('freeStuffList')->addPost($param);
    }

    public function editFreeStuffPost()
    {
        $param = input();

        $param['tag'] = implode(',', $param['tag'] ?? []);
        $this->setName('freeStuffList')->editPost($param);
    }

    public function tagList()
    {
        $this->setModel(FreeStuffTagModel::getInstance())->list();
        return $this->fetch();
    }

    public function addTag()
    {
        return $this->add('add_tag');
    }

    public function editTag()
    {
        return $this->setModel(FreeStuffTagModel::getInstance())->setName('edit_tag')->edit();
    }

    public function addTagPost()
    {
        $param = input();
        $this->setModel(FreeStuffTagModel::getInstance())->setName('tagList')->addPost($param);
    }

    public function editTagPost()
    {
        $this->setModel(FreeStuffTagModel::getInstance())->setName('tagList')->editPost();
    }

    public function delTag()
    {
        $this->setModel(FreeStuffTagModel::getInstance())->delPost();
    }
}