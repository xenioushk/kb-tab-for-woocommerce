<?php
namespace BKBRKB\Callbacks\Filters;

use BKBRKB\Helpers\RkbHelpers;
use BKBRKB\Helpers\PluginConstants;

/**
 * Class for registering query filter callback.
 *
 * @package BKBRKB
 * @since: 1.0.0
 * @author: Mahbub Alam Khan
 */
class QueryFilterCb {

	/**
	 * Apply the filter to the query arguments.
	 *
	 * @param array $args The query arguments.
	 * @return array
	 */
	public function apply( $args ) {

		$options = PluginConstants::$plugin_options;

		// If Restriction plugin is activated but the user want to allow all KB contents for all user then
		// Plugin will not modify Meta query arguments.

		if ( isset( $options['bkb_rkb_global_status'] ) && $options['bkb_rkb_global_status'] == 1 ) {
				return $args;
		}

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
					'relation' => 'OR',
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
		} elseif ( $current_user_role != '' && $current_user_role != 'administrator' && $bkb_rkb_all_kb_display_status == 0 ) {

				// This area for checking logged in users capability.

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
		} else {
		}

		return $args;
	}
}
