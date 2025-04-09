<?php
namespace BKBRKB\Callbacks\Filters;

use BKBRKB\Helpers\RkbHelpers;
use BKBRKB\Helpers\PluginConstants;

/**
 * Class for registering taxonomy callback.
 *
 * @package BKBRKB
 * @since: 1.0.0
 * @author: Mahbub Alam Khan
 */
class TitleCb {

	/**
	 * Modify the post title.
	 *
	 * @param string $title The post title.
	 * @return string
	 */
	public function modify( $title ) {

		global $post;

		$options = PluginConstants::$plugin_options;

		$bkb_rkb_status        = intval( get_post_meta( $post->ID, 'bkb_rkb_status', true ) );
		$bkb_display_lock_icon = ( $bkb_rkb_status === 1 && empty( $options['bkb_rkb_lock_icon'] ) )
																					? " <i class='fa fa-lock'></i>" : ''; //phpcs:ignore

		return $title . $bkb_display_lock_icon;
	}
}
