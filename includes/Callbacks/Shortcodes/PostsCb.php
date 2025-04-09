<?php

namespace KAFWPB\Callbacks\Shortcodes;

use KAFWPB\Controllers\WPBakery\Support\Animation;

/**
 * Class PostsCb
 * Handles Tabs shortcode.
 *
 * @package KAFWPB
 * @since: 1.0.0
 * @author: Mahbub Alam Khan
 */
class PostsCb {

	/**
	 * Get the output.
	 *
	 * @param array $atts Attributes.
	 *
	 * @return string
	 */
	public function get_the_output( $atts ) {

		$atts = shortcode_atts([
			'kb_type'              => 'recent', // @param: recent,popular,featured,random
			'kb_type_title'        => '',
			'kb_type_title_status' => 1,
			'meta_key'             => '',
			'meta_value'           => '',
			'orderby'              => 'ID',
			'order'                => 'DESC',
			'limit'                => -1,
			'bkb_tabify'           => 0,
			'bkb_list_type'        => '', // @param: rectangle/iconized/rounded/none
			'suppress_filters'     => 0,
			'show_title'           => 1,
			'paginate'             => 0, // Pagination introduced in version 1.0.1 of Templify Addon default is 0
			'posts_per_page'       => 5,
			'paged'                => 1,
			'animation'            => '',
			'cont_ext_class'       => '',
		], $atts);

		extract( $atts );

		$output                  = '';
		$bkb_posts_wrapper_start = '';
		$bkb_posts_wrapper_end   = '';

		// Added in version 1.0.7

		$bkb_post_column_animation = '';

		$cont_ext_class = ( isset( $cont_ext_class ) && $cont_ext_class != '' ) ? ' ' . $cont_ext_class : '';

		$wrapper_div_status = 0;

		if ( isset( $cont_ext_class ) && $cont_ext_class != '' ) {

			$wrapper_div_status = 1;
		}

		if ( isset( $animation ) && ! empty( $animation ) && defined( 'WPB_VC_VERSION' ) ) {

			$wrapper_div_status = 1;

			if ( isset( $animation ) && ! empty( $animation ) ) {
					$animate_class             = new Animation( [ 'base' => 'vc_bkb_posts' ] );
					$bkb_post_column_animation = ' ' . $animate_class->getCSSAnimation( $animation );
			}
		}

		if ( $wrapper_div_status == 1 ) {

			$bkb_posts_wrapper_start .= '<div class="' . $bkb_post_column_animation . $cont_ext_class . '">';
		}

		// Start Inner Code.

		if ( 'popular' == trim( $kb_type ) ) {

			$kb_type_title = ( $kb_type_title == '' ) ? esc_html__( 'Popular KB', 'bkb_vc' ) : $kb_type_title;

			$output .= do_shortcode( '[bwl_kb bkb_tabify="1" bkb_list_type="' . $bkb_list_type . '" meta_key="bkbm_post_views" orderby="meta_value_num" order="DESC" limit="' . $posts_per_page . '" paginate="' . $paginate . '" posts_per_page="' . $posts_per_page . '"]' );
		} elseif ( 'featured' == trim( $kb_type ) ) {

			$kb_type_title = ( $kb_type_title == '' ) ? __( 'Featured KB', 'bkb_vc' ) : $kb_type_title;

			$output .= do_shortcode( '[bwl_kb bkb_tabify="1" bkb_list_type="' . $bkb_list_type . '" meta_key="bkb_featured_status" meta_value="1" orderby="meta_value_num" order="DESC" limit="' . $posts_per_page . '" paginate="' . $paginate . '" posts_per_page="' . $posts_per_page . '"]' );
		} elseif ( 'random' == trim( $kb_type ) ) {

			$kb_type_title = ( $kb_type_title == '' ) ? __( 'Random KB', 'bkb_vc' ) : $kb_type_title;

			$output .= do_shortcode( '[bwl_kb bkb_tabify="1" bkb_list_type="' . $bkb_list_type . '" orderby="rand" limit="' . $posts_per_page . '" paginate="' . $paginate . '" posts_per_page="' . $posts_per_page . '"]' );
		} else {

			$kb_type_title = ( $kb_type_title == '' ) ? __( 'Recent KB', 'bkb_vc' ) : $kb_type_title;

			$output .= do_shortcode( '[bwl_kb bkb_tabify="1" bkb_list_type="' . $bkb_list_type . '" orderby="ID" order="DESC" limit="' . $posts_per_page . '" paginate="' . $paginate . '" posts_per_page="' . $posts_per_page . '"]' );
		}

		if ( $kb_type_title_status == 1 ) {

			$kb_type_title_string = '<h2 class="bwl-kb-type-title">' . $kb_type_title . '</h2>';

			$output = $kb_type_title_string . $output;
		}

		// Finish Wrapper Div.

		if ( $wrapper_div_status == 1 ) {

			$bkb_posts_wrapper_end .= '</div>';
		}

		return $bkb_posts_wrapper_start . $output . $bkb_posts_wrapper_end;
	}
}
