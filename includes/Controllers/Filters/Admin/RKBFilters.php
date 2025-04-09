<?php
namespace BKBRKB\Controllers\Filters\Admin;

use Xenioushk\BwlPluginApi\Api\Filters\FiltersApi;
use BKBRKB\Callbacks\Filters\Admin\QueryFilterCb;

/**
 * Class for registering the admin filters.
 *
 * @since: 1.1.5
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
        $query_filter_cb = new QueryFilterCb();

        // Filters.
        $filters = [
            [
                'tag'      => 'parse_query',
                'callback' => [ $query_filter_cb, 'apply' ],
                'priority' => 11,
            ],
        ];

        $filters_api->add_filters( $filters )->register();
    }
}
