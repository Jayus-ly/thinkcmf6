<?php


namespace model;

/**
 * 优惠券
 * Class CouponsModel
 * @package model
 */
class CouponsModel extends BaseModel
{
    protected $table = "cmf_coupons";

    protected $field = ['id', 'classification_id', 'name', 'type', 'used', 'details', 'create_time', 'update_time', 'delete_time'];
}