<?php


namespace app\classification\controller;


use cmf\controller\AdminBaseController;
use model\CouponsModel;
use model\ItemClassificationModel;
use function Symfony\Component\Finder\in;

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


        $payment = config('common.payment_options') ?? [];

        return $this->fetch('add', ['payment' => $payment]);
    }

    public function addPost()
    {
        $param = input();
        $name = $param['name'] ?? '';
        $imgUrl = $param['img_url'] ?? '';
        $parentId = $param['parent_id'] ?? 0;

        $about = $param['about'] ?? '';
        $href = $param['href'] ?? '';
        $paymentOptions = $param['payment_options'] ?? '';
        $isHot = $param['is_hot'] ?? 0;
        if (!empty($paymentOptions)) {
            $paymentOptions = implode('/', $paymentOptions);
        }

        $model = ItemClassificationModel::getInstance();
        $model->create([
            'name' => $name,
            'img_url' => $imgUrl,
            'parent_id' => $parentId,
            'about' => $about,
            'href' => $href,
            'payment_options' => $paymentOptions,
            'is_hot' => $isHot,
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


        $payment = config('common.payment_options') ?? [];

        $data = $model->find($id)->toArray();

        $data['payment_options'] = explode('/', $data['payment_options']);
        // 获取所有顶级分类
        $array = $model->where('parent_id', ItemClassificationModel::PARENT_ID_LEVEL_TOP)
            ->where('id','!=', $id)
            ->select()->toArray();

        return $this->fetch('edit', ['data' => $data, 'array' => $array, 'parent_id' => $data['parent_id'], 'payment' => $payment]);
    }

    public function editPost()
    {
        $param = input();
        $id = $param['id'] ?? '';
        $name = $param['name'] ?? '';
        $imgUrl = $param['img_url'] ?? '';
        $parentId = $param['parent_id'] ?? '';
        $about = $param['about'] ?? '';
        $href = $param['href'] ?? '';
        $paymentOptions = $param['payment_options'] ?? '';
        $isHot = $param['is_hot'] ?? 0;
        if (!empty($paymentOptions)) {
            $paymentOptions = implode('/', $paymentOptions);
        }

        $model = ItemClassificationModel::getInstance();
        $model->where('id', $id)->update([
            'name' => $name,
            'img_url' => $imgUrl,
            'parent_id' => $parentId,
            'about' => $about,
            'href' => $href,
            'payment_options' => $paymentOptions,
            'is_hot' => $isHot,
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
        $param = input();

        if (!isset($param['classification_id']) && empty($param['classification_id'])) {
            $this->error('参数错误!');
        }

        $classificationId = $param['classification_id'] ?? 0;


        return $this->fetch('add_coupons', ['classification_id' => $classificationId]);
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
            'classification_id' => $param['classification_id'] ?? 0,
            'details' => $param['details'] ?? '',
            'used' => $param['used'] ?? '',
            'code' => $param['code'] ?? '',
            'is_new' => $param['is_new'] ?? 0,
            'is_hot' => $param['is_hot'] ?? 0,
        ]);

        // 获取模型实例（推荐使用 find 或者 select）
        $item = ItemClassificationModel::where('id', $param['classification_id'])->find();

        if ($item) {
            $item->count += 1;
            $item->save();
        }

        $this->success('操作成功');
    }


    /**
     * 优惠券列表
     * @return mixed
     */
    public function couponsList()
    {
        $param = input();

        $classificationId = $param['classification_id'] ?? 0;
        $name = $param['name'] ?? 0;

        $list = CouponsModel::getInstance()->when($name, function ($query) use ($name) {
            return $query->where('name', 'like', '%' . $name . '%');
        })->when($classificationId, function ($query) use ($classificationId) {
            return $query->where(['classification_id' => $classificationId]);
        })->select()->toArray();


        return $this->fetch('coupons_list', ['list' => $list]);
    }

    public function couponsEdit()
    {
        $param = input();

        $id = $param['id'] ?? '';

        if (empty($id)) {
            $this->error('参数错误');
        }

        $model = CouponsModel::getInstance();


        $data = $model->find($id)->toArray();

        return $this->fetch('edit_coupons', ['data' => $data]);
    }

    public function editCouponsPost()
    {
        $param = input();
        $id = $param['id'] ?? 0;

        if (empty($id)) {
            $this->error('参数错误');
        }
        $model = CouponsModel::getInstance();

        $model->where('id', $id)->update([
            'name' => $param['name'] ?? '',
            'type' => $param['type'] ?? '',
//            'classification_id' => $param['classification_id'] ?? '',
            'details' => $param['details'] ?? '',
            'used' => $param['used'] ?? '',
            'code' => $param['code'] ?? '',
            'is_new' => $param['is_new'] ?? 0,
            'is_hot' => $param['is_hot'] ?? 0,
        ]);

        $this->success('更新成功', url("couponsList"));
    }

    /**
     * 删除优惠券
     */
    public function couponsDeletePost()
    {
        $param = input();
        $id = $param['id'] ?? 0;
        if (empty($id)) {
            $this->error('参数错误');
        }
        $model = CouponsModel::getInstance();

        $model->where('id', $id)->delete();
        $this->success('删除成功');
    }


    public function changItemClassificationIsHome()
    {
        $param = input();
        $id = $param['id'] ?? 0;
        $isHome = $param['is_home'] ?? 0;


        ItemClassificationModel::getInstance()->where('id', $id)->update([
            'is_home' => $isHome
        ]);


        $this->result(true, 1, 'success', 'json'); // 参数含义：数据、状态码、消息
    }

    public function changCouponsIsHome()
    {
        $param = input();
        $id = $param['id'] ?? 0;
        $isHome = $param['is_home'] ?? 0;

        CouponsModel::getInstance()->where('id', $id)->update([
            'is_home' => $isHome
        ]);

        $this->result(true, 1, 'success', 'json'); // 参数含义：数据、状态码、消息
    }
}