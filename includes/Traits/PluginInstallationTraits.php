<?php
namespace BKBRKB\Traits;

trait PluginInstallationTraits {
	/**
	 * Get the api url.
     *
	 * @return string
	 */
	public function bwl_api_url() {
		$baseUrl = get_home_url();
		if ( preg_match( '/(localhost|\.local)/', $baseUrl ) ) {
			return 'http://bwlapi.local/';
		}  elseif ( strpos( $baseUrl, 'staging.bluewindlab.com' ) != false ) {
				return 'https://staging.bluewindlab.com/bwl_api/';
		} else {
				return 'https://api.bluewindlab.net/';
		}
	}
}
