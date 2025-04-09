<?php

namespace KAFWPB\Controllers\WPBakery\Elements;

use Xenioushk\BwlPluginApi\Api\WPBakery\WPBakeryApi;
use KAFWPB\Traits\WPBakeryTraits;

/**
 * Class AskQuestion
 *
 * Handles AskQuestion WPBakery page builder element.
 *
 * @package KAFWPB
 */
class AskQuestion {

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
			'name'            => esc_html__( 'Question Modal Button', 'bkb_vc' ),
			'base'            => 'bkb_ask_form',
			'icon'            => 'icon-bkb-btn-vc-addon',
			'category'        => 'BWL KB',
			'content_element' => true,
			'description'     => esc_html__( 'Display question modal button.','bwl_ptmn' ),
			'params'          => $this->get_params(),
		];
	}

	/**
	 * Get element parameters
	 *
	 * @return array
	 */
	private function get_params() {

			$params = [

				// add params same as with any other content element
				[
					'admin_label' => true,
					'type'        => 'textfield',
					'class'       => '',
					'heading'     => esc_html__( 'Button Title', 'bkb_vc' ),
					'param_name'  => 'title',
					'value'       => esc_html__( 'Add a Question', 'bkb_vc' ),
					'group'       => 'General',
				],

				[
					'type'       => 'dropdown',
					'class'      => '',
					'heading'    => esc_html__( 'Button Size', 'bkb_vc' ),
					'param_name' => 'btn_size',
					'value'      => [
						esc_html__( 'Select', 'bkb_vc' ) => '',
						esc_html__( 'Large', 'bkb_vc' )  => 'bkb_btn_lg',
						esc_html__( 'Medium', 'bkb_vc' ) => 'bkb_btn_md',
						esc_html__( 'Small', 'bkb_vc' )  => 'bkb_btn_sm',
						esc_html__( 'Full Width', 'bkb_vc' ) => 'bkb_btn_full',

					],
					'group'      => 'General',
				],

				[
					'type'       => 'dropdown',
					'class'      => '',
					'heading'    => esc_html__( 'Button Alignment', 'bkb_vc' ),
					'param_name' => 'btn_align',
					'value'      => [
						esc_html__( 'Center', 'bkb_vc' ) => '',
						esc_html__( 'Left', 'bkb_vc' )   => 'bkb_btn_left',
						esc_html__( 'Right', 'bkb_vc' )  => 'bkb_btn_right',
					],
					'group'      => 'General',
				],

				[
					'type'       => 'dropdown',
					'class'      => '',
					'heading'    => esc_html__( 'Button Border Style', 'bkb_vc' ),
					'param_name' => 'btn_border_style',
					'value'      => [
						esc_html__( 'Select', 'bkb_vc' )  => '',
						esc_html__( 'Square', 'bkb_vc' )  => 'bkb_btn_square',
						esc_html__( 'Rounded', 'bkb_vc' ) => 'bkb_btn_rounded',

					],
					'group'      => 'General',
				],

				[
					'type'       => 'dropdown',
					'class'      => '',
					'heading'    => esc_html__( 'Button Animation', 'bkb_vc' ),
					'param_name' => 'btn_animate',
					'value'      => [
						esc_html__( 'Select', 'bkb_vc' ) => '',
						esc_html__( 'Animation 1', 'bkb_vc' ) => 'animated-button sandy-one',
						esc_html__( 'Animation 2', 'bkb_vc' ) => 'animated-button sandy-two',
						esc_html__( 'Animation 3', 'bkb_vc' ) => 'animated-button sandy-three',
						esc_html__( 'Animation 4', 'bkb_vc' ) => 'animated-button sandy-four',
						esc_html__( 'Animation 5', 'bkb_vc' ) => 'animated-button gibson-one',
						esc_html__( 'Animation 6', 'bkb_vc' ) => 'animated-button gibson-two',
						esc_html__( 'Animation 7', 'bkb_vc' ) => 'animated-button gibson-three',
						esc_html__( 'Animation 8', 'bkb_vc' ) => 'animated-button gibson-four',
						esc_html__( 'Animation 9', 'bkb_vc' ) => 'animated-button thar-one',
						esc_html__( 'Animation 10', 'bkb_vc' ) => 'animated-button thar-two',
						esc_html__( 'Animation 11', 'bkb_vc' ) => 'animated-button thar-three',
						esc_html__( 'Animation 12', 'bkb_vc' ) => 'animated-button thar-four',

					],
					'group'      => 'Animation',
				],

			];
			return $params;
	}
}
