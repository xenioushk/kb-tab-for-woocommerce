<?php
namespace BKBRKB\Callbacks\Filters;

use BKBRKB\Helpers\RkbHelpers;
use BKBRKB\Helpers\PluginConstants;

/**
 * Class for registering search filter callback.
 *
 * @package BKBRKB
 * @since: 1.0.0
 * @author: Mahbub Alam Khan
 */
class SearchFilterCb {


	/**
	 * Apply the search filter.
	 *
	 * @param array $rkb_query_vars The query variables.
	 * @return array
	 */
	public function apply( $rkb_query_vars ) {

		extract( $rkb_query_vars );

		$args = [
			's'              => trim( $s ),
			'post_type'      => $post_type,
			'post_status'    => 'publish',
			'posts_per_page' => $limit,
			'orderby'        => $orderby,
		];

		$current_user      = wp_get_current_user(); // Get current user info.
		$current_user_role = '';
		// Extract Current User Role Info
		if ( isset( $current_user->roles[0] ) ) {
				$current_user_role = $current_user->roles[0];
		}

		if ( $current_user_role != '' && $current_user_role != 'administrator' ) {

				$args['meta_query'] = [
					'relation' => 'OR',
					[
						'key'     => 'bkb_rkb_user_roles',
						'compare' => 'LIKE', // works!
						'value'   => $current_user_role, // This is ignored, but is necessary...
					],
					[
						'key'     => 'bkb_rkb_status',
						'compare' => 'NOT EXISTS', // works!
						'value'   => '', // This is ignored, but is necessary...
					],
					[
						'key'   => 'bkb_rkb_status',
						'value' => 0,
					],
				];
		} elseif ( $current_user_role != '' && $current_user_role == 'administrator' ) {

				// Admin user
				$args['meta_query'] = [];
		} else {

				// Non Loggedin Users

				$args['meta_query'] = [

					[
						'key'   => 'bkb_rkb_status',
						'value' => 0,
					],
				];
		}

		$query = new \WP_Query( $args );

		$pageposts = $query->posts;

		$output  = [];
		$counter = 0;
		foreach ( $pageposts as $k => $v ) {

				$output[ $counter ]['title'] = $v->post_title;
				$output[ $counter ]['link']  = get_permalink( $v->ID );
				++$counter;
		}

		$results = $output;
		return $results;
	}
}
