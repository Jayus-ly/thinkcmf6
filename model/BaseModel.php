<?php


namespace model;

use think\Model;

class BaseModel extends Model
{
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