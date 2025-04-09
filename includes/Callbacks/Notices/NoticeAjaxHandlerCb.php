<?php

namespace KAFWPB\Callbacks\Notices;

/**
 * Class NoticeAjaxHandlerCb
 *
 * Handles the notice ajax handler callbacks.
 *
 * @package KAFWPB
 */
class NoticeAjaxHandlerCb {

	/**
	 * Check the nonce for security.
	 *
	 * @param string $nonce The nonce to check.
	 * @param string $key The key associated with the nonce.
	 *
	 * @return bool True if the nonce is valid, false otherwise.
     */
	private function check_notice_nonce( $nonce, $key ) {
		return wp_verify_nonce( $nonce, 'dismiss_notice_' . $key );
	}

 	/**
	 * Saves the notice settings via AJAX.
	 */
	public function save_notice_settings() {

		$nonce = sanitize_text_field( $_POST['nonce'] );
		$key   = sanitize_text_field( $_POST['noticeKey'] );

		$data = [
			'key'    => $key,
			'status' => 0,
		];

		if ( $this->check_notice_nonce( $nonce, $key ) && current_user_can( 'manage_options' ) ) {
			// 1= notice closed by user, 0/empty=show the notice
			update_option( $key, 1 );
			$data['status'] = get_option( $key );
		} else {
			$data['status'] = 0;
		}

		echo wp_json_encode( $data );

		die();
	}
}
