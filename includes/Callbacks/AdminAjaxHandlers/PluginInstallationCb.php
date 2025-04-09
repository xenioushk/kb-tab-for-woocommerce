<?php

namespace BKBRKB\Callbacks\AdminAjaxHandlers;

use BKBRKB\Traits\PluginInstallationTraits;

/**
 * Class for plugin installation callback.
 *
 * @package BKBRKB
 */
class PluginInstallationCb {

	use PluginInstallationTraits;

	/**
	 * Save the installation data.
	 */
	public function save() {

		// Default.
		$data = [
			'status' => 0,
		];

		if ( ! current_user_can( 'manage_options' ) ) {
			echo wp_json_encode( $data );
			wp_die();
		}

		$api_url    = $this->bwl_api_url();
		$site_url   = get_site_url();
		$product_id = BKBRKB_PRODUCT_ID;
		$ip         = $_SERVER['REMOTE_ADDR'];
		$ver        = BKBRKB_PLUGIN_VERSION;
		$requestUrl = $api_url . "wp-json/bwlapi/v1/installation/count?product_id=$product_id&site=$site_url&referer=$ip&ver=$ver";

		$output = wp_remote_get( $requestUrl );

		if ( is_array( $output ) && ! is_wp_error( $output ) && wp_remote_retrieve_response_code( $output ) === 200 ) {

			$data = wp_remote_retrieve_body( $output ); // Get the response body.

			$output_decode = json_decode( $data, true );

			if ( isset( $output_decode['status'] ) && $output_decode['status'] != 0 ) {

				update_option( BKBRKB_PRODUCT_INSTALLATION_TAG, 1 ); // change the tag

				$data = [
					'status' => $output_decode['status'],
					'msg'    => $output_decode['msg'],
				];
			}
		} elseif ( is_wp_error( $output ) ) {
				// Handle WP_Error case.
				$error_message = $output->get_error_message();
				$data          = [
					'msg' => $error_message,
				];
		} else {
			// Handle non-200 status codes.
			$status_code = wp_remote_retrieve_response_code( $output );

			$data = [
				'msg' => "Request failed with status code: $status_code",
			];
		}

		echo wp_json_encode( $data );

		wp_die();
	}
}
