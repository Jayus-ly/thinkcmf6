<?php


namespace model;

use think\Model;

class AdSenseModel extends Model
{
    protected $connection = "adsense";

    protected $table = "adsense";

    protected $field = "id, date, site, ad_unit_id, ad_unit_name, country,page_views,impressions matched_ad_requests, ad_requests, clicks,estimated_earnings,active_view_viewability, ad_requests_coverage, impressions_rpm, platform, update_time ";
}