<?php

namespace KAFWPB\Callbacks\Shortcodes;

/**
 * Class CounterCb
 * Handles Counter shortcode.
 *
 * @package KAFWPB
 * @since: 1.0.0
 * @author: Mahbub Alam Khan
 */
class CounterCb {

	/**
	 * Get the output.
	 *
	 * @param array $atts Attributes.
	 *
	 * @return string
	 */
	public function get_the_output( $atts ) {

		$atts = shortcode_atts([
			'counter_delay'       => 5,
			'counter_time'        => 1000,
			'counter'             => 'total_kb,total_cat,total_tag,total_likes',
			'counter_icon_size'   => '54',
			'counter_icon_color'  => '#0074A2',
			'counter_text_size'   => '32',
			'counter_text_color'  => '#2C2C2C',
			'counter_title_size'  => '14',
			'counter_title_color' => '#525252',
			'title_total_kb'      => esc_html__( 'KB Posts', 'bkb_vc' ),
			'icon_total_kb'       => 'fa fa-home',
			'title_total_cat'     => esc_html__( 'KB Categories', 'bkb_vc' ),
			'icon_total_cat'      => 'fa fa-list',
			'title_total_tag'     => esc_html__( 'KB Tags', 'bkb_vc' ),
			'icon_total_tag'      => 'fa fa-home',
			'title_total_likes'   => esc_html__( 'KB Likes', 'bkb_vc' ),
			'icon_total_likes'    => 'fa fa-thumbs-o-up',
		], $atts);

		extract( $atts );

		$counter_explode = explode( ',', $counter );

		// Custom Styleing.

		$counter_icon_style  = 'style="font-size:' . $counter_icon_size . 'px; color: ' . $counter_icon_color . ';"';
		$counter_text_style  = 'style="font-size:' . $counter_text_size . 'px; color: ' . $counter_text_color . ';"';
		$counter_title_style = 'style="font-size:' . $counter_title_size . 'px; color: ' . $counter_title_color . ';"';

		$output = '<div class="bkbm-grid bkbm-grid-pad text-center bkb-counter-container" data-delay="' . $counter_delay . '" data-time="' . $counter_time . '">';

		foreach ( $counter_explode as $type ) {

			$title         = ${"title_$type"};
			$icon          = ${"icon_$type"};
			$counter_value = 0;

			if ( $type == 'total_cat' ) {

					$counter_value = wp_count_terms( 'bkb_category' );
			} elseif ( $type == 'total_tag' ) {

				$counter_value = wp_count_terms( 'bkb_tags' );
			} elseif ( $type == 'total_likes' ) {

				global $wpdb;
				// bkb_like_votes_count

				$meta_key        = 'bkb_like_votes_count'; // set this to your custom field meta key
				$bkb_total_likes = $wpdb->get_col($wpdb->prepare("
																								SELECT sum(meta_value) as total_likes
																								FROM $wpdb->postmeta
																								WHERE meta_key = %s", $meta_key));

				$counter_value = array_sum( $bkb_total_likes );
			} else {

					$count_pages   = wp_count_posts( 'bwl_kb' );
					$counter_value = $count_pages->publish;
			}

			$output .= '<div class="bkbcol-1-4">
												 <div class="content">
														 <span class="bkb_counter_icon" ' . $counter_icon_style . '><i class="' . $icon . '"></i></span>
														 <p><span class="bkb_counter_value" ' . $counter_text_style . '>' . $counter_value . '</span><span class="db bkb_counter_title" ' . $counter_title_style . '>' . $title . '</span></p>
												 </div>
											</div>';
		}

		$output .= '</div>';

		wp_reset_postdata();

		return $output;
	}
}
