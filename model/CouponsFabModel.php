<?php


namespace model;

use think\model\concern\SoftDelete;

class CouponsFabModel extends BaseModel
{
    use SoftDelete;

    protected $connection = "adsense";

    protected $table = "couponsfab";

    protected $field = ['id', 'type', 'url', 'name', 'detail', 'sales', 'sort', 'create_time', 'update_time', 'delete_time',];

    const TYPE_CAROUSEL = 0; // 首页轮播图
    const TYPE_TODAY_TOP_COUPONS = 1; // Today's Top Coupons
    const TYPE_POPULAR_PRODUCTS = 2; // Popular Products
    const TYPE_FEATURED_COUPONS = 3; // Featured Coupons
    const TYPE_HOT_CATEGORIES = 4; // Hot Categories
    const TYPE_LATEST_BLO = 5; // Latest Blog
    const TYPE_FREQUENTLY_ASKED_QUESTIONS = 6; // Frequently Asked Questions
    const TYPE_ABOUT_COUPONS_FAB = 7; // About CouponsFab

    const TYPE_ARRAY = [self::TYPE_CAROUSEL, self::TYPE_TODAY_TOP_COUPONS, self::TYPE_POPULAR_PRODUCTS, self::TYPE_FEATURED_COUPONS, self::TYPE_HOT_CATEGORIES, self::TYPE_LATEST_BLO, self::TYPE_FREQUENTLY_ASKED_QUESTIONS, self::TYPE_ABOUT_COUPONS_FAB,];

    const TYPE_ARRAY_INFO = [
        self::TYPE_CAROUSEL => 'type_carousel',
        self::TYPE_TODAY_TOP_COUPONS => 'type_today_top_coupons',
        self::TYPE_POPULAR_PRODUCTS => 'type_popular_products',
        self::TYPE_FEATURED_COUPONS => 'type_featured_coupons',
        self::TYPE_HOT_CATEGORIES => 'type_hot_categories',
        self::TYPE_LATEST_BLO => 'type_latest_blo',
        self::TYPE_FREQUENTLY_ASKED_QUESTIONS => 'type_frequently_asked_questions',
        self::TYPE_ABOUT_COUPONS_FAB => 'type_about_coupons_fab',
    ];

    public function getByType($type = 0)
    {
        return self::getInstance()->where('type', $type)->select()->toArray();
    }
}