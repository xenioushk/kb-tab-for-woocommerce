<?php

namespace KAFWPB\Callbacks\Shortcodes;

/**
 * Class TabsCb
 * Tabs Shortcode Callback.
 *
 * @package KAFWPB
 * @since: 1.0.0
 * @author: Mahbub Alam Khan
 */
class TabsCb {

	/**
	 * Get the output.
	 *
	 * @param array $atts Attributes.
	 *
	 * @return string
	 */
	public function get_the_output( $atts ) {

		$atts = shortcode_atts([
			'tabs'              => 'featured,popular,recent',
			'feat_tab_title'    => esc_html__( 'Featured', 'bkb_vc' ),
			'popular_tab_title' => esc_html__( 'Popular', 'bkb_vc' ),
			'recent_tab_title'  => esc_html__( 'Recent', 'bkb_vc' ),
			'limit'             => 5,
			'bkb_list_type'     => 'rounded',
			'vertical'          => 0,
			'rtl'               => 0,
			'cont_ext_class'    => '',
		], $atts);

		extract( $atts ); // phpcs:ignore

		$bkb_tabs = explode( ',', $tabs );
		$limit    = isset( $limit ) ? (int) $limit : 5;

		$bkb_tab_shortcode_string = '[bkb_tabs vertical=' . $vertical . ' rtl=' . $rtl . ' cont_ext_class=' . $cont_ext_class . ' ]';

		foreach ( $bkb_tabs as $tab_title ) {

			switch ( $tab_title ) {

				case 'featured':
						$bkb_tab_shortcode_string .= '[bkb_tab title="' . $feat_tab_title . '"][bwl_kb bkb_tabify="1" meta_key="bkb_featured_status" meta_value="1" orderby="meta_value_num" order="DESC" limit="' . $limit . '" bkb_list_type="' . $bkb_list_type . '"][/bkb_tab]';
			        break;
				case 'popular':
						$bkb_tab_shortcode_string .= '[bkb_tab title="' . $popular_tab_title . '"][bwl_kb bkb_tabify="1" meta_key="bkbm_post_views" orderby="meta_value_num" order="DESC" limit="' . $limit . '" bkb_list_type="' . $bkb_list_type . '"][/bkb_tab]';
			        break;
				case 'recent':
						$bkb_tab_shortcode_string .= '[bkb_tab title="' . $recent_tab_title . '"] [bwl_kb bkb_tabify="1" orderby="ID" order="DESC" limit="' . $limit . '" bkb_list_type="' . $bkb_list_type . '"][/bkb_tab]';
			        break;

				default:
			        break;
			}
		}

		$bkb_tab_shortcode_string .= '[/bkb_tabs]';

		return do_shortcode( $bkb_tab_shortcode_string );
	}
}
