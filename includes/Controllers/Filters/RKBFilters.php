<?php
namespace BKBRKB\Controllers\Filters;

use BKBRKB\Callbacks\Filters\TitleCb;
use BKBRKB\Callbacks\Filters\BlogFilterCb;
use BKBRKB\Callbacks\Filters\SearchFilterCb;
use BKBRKB\Callbacks\Filters\QueryFilterCb;
use BKBRKB\Callbacks\Filters\PostAccessCb;
use BKBRKB\Callbacks\Filters\ModifyTaxonomyCb;
use Xenioushk\BwlPluginApi\Api\Filters\FiltersApi;

/**
 * Class for registering the frontend filters.
 *
 * @since: 1.1.0
 * @package BKBRKB
 */
class RKBFilters {

    /**
	 * Register filters.
	 */
    public function register() {

        // Initialize API.
        $filters_api = new FiltersApi();

        // Initialize callbacks.
        $title_cb           = new TitleCb();
        $blog_filter_cb     = new BlogFilterCb();
        $search_filter_cb   = new SearchFilterCb();
        $query_filter_cb    = new QueryFilterCb();
        $post_access_cb     = new PostAccessCb();
        $modify_taxonomy_cb = new ModifyTaxonomyCb();

        // All filters.
        $filters = [
            [
                'tag'      => 'bkb_rkb_post_access',
                'callback' => [ $post_access_cb, 'check_status' ],
            ],
            [
                'tag'      => 'the_content',
                'callback' => [ $modify_taxonomy_cb, 'modify_exceprt' ],
            ],
            [
                'tag'      => 'custom_rkb_title',
                'callback' => [ $title_cb, 'modify' ],
            ],
            [
                'tag'      => 'bkb_rkb_query_filter',
                'callback' => [ $query_filter_cb, 'apply' ],
            ],
            [
                'tag'      => 'bkb_rkb_blog_query_filter',
                'callback' => [ $blog_filter_cb, 'apply' ],
            ],
            [
                'tag'      => 'bkb_rkb_search_query_filter',
                'callback' => [ $search_filter_cb, 'apply' ],
            ],
        ];

        $filters_api->add_filters( $filters )->register();
    }
}
