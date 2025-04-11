<?php


namespace model;

use think\Exception;

class FreeStuffModel extends BaseModel
{
    protected $table = "cmf_free_stuff";

    protected $field = ['id', 'title', 'img_url', 'tag', 'content', 'create_time', 'update_time', 'delete_time', 'href'];

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