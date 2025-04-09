<?php

namespace KAFWPB\Controllers\WPBakery\Elements;

use Xenioushk\BwlPluginApi\Api\WPBakery\WPBakeryApi;
use KAFWPB\Traits\WPBakeryTraits;

/**
 * Class Counter
 *
 * Handles counter wpbakery page builder element.
 *
 * @package KAFWPB
 */
class Counter {

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
	public $wpb_api;

	/**
	 * Register methods.
	 */
	public function register() {

		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		// Set WPB elem.
		$this->set_wpb_elem();

		// Initialize API.
		$this->wpb_api = new WPBakeryApi();

		$this->wpb_api->add_wpb_elem( $this->wpb_elem )->register();

	}

	/**
	 * Set WPB data.
	 */
	private function set_wpb_elem() {

		$this->wpb_elem = [
			'name'            => esc_html__( 'KB counter', 'bkb_vc' ),
			'base'            => 'vc_bkb_counter',
			'icon'            => 'icon-bkb-counter-vc-addon',
			'category'        => 'BWL KB',
			'content_element' => true,
			'description'     => esc_html__( 'Display kb counter.','bkb_vc' ),
			'params'          => $this->get_params(),
		];
	}

	/**
	 * Get element parameters
	 *
	 * @return array
	 */
	private function get_params() {

		$counter_delay  = $this->get_counter_delay();
		$delay_interval = $this->get_delay_interval();

			$params = [
				// add params same as with any other content element
				[
					'admin_label' => true,
					'type'        => 'kb_counter',
					'value'       => '',
					'heading'     => esc_html__( 'Elements', 'bkb_vc' ),
					'param_name'  => 'counter',
					'description' => esc_html__( 'You can use drag & drop to re-order tab position.', 'bkb_vc' ),
					'group'       => 'Counter',
				],

				[
					'type'       => 'dropdown',
					'class'      => '',
					'heading'    => esc_html__( 'Counter Delay', 'bkb_vc' ),
					'param_name' => 'counter_delay',
					'value'      => $counter_delay,
					'group'      => 'Counter',
				],

				[
					'type'       => 'dropdown',
					'class'      => '',
					'heading'    => esc_html__( 'Counter Time', 'bkb_vc' ),
					'param_name' => 'counter_time',
					'value'      => $delay_interval,
					'group'      => 'Counter',
				],

				[
					'type'        => 'colorpicker',
					'heading'     => esc_html__( 'Counter Icon Color', 'bkb_vc' ),
					'param_name'  => 'counter_icon_color',
					'value'       => '#0074A2',
					'description' => esc_html__( 'Set counter icon color.', 'bkb_vc' ),
					'group'       => 'Settings',
				],
				[
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Icon Font Size', 'bkb_vc' ),
					'param_name'  => 'counter_icon_size',
					'value'       => '54',
					'description' => esc_html__( 'Set counter icon color.', 'bkb_vc' ),
					'group'       => 'Settings',
				],

				[
					'type'        => 'colorpicker',
					'heading'     => esc_html__( 'Counter Text Color', 'bkb_vc' ),
					'param_name'  => 'counter_text_color',
					'value'       => '#2C2C2C',
					'description' => esc_html__( 'Set counter text color.', 'bkb_vc' ),
					'group'       => 'Settings',
				],
				[
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Text Font Size', 'bkb_vc' ),
					'param_name'  => 'counter_text_size',
					'value'       => '32',
					'description' => esc_html__( 'Set counter icon color.', 'bkb_vc' ),
					'group'       => 'Settings',
				],

				[
					'type'        => 'colorpicker',
					'heading'     => esc_html__( 'Counter Title Color', 'bkb_vc' ),
					'param_name'  => 'counter_title_color',
					'value'       => '#525252',
					'description' => esc_html__( 'Set counter title color.', 'bkb_vc' ),
					'group'       => 'Settings',
				],

				[
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Title Font Size', 'bkb_vc' ),
					'param_name'  => 'counter_title_size',
					'value'       => '14',
					'description' => esc_html__( 'Set counter icon color.', 'bkb_vc' ),
					'group'       => 'Settings',
				],

				// add params same as with any other content element

				[
					'type'       => 'textfield',
					'class'      => '',
					'heading'    => esc_html__( 'Total Kb Title', 'bkb_vc' ),
					'param_name' => 'title_total_kb',
					'value'      => esc_html__( 'KB Posts', 'bkb_vc' ),
					'group'      => 'Total KB',
				],

				[
					'type'        => 'iconpicker',
					'heading'     => esc_html__( 'Total KB Icon', 'bkb_vc' ),
					'param_name'  => 'icon_total_kb',
					'settings'    => [
						'emptyIcon'    => true, // default true, display an "EMPTY" icon?
						'type'         => 'fontawesome',
						'iconsPerPage' => 50, // default 100, how many icons per/page to display
					],
					'group'       => 'Total KB',
					'description' => esc_html__( 'Select icon from library.', 'bkb_vc' ),
				],

				[
					'type'       => 'textfield',
					'class'      => '',
					'heading'    => esc_html__( 'Total Category Title', 'bkb_vc' ),
					'param_name' => 'title_total_cat',
					'value'      => esc_html__( 'KB Categories', 'bkb_vc' ),
					'group'      => 'Total Category',
				],

				[
					'type'        => 'iconpicker',
					'heading'     => esc_html__( 'Total Category Icon', 'bkb_vc' ),
					'param_name'  => 'icon_total_cat',
					'settings'    => [
						'emptyIcon'    => true, // default true, display an "EMPTY" icon?
						'type'         => 'fontawesome',
						'iconsPerPage' => 50, // default 100, how many icons per/page to display
					],
					'group'       => 'Total Category',
					'description' => esc_html__( 'Select icon from library.', 'bkb_vc' ),
				],

				[
					'type'       => 'textfield',
					'class'      => '',
					'heading'    => esc_html__( 'Total Tag Title', 'bkb_vc' ),
					'param_name' => 'title_total_tag',
					'value'      => esc_html__( 'KB Tags', 'bkb_vc' ),
					'group'      => 'Total Tag',
				],

				[
					'type'        => 'iconpicker',
					'heading'     => esc_html__( 'Total Tag Icon', 'bkb_vc' ),
					'param_name'  => 'icon_total_tag',
					'settings'    => [
						'emptyIcon'    => true, // default true, display an "EMPTY" icon?
						'type'         => 'fontawesome',
						'iconsPerPage' => 50, // default 100, how many icons per/page to display
					],
					'group'       => 'Total Tag',
					'description' => esc_html__( 'Select icon from library.', 'bkb_vc' ),
				],

				[
					'type'       => 'textfield',
					'class'      => '',
					'heading'    => esc_html__( 'Total Like Title', 'bkb_vc' ),
					'param_name' => 'title_total_likes',
					'value'      => esc_html__( 'KB Likes', 'bkb_vc' ),
					'group'      => 'Total Like',
				],

				[
					'type'        => 'iconpicker',
					'heading'     => esc_html__( 'Total Like Icon', 'bkb_vc' ),
					'param_name'  => 'icon_total_likes',
					'settings'    => [
						'emptyIcon'    => true, // default true, display an "EMPTY" icon?
						'type'         => 'fontawesome',
						'iconsPerPage' => 50, // default 100, how many icons per/page to display
					],
					'group'       => 'Total Like',
					'description' => esc_html__( 'Select icon from library.', 'bkb_vc' ),
				],

				[
					'type'        => 'textfield',
					'class'       => '',
					'heading'     => esc_html__( 'Extra Class', 'bkb_vc' ),
					'param_name'  => 'cont_ext_class',
					'value'       => '',
					'group'       => 'Counter',
					'description' => esc_html__( 'Additional Class: bkbm-post-list-custom-layout, bkbm-posts-box-shadow', 'bkb_vc' ),
				],

			];
			return $params;
	}
}
