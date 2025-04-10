<?php


namespace model;


class ItemClassificationModel extends BaseModel
{
    protected $table = "cmf_item_classification";

    protected $field = ['id', 'name', 'img_url', 'parent_id', 'count', 'href', 'faq', 'about', 'payment_options', 'create_time', 'update_time', 'delete_time', 'is_hot', 'is_home'];

    const PARENT_ID_LEVEL_TOP = 0; // 顶级分类

    // 静态实例
    protected static $instance = null;

    /**
     * 获取模型的单例实例
     * @return static
     */
    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new static();
        }
        return self::$instance;
    }
}