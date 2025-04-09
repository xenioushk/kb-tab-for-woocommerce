<?php
namespace KAFWPB\Traits;

trait EmailTraits {
	/**
	 * Get the site domain.
     *
	 * @return string
	 */
	public function get_site_domain() {

		$url  = get_site_url();
		$host = wp_parse_url( $url, PHP_URL_HOST );

		return trim( $host );
	}
}
