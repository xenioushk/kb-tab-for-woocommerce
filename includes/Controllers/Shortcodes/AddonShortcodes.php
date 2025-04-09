<?php

namespace KTFWC\Controllers\Shortcodes;

use Xenioushk\BwlPluginApi\Api\Shortcodes\ShortcodesApi;
use KTFWC\Callbacks\Shortcodes\TabCb;
/**
 * Class for Addon shortcodes.
 *
 * @since: 1.1.0
 * @package KTFWC
 */
class AddonShortcodes {

    /**
	 * Register shortcode.
	 */
    public function register() {

        // Initialize API.
        $shortcodes_api = new ShortcodesApi();

        // Initialize callbacks.
        $tab_cb = new TabCb();

        // All Shortcodes.
        $shortcodes = [
            [
                'tag'      => 'bkb_woo_tab',
                'callback' => [ $tab_cb, 'get_the_output' ],
            ],
        ];

        $shortcodes_api->add_shortcodes( $shortcodes )->register();
    }
}
