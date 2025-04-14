<?php


namespace app\couponsfab\controller;


use cmf\controller\HomeBaseController;
use model\FreeStuffModel;
use model\FreeStuffTagModel;

class ArticleController extends HomeBaseController
{

    public function freeStuffList()
    {
        $param = input();

        $tagId = $param['tag'] ?? 0;
        $name = $param['name'] ?? 'Free Stuff';


        // 获取所有标签
        $tag = FreeStuffTagModel::getInstance()->select()->toArray();

        // 获取文章内容
        $freeStuffList = FreeStuffModel::getInstance()
            ->when($tagId, function ($query) use ($tagId) {
                return $query->whereRaw("FIND_IN_SET(?, tag)", [$tagId]);
            })
            ->select()
            ->toArray();
        foreach ($freeStuffList as &$value) {
            $value['update_time'] = date("F d, Y", $value['update_time']);

            // 标签数据
            $value['tag'] = explode(',', $value['tag']);
            // 筛选匹配到的 tag
            $value['tags'] = array_filter($tag, function ($item) use ($value) {
                return in_array($item['id'], $value['tag']);
            });

        }
        unset($value);


        $this->assign(['tag' => $tag, 'free_stuff_list' => $freeStuffList, 'name' => $name]);
        return $this->fetch('free_stuff_list');
    }
}