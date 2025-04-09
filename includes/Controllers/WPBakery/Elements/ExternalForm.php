<?php

namespace KAFWPB\Controllers\WPBakery\Elements;

use Xenioushk\BwlPluginApi\Api\WPBakery\WPBakeryApi;
use KAFWPB\Traits\WPBakeryTraits;

/**
 * Class ExternalForm
 *
 * Handles external form wpbakery page builder element.
 *
 * @package KAFWPB
 */
class ExternalForm {

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
			'name'            => esc_html__( 'KB External Form', 'bkb_vc' ),
			'base'            => 'bkb_ques_form',
			'icon'            => 'icon-bkb-form-vc-addon',
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

			$layout_tags = $this->get_layouts();

			$params = [

				// Tab Title Settings.
				[
					'admin_label' => true,
					'type'        => 'textfield',
					'class'       => '',
					'heading'     => esc_html__( 'Form Headline', 'bkb_vc' ),
					'param_name'  => 'form_heading',
					'value'       => esc_html__( 'Add A Knowledge Base Question !', 'bkb_vc' ),
					'description' => esc_html__( 'You can set custom form heading for KB External Form .', 'bkb_vc' ),
					'group'       => 'General',
				],

				// add params same as with any other content element
				[
					'admin_label' => true,
					'type'        => 'dropdown',
					'class'       => '',
					'heading'     => esc_html__( 'Form Layout', 'bkb_vc' ),
					'param_name'  => 'layout',
					'value'       => $layout_tags,
					'group'       => 'General',
					'description' => esc_html__( 'Layout 01 will display Form labels and Layout 02 will hide Form label.', 'bkb_vc' ),
				],

				[
					'type'        => 'textfield',
					'class'       => '',
					'heading'     => esc_html__( 'Extra Class', 'bkb_vc' ),
					'param_name'  => 'cont_ext_class',
					'value'       => '',
					'description' => esc_html__( 'Add additional class of button.', 'bkb_vc' ),
					'group'       => 'General',
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
