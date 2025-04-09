<?php
namespace BKBRKB\Traits;

trait TraitAdminNotice {

	/**
	 * Display the admin notices.
	 *
	 * @param array $notice The notice to display.
	 */
    public function get_notice_html( $notice = [] ) {

		if ( empty( $notice ) ) {
			return;
		}

			$status         = $notice['status'] ?? 0;
			$is_dismissable = ( isset( $notice['is_dismissable'] ) && $notice['is_dismissable'] === 0 ) ? 0 : 1;

		if ( $is_dismissable === 0 ) {
			$dismissable_string = '';
			$dismissable_class  = '';
		} else {

			$nonce     = wp_create_nonce( 'dismiss_notice_' . $notice['key'] );
			$key       = $notice['key'];
			$btn_class = 'notice-dismiss bwl_remove_notice';

			$dismissable_string = "<button type='button' class='{$btn_class}' data-key='{$key}' data-nonce='{$nonce}'>
        <span class='screen-reader-text'>Dismiss this notice.</span>
        </button>";
			$dismissable_class  = ' is-dismissible';
		}

		if ( (int) $status !== 1 ) {

			$dismissable_class .= " notice notice-{$notice['noticeClass']}";
			$msg                = trim( $notice['msg'] );
			echo "<div class='{$dismissable_class}'>
                <p class='bwl_plugins_notice_text'>{$msg}</p>
                {$dismissable_string}
                </div>";
		}
	}
}
