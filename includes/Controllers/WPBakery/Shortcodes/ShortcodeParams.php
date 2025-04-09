<?php

namespace KAFWPB\Controllers\WPBakery\Shortcodes;

use KAFWPB\Traits\WPBakeryTraits;
use Xenioushk\BwlPluginApi\Api\WPBakery\WPBShortcodesApi;
use KAFWPB\Callbacks\WPBakery\Shortcodes\CatShortcodeParamCb;
use KAFWPB\Callbacks\WPBakery\Shortcodes\TagsShortcodeParamCb;
use KAFWPB\Callbacks\WPBakery\Shortcodes\TabsShortcodeParamCb;
use KAFWPB\Callbacks\WPBakery\Shortcodes\CounterShortcodeParamCb;

/**
 * Class ShortcodeParams
 *
 * Handles Petition info WPBakery page builder element.
 *
 * @package KAFWPB
 */
class ShortcodeParams {

	use WPBakeryTraits;

	/**
	 * WPB fields.
	 *
	 * @var wpb_elem
	 */
	public $wpb_elem;

	/**
	 * WPB API.
	 *
	 * @var wpb_api
	 */
	public $wpb_shortcode_api;


	/**
	 * Cat Shortcode Param Callback.
	 *
	 * @var cat_shortcode_param_cb
	 */
	public $cat_shortcode_param_cb;

	/**
	 * Tags Shortcode Param Callback.
	 *
	 * @var tags_shortcode_param_cb
	 */
	public $tags_shortcode_param_cb;

	/**
	 * Tabs Shortcode Param Callback.
	 *
	 * @var tabs_shortcode_param_cb
	 */
	public $tabs_shortcode_param_cb;

	/**
	 * Counter Shortcode Param Callback.
	 *
	 * @var counter_shortcode_param_cb
	 */
	public $counter_shortcode_param_cb;

	/**
	 * Register methods.
	 */
	public function register() {

		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		// Initialize API.
		$this->wpb_shortcode_api          = new WPBShortcodesApi();
		$this->cat_shortcode_param_cb     = new CatShortcodeParamCb();
		$this->tags_shortcode_param_cb    = new TagsShortcodeParamCb();
		$this->tabs_shortcode_param_cb    = new TabsShortcodeParamCb();
		$this->counter_shortcode_param_cb = new CounterShortcodeParamCb();

		$shortcodes = [
			[
				'tag'      => 'kb_cat',
				'callback' => [ $this->cat_shortcode_param_cb, 'get_the_output' ],
				'scripts'  => KAFWPB_PLUGIN_SCRIPTS_ASSETS_DIR . 'admin.js',
			],
			[
				'tag'      => 'kb_tags',
				'callback' => [ $this->tags_shortcode_param_cb, 'get_the_output' ],
				'scripts'  => KAFWPB_PLUGIN_SCRIPTS_ASSETS_DIR . 'admin.js',
			],
			[
				'tag'      => 'kb_tabs',
				'callback' => [ $this->tabs_shortcode_param_cb, 'get_the_output' ],
				'scripts'  => KAFWPB_PLUGIN_SCRIPTS_ASSETS_DIR . 'admin.js',
			],
			[
				'tag'      => 'kb_counter',
				'callback' => [ $this->counter_shortcode_param_cb, 'get_the_output' ],
				'scripts'  => KAFWPB_PLUGIN_SCRIPTS_ASSETS_DIR . 'admin.js',
			],
		];

		$this->wpb_shortcode_api->add_shortcodes( $shortcodes )->register();

	}
}
