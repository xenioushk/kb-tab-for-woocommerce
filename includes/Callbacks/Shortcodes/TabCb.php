<?php

namespace KTFWC\Callbacks\Shortcodes;

use WP_Query;

/**
 * Class TabCb
 * Tabs Shortcode Callback.
 *
 * @package KTFWC
 * @since: 1.0.0
 * @author: Mahbub Alam Khan
 */
class TabCb {

	/**
	 * Get the output.
	 *
	 * @param array $atts Attributes.
	 *
	 * @return string
	 */
	public function get_the_output( $atts ) {

		$atts = ( shortcode_atts([
            'post_type'        => BKBM_POST_TYPE,
            'post_ids'         => '',
            'orderby'          => 'post__in',
            'order'            => 'ASC',
            'limit'            => -1,
            'suppress_filters' => 0,

		], $atts) );

		extract( $atts ); //phpcs:ignore

		$output = '';

		$args = [
			'post_status'    => 'publish',
			'post__in'       => explode( ',', $post_ids ),
			'post_type'      => $post_type,
			'orderby'        => $orderby,
			'order'          => $order,
			'posts_per_page' => $limit,
		];

		// We are going to set a filter in here for Restriction Addon.
		$args = apply_filters( 'bkb_rkb_query_filter', $args );

		$loop = new WP_Query( $args );

		if ( $loop->have_posts() ) :

			// Enqueue Script
			// @Since: 1.0.4

			$output .= '<div class="bwl_acc_container" id="bkb_woo_accordion">';
			$output .= '<div class="accordion_search_container">';
			$output .= '<input type="text" class="accordion_search_input_box search_icon" value="" placeholder="Search ..."/>';
			$output .= '</div>'; // <!-- end .bwl_acc_container -->
			$output .= '<div class="search_result_container"></div>'; // <!-- end .search_result_container -->

			while ( $loop->have_posts() ) :

				$loop->the_post();

				$bkb_title   = get_the_title();
				$bkb_content = get_the_content();

				if ( has_filter( 'bkb_rkb_post_access' ) ) {

					$bkb_rkb_post_access_result = apply_filters( 'bkb_rkb_post_access', get_the_ID() );

					if ( $bkb_rkb_post_access_result != 1 ) {
						$bkb_content = $bkb_rkb_post_access_result;
					}
				}

				$output .= '<section>';
				$output .= '<h2 class="acc_title_bar"><a href="#">' . $bkb_title . '</a></h2>';
				$output .= '<div class="acc_container"><div class="block">' . do_shortcode( $bkb_content ) . '</div></div>';
				$output .= '</section>';

			endwhile;

			$output .= '</div> <!-- end .bwl_acc_container -->';

    else :

        $output .= '<p>' . esc_html__( 'No Knowledge Base Post Found!', 'bwl_kb' ) . '</p>';

    endif;

		wp_reset_postdata();

    return do_shortcode( $output );
	}
}
