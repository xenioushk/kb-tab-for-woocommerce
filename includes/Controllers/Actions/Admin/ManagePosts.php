<?php
namespace BKBRKB\Controllers\Actions\Admin;

use Xenioushk\BwlPluginApi\Api\Actions\ActionsApi;
use BKBRKB\Callbacks\Actions\Admin\ManagePostsCb;

/**
 * Class for registering the atfc tab.
 *
 * @since: 1.1.5
 * @package BKBRKB
 */
class ManagePosts {

    /**
	 * Register filters.
	 */
    public function register() {

        // Initialize API.
        $actions_api = new ActionsApi();

        // Initialize callbacks.
        $manage_posts_cb = new ManagePostsCb();

        // Filters.
        $actions = [
            [
                'tag'      => 'restrict_manage_posts',
                'callback' => [ $manage_posts_cb, 'apply' ],
                'priority' => 11,
            ],

        ];

        $actions_api->add_actions( $actions )->register();
    }
}
