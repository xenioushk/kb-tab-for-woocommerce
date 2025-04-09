<?php
namespace BKBRKB\Callbacks\Filters;

use BKBRKB\Helpers\RkbHelpers;
use BKBRKB\Helpers\PluginConstants;

/**
 * Class for registering post access callabck.
 *
 * @package BKBRKB
 * @since: 1.0.0
 * @author: Mahbub Alam Khan
 */
class PostAccessCb {

	/**
	 * Check post access status.
	 *
	 * @param int $post_id Post ID.
	 * @return string
	 */
	public function check_status( $post_id ) {

		$options = PluginConstants::$plugin_options;

		// First we check if global KB access disable status. If global status is 1 then we allow all kind of users
		// to access all the KB content.
		if ( isset( $options['bkb_rkb_global_status'] ) && $options['bkb_rkb_global_status'] == 1 ) {
				return 1;
		}

		// Secondly, if global access disable is false then we need to check each post current access status.
		// Admin can individually set restriction.
		// Return 1 if user can access the content. Else Return a message.
		$allowed_message = 1;

		// Get Access Restriction Staus.
		$bkb_rkb_status = intval( get_post_meta( $post_id, 'bkb_rkb_status', true ) );

		// So, if status is 1 then we need to check user compatibility to access current post.

		if ( $bkb_rkb_status === 1 ) {

				// Checking user compatibility in here.
				$bkb_rkb_allow_post_access_status = RkbHelpers::can_user_access( $post_id );

				// If post access status return 1 then user can access the page other wise we display a notification message.
				// Admin can set custom message for access restriction.

			if ( $bkb_rkb_allow_post_access_status != 1 ) {

				if ( isset( $options['bkb_rkb_single_kb_msg'] ) && ! empty( $options['bkb_rkb_single_kb_msg'] ) ) {

						$allowed_message = RkbHelpers::display_safe_html( $options['bkb_rkb_single_kb_msg'] );
				} else {
						$bkb_wp_login_url = home_url() . '/wp-admin/';
						$allowed_message  = __( 'Sorry, you are not allowed to access the knowledgebase content.', 'bkb_rkb' ) .
								' <a href=' . $bkb_wp_login_url . ' target="_blank">' . __( 'Log In', 'bkb_rkb' ) . '</a> ' . __( 'required to access the content', 'bkb_rkb' );
				}
			}
		}

		return $allowed_message;
	}
}
