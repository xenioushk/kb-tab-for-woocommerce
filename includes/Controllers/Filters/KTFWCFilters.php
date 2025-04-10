<?php
namespace KTFWC\Controllers\Filters;

use Xenioushk\BwlPluginApi\Api\Filters\FiltersApi;

use KTFWC\Callbacks\Filters\ProductTabCb;

/**
 * Class for registering the frontend filters.
 *
 * @since: 1.1.0
 * @package KTFWC
 * @note:  add_filter( 'kbtfw_woocommerce_custom_product_tabs_content', 'do_shortcode' );
 */
class KTFWCFilters {

    /**
	 * Register filters.
	 */
    public function register() {

        // Initialize API.
        $filters_api = new FiltersApi();

        // Initialize callbacks.
        $product_tab_cb = new ProductTabCb();

        // All filters.
        $filters = [
            [
                'tag'      => 'woocommerce_product_tabs',
                'callback' => [ $product_tab_cb, 'get_the_tab' ],
            ],
            [
                'tag'      => 'kbtfw_woocommerce_custom_product_tabs_content',
                'callback' => 'do_shortcode', // special case
            ],
        ];

        $filters_api->add_filters( $filters )->register();
    }
}
