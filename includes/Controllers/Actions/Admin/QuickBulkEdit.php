<?php
namespace KTFWC\Controllers\Actions\Admin;

use Xenioushk\BwlPluginApi\Api\Actions\ActionsApi;
use KTFWC\Callbacks\Actions\Admin\QuickEditCb;
use KTFWC\Callbacks\Actions\Admin\QuickEditSaveCb;
use KTFWC\Callbacks\Actions\Admin\BulkEditSaveCb;

/**
 * Class for registering the atfc tab.
 *
 * @since: 1.1.5
 * @package KTFWC
 */
class QuickBulkEdit {

    /**
	 * Register filters.
	 */
    public function register() {

        // Initialize API.
        $actions_api = new ActionsApi();

        // Initialize callbacks.
        $quick_edit_cb      = new QuickEditCb();
        $bulk_edit_cb       = new BulkEditSaveCb();
        $quick_edit_save_cb = new QuickEditSaveCb();

        // Filters.
        $actions = [
            [
                'tag'        => 'quick_edit_custom_box',
                'callback'   => [ $quick_edit_cb, 'get_edit_box' ],
                'args_count' => 2,
            ],
            [
                'tag'        => 'bulk_edit_custom_box',
                'callback'   => [ $quick_edit_cb, 'get_edit_box' ],
                'args_count' => 2,
            ],
            [
                'tag'        => 'save_post_product',
                'callback'   => [ $quick_edit_save_cb, 'save_data' ],
                'args_count' => 2,
            ],
            [
                'tag'      => 'wp_ajax_manage_wp_posts_using_bulk_edit_kbtfw',
                'callback' => [ $bulk_edit_cb, 'save_data' ],
            ],

        ];

        $actions_api->add_actions( $actions )->register();
    }
}
