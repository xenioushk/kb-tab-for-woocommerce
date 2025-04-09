<?php

namespace KAFWPB\Controllers\WPBakery\Elements;

use Xenioushk\BwlPluginApi\Api\WPBakery\WPBakeryApi;
use KAFWPB\Traits\WPBakeryTraits;

/**
 * Class Tabs
 *
 * Handles kb tabs wpbakery page builder element.
 *
 * @package KAFWPB
 */
class Tabs {

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
			'name'            => esc_html__( 'KB Tabs', 'bkb_vc' ),
			'base'            => 'vc_bkb_tabs',
			'icon'            => 'icon-bkb-tab-vc-addon',
			'category'        => 'BWL KB',
			'content_element' => true,
			'description'     => esc_html__( 'Display KB Tabs.','bwl_ptmn' ),
			'params'          => $this->get_params(),
		];
	}

	/**
	 * Get element parameters
	 *
	 * @return array
	 */
	private function get_params() {

		$boolean_tags = $this->get_boolean_tags();

			$params = [
				// add params same as with any other content element
				[
					'admin_label' => true,
					'type'        => 'kb_tabs',
					'value'       => '',
					'heading'     => esc_html__( 'Tab Items', 'bkb_vc' ),
					'param_name'  => 'tabs',
					'description' => esc_html__( 'You can use drag & drop to re-order tab position.', 'bkb_vc' ),
					'group'       => 'Tabs',
				],

				[
					'admin_label' => true,
					'type'        => 'dropdown',
					'class'       => '',
					'heading'     => esc_html__( 'Tab Style', 'bkb_vc' ),
					'param_name'  => 'vertical',
					'value'       => [
						esc_html__( 'Horizontal Tab', 'bkb_vc' ) => 0,
						esc_html__( 'Vertical Tab', 'bkb_vc' )   => 1,
					],
					'group'       => 'Tabs',
				],

				[
					'admin_label' => true,
					'type'        => 'dropdown',
					'class'       => '',
					'heading'     => esc_html__( 'Tab Item Style', 'bkb_vc' ),
					'param_name'  => 'bkb_list_type',
					'value'       => [
						esc_html__( 'Rounded', 'bkb_vc' )  => 'rounded',
						esc_html__( 'Rectangle', 'bkb_vc' ) => 'rectangle',
						esc_html__( 'Iconized', 'bkb_vc' ) => 'iconized',
						esc_html__( 'None', 'bkb_vc' )     => 'none',
					],
					'group'       => 'Tabs',
				],

				[
					'type'       => 'textfield',
					'class'      => '',
					'heading'    => esc_html__( 'No of Items', 'bkb_vc' ),
					'param_name' => 'limit',
					'value'      => '',
					'group'      => 'Tabs',
				],

				// Tab Title Settings.

				[
					'type'        => 'textfield',
					'class'       => '',
					'heading'     => esc_html__( 'Featured Tab Title', 'bkb_vc' ),
					'param_name'  => 'feat_tab_title',
					'value'       => '',
					'description' => esc_html__( 'Set custom title for Featured KB Tab', 'bkb_vc' ),
					'group'       => 'Tabs Title',
				],

				[
					'type'        => 'textfield',
					'class'       => '',
					'heading'     => esc_html__( 'Popular Tab Title', 'bkb_vc' ),
					'param_name'  => 'popular_tab_title',
					'value'       => '',
					'description' => esc_html__( 'Set custom title for Popular KB Tab', 'bkb_vc' ),
					'group'       => 'Tabs Title',
				],

				[
					'type'        => 'textfield',
					'class'       => '',
					'heading'     => esc_html__( 'Recent Tab Title', 'bkb_vc' ),
					'param_name'  => 'recent_tab_title',
					'value'       => '',
					'description' => esc_html__( 'Set custom title for Recent KB Tab', 'bkb_vc' ),
					'group'       => 'Tabs Title',
				],

				// add params same as with any other content element

				[
					'type'       => 'dropdown',
					'class'      => '',
					'heading'    => esc_html__( 'Enable RTL Mode?', 'bkb_vc' ),
					'param_name' => 'rtl',
					'value'      => $boolean_tags,
					'group'      => 'Settings',
				],

				[
					'type'        => 'textfield',
					'class'       => '',
					'heading'     => esc_html__( 'Extra Class', 'bkb_vc' ),
					'param_name'  => 'cont_ext_class',
					'value'       => '',
					'description' => esc_html__( 'Add additional class of tabs.', 'bkb_vc' ),
					'group'       => 'Settings',
				],

			];
			return $params;
	}
}
