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

    public function freeStuffInfo()
    {
        $param = input();

        $id = $param['id'];

        // 获取所有标签
        $tag = FreeStuffTagModel::getInstance()->select()->toArray();
        $tag = array_column($tag, null, 'id');
        // 获取文章内容
        $freeStuffInfo = FreeStuffModel::getInstance()
            ->where("id", $id)
            ->find();

        $freeStuffInfo['update_time'] = date("F d, Y", $freeStuffInfo['update_time']);

        $freeStuffTag = $freeStuffInfo['tag'];
        $freeStuffTag = explode(',', $freeStuffTag);
        $freeStuffTag = $freeStuffTag[0] ?? 0;

        $tagName = $tag[$freeStuffTag] ?? [];

        // 获取当前标签下的文章列表
        $freeStuffList = FreeStuffModel::getInstance()->whereRaw("FIND_IN_SET(?, tag)", [$freeStuffTag])->select()->toArray();
        foreach ($freeStuffList as &$value) {
            $value['update_time'] = date("F d, Y", $value['update_time']);

            // 标签数据
            $value['tag'] = explode(',', $value['tag']);
            // 筛选匹配到的 tag
            $value['tags'] = array_filter($tag, function ($item) use ($value) {
                return in_array($item['id'], $value['tag']);
            });
        }


        $this->assign(['tag' => $tag, 'free_stuff_info' => $freeStuffInfo, 'tag_name' => $tagName, 'free_stuff_list' => $freeStuffList]);

        return $this->fetch('free_stuff_info');
    }
}