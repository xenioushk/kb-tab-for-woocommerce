<?php

namespace KAFWPB\Controllers\Shortcodes;

use Xenioushk\BwlPluginApi\Api\Shortcodes\ShortcodesApi;
use KAFWPB\Callbacks\Shortcodes\TabsCb;
use KAFWPB\Callbacks\Shortcodes\PostsCb;
use KAFWPB\Callbacks\Shortcodes\CounterCb;
/**
 * Class for Addon shortcodes.
 *
 * @since: 1.1.0
 * @package KAFWPB
 */
class AddonShortcodes {

    /**
     *  Instance of the shortcodes API.
     *
     * @var object $shortcodes_api
     */
    private $shortcodes_api;

    /**
     *  Instance of the tabs callback.
     *
     * @var object $tabs_cb
     */
    private $tabs_cb;

    /**
     *  Instance of the counter callback.
     *
     * @var object $counter_cb
     */
    private $counter_cb;

    /**
     *  Instance of the posts callback.
     *
     * @var object $posts_cb
     */
    private $posts_cb;

    /**
	 * Register shortcode.
	 */
    public function register() {
        // Initialize API.
        $this->shortcodes_api = new ShortcodesApi();

        // Initialize callbacks.
        $this->tabs_cb    = new TabsCb();
        $this->counter_cb = new CounterCb();
        $this->posts_cb   = new PostsCb();

        // All Shortcodes.
        $shortcodes = [
            [
                'tag'      => 'vc_bkb_tabs',
                'callback' => [ $this->tabs_cb, 'get_the_output' ],
            ],
			[
				'tag'      => 'vc_bkb_counter',
				'callback' => [ $this->counter_cb, 'get_the_output' ],
			],
			[
				'tag'      => 'vc_bkb_posts',
				'callback' => [ $this->posts_cb, 'get_the_output' ],
			],
        ];

        $this->shortcodes_api->add_shortcodes( $shortcodes )->register();
    }
}
