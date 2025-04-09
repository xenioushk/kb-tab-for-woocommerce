<?php

namespace KAFWPB\Base;

/**
 * Class for plucin frontend inline js.
 *
 * @package KAFWPB
 * @since: 1.1.0
 * @auther: Mahbub Alam Khan
 */
class FrontendInlineJs {

	/**
	 * Register the methods.
	 */
	public function register() {
		add_action( 'wp_head', [ $this, 'set_inline_js' ] );
	}

	/**
	 * Set the inline js.
	 */
	public function set_inline_js() {

		$output = '';

		echo $output; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}
