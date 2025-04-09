<?php


namespace model;


class ItemClassificationModel extends BaseModel
{
    protected $table = "cmf_item_classification";

    protected $field = ['id', 'name', 'img_url', 'parent_id', 'count', 'href', 'faq', 'about', 'payment_options', 'create_time', 'update_time', 'delete_time'];

    const PARENT_ID_LEVEL_TOP = 0; // 顶级分类
}