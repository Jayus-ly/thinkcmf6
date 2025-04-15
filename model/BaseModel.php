<?php


namespace model;

use think\Model;

class BaseModel extends Model
{
    protected $autoWriteTimestamp = true;

    protected $createTime = 'create_time';
    protected $updateTime = 'update_time';
    protected $deleteTime = 'delete_time';

    // 默认值，避免 NULL 导致查询问题
    protected $defaultSoftDelete = 0;

    protected $dateFormat = 'Y-m-d H:i:s';

}