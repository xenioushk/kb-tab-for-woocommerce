<?php
namespace BKBRKB\Callbacks\Filters;

use BKBRKB\Helpers\PluginConstants;

use WP_Query;

/**
 * Class for registering blog filter callback.
 *
 * @package BKBRKB
 * @since: 1.0.0
 * @author: Mahbub Alam Khan
 */
class BlogFilterCb {


	/**
	 * Apply the filter to exclude posts.
	 *
	 * @param array $bkb_kbdabp_excluded_posts The array of excluded posts.
	 * @return array The modified array of excluded posts.
	 */
	public function apply( $bkb_kbdabp_excluded_posts ) {

		$options = PluginConstants::$plugin_options;

		// First we check if global KB access disable status. If global status is 1 then we allow all kind of users
		// to access all the KB content.
		if ( isset( $options['bkb_rkb_global_status'] ) && $options['bkb_rkb_global_status'] == 1 ) {
				return $bkb_kbdabp_excluded_posts;
		}

		$args = [
			'post_status'         => 'publish',
			'post_type'           => BKBM_POST_TYPE,
			'ignore_sticky_posts' => 1,
			'posts_per_page'      => -1,
		];

		// This portion only work for restriction add, on plugin.
		// First we need to check if the plugin has been installed & activated in the system or not.
		// If the plugin is activated then we check other options.

		$current_user      = wp_get_current_user(); // Get current user info.
		$current_user_role = '';
		// Extract Current User Role Info
		if ( isset( $current_user->roles[0] ) ) {
				$current_user_role = $current_user->roles[0];
		}

		// Initially we will not display restricted KB items with non-restricted items.
		$bkb_rkb_all_kb_display_status = 0;

		if ( isset( $options['bkb_rkb_all_kb_display_status'] ) && $options['bkb_rkb_all_kb_display_status'] == 'on' ) {
				// Allow to display all restricted items.
				$bkb_rkb_all_kb_display_status = 1;
		}

		if ( $current_user_role == '' && $bkb_rkb_all_kb_display_status == 0 ) {

				// Hide Restricted Posts.
				// Only non logged in users can see open KB posts.

				$args['meta_query'] = [
					[
						'key'   => 'bkb_rkb_status',
						'value' => 1,
					],
				];
		} elseif ( $current_user_role != '' && $current_user_role != 'administrator' && $bkb_rkb_all_kb_display_status == 0 ) {

				// This area for checking logged in users capability.

				$args['meta_query'] = [
					'relation' => 'OR',
					[
						'key'     => 'bkb_rkb_user_roles',
						'compare' => 'NOT LIKE', // works!
						'value'   => $current_user_role, // This is ignored, but is necessary...
					],
					[
						'key'     => 'bkb_rkb_status',
						'compare' => 'NOT EXISTS', // works!
						'value'   => '', // This is ignored, but is necessary...
					],
				];
		} else {

				// Default User Role Administrator. Just return the query.
				return $bkb_kbdabp_excluded_posts;
		}

		$loop = new WP_Query( $args );

		if ( count( $loop->posts ) > 0 ) {

			foreach ( $loop->posts as $posts ) {

					$bkb_kbdabp_excluded_posts[] = $posts->ID;
			}
		}

		wp_reset_postdata();

		return $bkb_kbdabp_excluded_posts;
	}
}
