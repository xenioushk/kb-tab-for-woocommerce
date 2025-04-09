<?php

namespace KAFWPB\Controllers\WPBakery\Elements;

use Xenioushk\BwlPluginApi\Api\WPBakery\WPBakeryApi;
use KAFWPB\Traits\WPBakeryTraits;

/**
 * Class KB Posts
 *
 * Handles kb posts wpbakery page builder element.
 *
 * @package KAFWPB
 */
class Posts {

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
			'name'            => esc_html__( 'Knowledgebase Posts', 'bkb_vc' ),
			'base'            => 'vc_bkb_posts',
			'icon'            => 'icon-bkb-posts-vc-addon',
			'category'        => 'BWL KB',
			'content_element' => true,
			'description'     => esc_html__( 'Display kb external form.','bwl_ptmn' ),
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
					'type'        => 'dropdown',
					'class'       => '',
					'heading'     => esc_html__( 'KB Type', 'bkb_vc' ),
					'param_name'  => 'kb_type',
					'value'       => [
						esc_html__( 'Recent KB', 'bkb_vc' )   => 'recent',
						esc_html__( 'Popular KB', 'bkb_vc' )  => 'popular',
						esc_html__( 'Featured KB', 'bkb_vc' ) => 'featured',
						esc_html__( 'Random KB', 'bkb_vc' )   => 'random',
					],
					'group'       => 'General',
				],

				[
					'type'       => 'textfield',
					'class'      => '',
					'heading'    => esc_html__( 'KB Type Title', 'bkb_vc' ),
					'param_name' => 'kb_type_title',
					'value'      => '',
					'group'      => 'General',
				],

				[
					'admin_label' => true,
					'type'        => 'dropdown',
					'class'       => '',
					'heading'     => esc_html__( 'Display KB Type Title?', 'bkb_vc' ),
					'param_name'  => 'kb_type_title_status',
					'value'       => $boolean_tags,
					'group'       => 'General',
				],

				[
					'admin_label' => true,
					'type'        => 'dropdown',
					'class'       => '',
					'heading'     => esc_html__( 'Enable Pagination?', 'bkb_vc' ),
					'param_name'  => 'paginate',
					'value'       => $boolean_tags,
					'group'       => 'General',
				],

				[
					'type'        => 'textfield',
					'class'       => '',
					'heading'     => esc_html__( 'Post Per Page', 'bkb_vc' ),
					'param_name'  => 'posts_per_page',
					'value'       => '5',
					'description' => esc_html__( 'Default: 5. You can add any number. Set -1 to display all the posts.', 'bkb_vc' ),
					'group'       => 'General',
				],

				[
					'admin_label' => true,
					'type'        => 'dropdown',
					'class'       => '',
					'heading'     => esc_html__( 'List Styles', 'bkb_vc' ),
					'param_name'  => 'bkb_list_type',
					'value'       => [
						esc_html__( 'Select', 'bkb_vc' )   => '',
						esc_html__( 'Rounded', 'bkb_vc' )  => 'rounded',
						esc_html__( 'Rectangle', 'bkb_vc' ) => 'rectangle',
						esc_html__( 'Iconized', 'bkb_vc' ) => 'iconized',
						esc_html__( 'None', 'bkb_vc' )     => 'none',
					],
					'group'       => 'Design',
				],

				[
					'type'        => 'textfield',
					'class'       => '',
					'heading'     => esc_html__( 'Extra Class', 'bkb_vc' ),
					'param_name'  => 'cont_ext_class',
					'value'       => '',
					'description' => esc_html__( 'Additional Class: bkbm-post-list-custom-layout, bkbm-posts-box-shadow', 'bkb_vc' ),
					'group'       => 'Design',
				],

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
