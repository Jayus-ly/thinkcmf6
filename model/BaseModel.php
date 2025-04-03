<?php


namespace model;

use think\Model;

class BaseModel extends Model
{
    // 静态实例
    protected static $instance = null;

    protected $autoWriteTimestamp = true;

    protected $createTime = 'create_time';
    protected $updateTime = 'update_time';
    protected $deleteTime = 'delete_time';

    // 默认值，避免 NULL 导致查询问题
    protected $defaultSoftDelete = 0;

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