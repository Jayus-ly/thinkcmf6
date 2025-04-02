<?php


namespace model;

/**
 * 公共配置表
 * Class CommonConfigModel
 * @package model
 */
class CommonConfigModel extends BaseModel
{
    protected $connection = "adsense";

    protected $table = "common_config";

    protected $field = "id, name, content";

    /**
     * 获取配置信息
     * @param string $name
     * @return array|\think\Collection|\think\db\BaseQuery[]
     */
    public function getCommonConfig($name = "")
    {
        return self::getInstance()
            ->when($name, function ($query) use($name) {
                $query->where('name', $name);
            })
            ->select();
    }
}