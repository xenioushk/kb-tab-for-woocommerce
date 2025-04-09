<?php

namespace KAFWPB\Controllers\WPBakery\Elements;

use Xenioushk\BwlPluginApi\Api\WPBakery\WPBakeryApi;
use KAFWPB\Traits\WPBakeryTraits;

/**
 * Class Tags
 *
 * Handles kb tags wpbakery page builder element.
 *
 * @package KAFWPB
 */
class Tags {

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
			'name'            => esc_html__( 'KB Tags', 'bkb_vc' ),
			'base'            => 'bkb_tags',
			'icon'            => 'icon-bkb-tags-vc-addon',
			'category'        => 'BWL KB',
			'content_element' => true,
			'description'     => esc_html__( 'Display KB Tags.','bkb_vc' ),
			'params'          => $this->get_params(),
		];
	}

	/**
	 * Get element parameters
	 *
	 * @return array
	 */
	private function get_params() {

		$columns_tags    = $this->get_columns_tags();
		$boolean_tags    = $this->get_boolean_tags();
		$list_types_tags = $this->get_list_types_tags();
		$view_tags       = $this->get_view_tags();
		$order_tags      = $this->get_order_tags();
		$orderby_tags    = $this->get_orderby_tags();

			$params = [
				// add params same as with any other content element
				[
					'admin_label' => true,
					'type'        => 'kb_tags',
					'value'       => '',
					'heading'     => esc_html__( 'Tags', 'bkb_vc' ),
					'param_name'  => 'tags',
					'description' => esc_html__( 'Just drag and drop your required Tags in to right box.', 'bkb_vc' ),
					'group'       => 'Tags',
				],

				[
					'type'        => 'textfield',
					'class'       => '',
					'heading'     => esc_html__( 'Extra Class', 'bkb_vc' ),
					'param_name'  => 'cont_ext_class',
					'value'       => '',
					'description' => esc_html__( 'Additional class: bkbm-box-shadow', 'bkb_vc' ),
					'group'       => 'Tags',
				],

				// add params same as with any other content element

				[
					'admin_label' => true,
					'type'        => 'dropdown',
					'class'       => '',
					'heading'     => esc_html__( 'Layout Type Settings', 'bkb_vc' ),
					'param_name'  => 'box_view',
					'value'       => $view_tags,
					'group'       => 'Settings',
				],

				// Carousel.

				[
					'admin_label' => true,
					'type'        => 'checkbox',
					'class'       => '',
					'heading'     => esc_html__( 'Enable Carousel?', 'bkb_vc' ),
					'param_name'  => 'carousel',
					'value'       => [ esc_html__( 'Yes', 'bkb_vc' ) => '1' ],
					'group'       => 'Settings',
				],

				[
					'type'        => 'dropdown',
					'class'       => '',
					'heading'     => esc_html__( 'Hide Carousel Navigation Arrow?', 'bkb_vc' ),
					'param_name'  => 'carousel_nav',
					'value'       => $boolean_tags,
					'description' => esc_html__( 'You can show/hide two arrow will display beside the carousel items.', 'bkb_vc' ),
					'group'       => 'Settings',
					'dependency'  => [ 'element' => 'carousel', 'value' => [ '1' ] ],
				],

				[
					'type'        => 'dropdown',
					'class'       => '',
					'heading'     => esc_html__( 'Hide Carousel Dots ?', 'bkb_vc' ),
					'param_name'  => 'carousel_dots',
					'value'       => $boolean_tags,
					'description' => esc_html__( 'You can show/hide bottom will display below the carousel items.', 'bkb_vc' ),
					'group'       => 'Settings',
					'dependency'  => [ 'element' => 'carousel', 'value' => [ '1' ] ],
				],

				[
					'type'        => 'dropdown',
					'class'       => '',
					'heading'     => esc_html__( 'Auto Play Time Out', 'bkb_vc' ),
					'param_name'  => 'carousel_autoplaytimeout',
					'value'       => [
						'Select'     => '',
						'3 Seconds'  => '3000',
						'5 Seconds'  => '5000',
						'10 Seconds' => '10000',
						'20 Seconds' => '20000',
						'30 Seconds' => '30000',
					],
					'group'       => 'Settings',
					'description' => esc_html__( 'Select scroll speed.', 'bkb_vc' ),
					'dependency'  => [ 'element' => 'carousel', 'value' => [ '1' ] ],
				],

				[
					'type'       => 'dropdown',
					'class'      => '',
					'heading'    => esc_html__( 'List Styles', 'bkb_vc' ),
					'param_name' => 'bkb_list_type',
					'value'      => $list_types_tags,
					'group'      => 'Settings',
					'dependency' => [ 'element' => 'box_view', 'value' => [ '0' ] ],
				],

				[
					'type'       => 'dropdown',
					'class'      => '',
					'heading'    => esc_html__( 'Show Tag Title?', 'bkb_vc' ),
					'param_name' => 'show_title',
					'value'      => $boolean_tags,
					'group'      => 'Settings',
					'dependency' => [
						'element' => 'box_view',
						'value'   => [ '1' ],
					],
				],

				[
					'type'       => 'dropdown',
					'class'      => '',
					'heading'    => esc_html__( 'Column Settings', 'bkb_vc' ),
					'param_name' => 'cols',
					'value'      => $columns_tags,
					'group'      => 'Settings',
				],

				[
					'type'       => 'dropdown',
					'class'      => '',
					'heading'    => esc_html__( 'Display Tags Description?', 'bkb_vc' ),
					'param_name' => 'bkb_desc',
					'value'      => $boolean_tags,
					'group'      => 'Settings',
				],

				[
					'type'       => 'textfield',
					'class'      => '',
					'heading'    => esc_html__( 'No of items to display', 'bkb_vc' ),
					'param_name' => 'limit',
					'value'      => '',
					'group'      => 'Settings',
					'dependency' => [ 'element' => 'box_view', 'value' => [ '0' ] ],
				],
				[
					'type'       => 'dropdown',
					'class'      => '',
					'heading'    => esc_html__( 'Order By Settings', 'bkb_vc' ),
					'param_name' => 'orderby',
					'value'      => $orderby_tags,
					'group'      => 'Settings',
					'dependency' => [ 'element' => 'box_view', 'value' => [ '0' ] ],
				],
				[
					'type'       => 'dropdown',
					'class'      => '',
					'heading'    => __( 'Order Type Settings', 'bkb_vc' ),
					'param_name' => 'order',
					'value'      => $order_tags,
					'group'      => 'Settings',
					'dependency' => [ 'element' => 'box_view', 'value' => [ '0' ] ],
				],
				[
					'type'       => 'dropdown',
					'class'      => '',
					'heading'    => esc_html__( 'Display Post Count?', 'bkb_vc' ),
					'param_name' => 'posts_count',
					'value'      => $boolean_tags,
					'group'      => 'Settings',
				],

				[
					'type'        => 'dropdown',
					'class'       => '',
					'heading'     => esc_html__( 'Display Post Count Info?', 'bkb_vc' ),
					'param_name'  => 'count_info',
					'value'       => $boolean_tags,
					'group'       => 'Settings',
					'description' => esc_html__( 'Display total number of posts below the list.', 'bkb_vc' ),
					'dependency'  => [ 'element' => 'box_view', 'value' => [ '0' ] ],
				],

				// New Code.

				[
					'type'       => 'dropdown',
					'class'      => '',
					'heading'    => esc_html__( 'Icon Type', 'bkb_vc' ),
					'param_name' => 'box_view_icon',
					'value'      => [
						esc_html__( 'Font Awesome Icon', 'bkb_vc' ) => '',
						esc_html__( 'Image Icon', 'bkb_vc' ) => 'img_icon',
					],
					'group'      => 'Settings',
					'dependency' => [ 'element' => 'box_view', 'value' => [ '1' ] ],
				],

				[
					'type'       => 'dropdown',
					'class'      => '',
					'heading'    => esc_html__( 'Icon Size', 'bkb_vc' ),
					'param_name' => 'box_view_icon',
					'value'      => [
						esc_html__( 'Option Panel Size', 'bkb_vc' ) => '',
						esc_html__( 'Auto Size', 'bkb_vc' ) => 'img_icon',
					],
					'group'      => 'Settings',
					'dependency' => [ 'element' => 'box_view', 'value' => [ '1' ] ],
				],

				[
					'type'        => 'textfield',
					'class'       => '',
					'heading'     => esc_html__( 'Box View Extra Class', 'bkb_vc' ),
					'param_name'  => 'box_view_class',
					'value'       => '',
					'description' => esc_html__( 'Additional classes: box-left-align, box-right-align, no-icon, no-separator', 'bkb_vc' ),
					'group'       => 'Settings',
					'dependency'  => [ 'element' => 'box_view', 'value' => [ '1' ] ],
				],

				// End New Code.

				// Animation.

				[
					'type'        => 'animation_style',
					'heading'     => esc_html__( 'Animation', 'bkb_vc' ),
					'param_name'  => 'animation',
					'description' => esc_html__( 'Choose your animation style.', 'bkb_vc' ),
					'admin_label' => false,
					'weight'      => 0,
					'group'       => 'Animation',
				],

			];
			return $params;
	}
}
