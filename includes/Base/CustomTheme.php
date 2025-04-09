<?php
namespace KAFWPB\Base;

/**
 * Class for plugin custom theme.
 *
 * @since: 1.1.0
 * @package KAFWPB
 */
class CustomTheme {

  	/**
     * Register methods
     */
	public function register() {
		add_action( 'wp_head', [ $this, 'get_custom_theme' ] );
	}

	/**
	 * Get the custom theme.
	 */
	public function get_custom_theme() {

		$custom_theme = "<style type='text/css'> 
			.bkb-counter-container {
					margin: 48px 0;
			}

			.bkb_counter_icon {
					font-size: 54px;
			}

			.bkb_counter_value {
					font-size: 32px;
					line-height: 24px;
					display: block;
					margin: 12px 0 0 0;
					font-weight: bold;
			}

			.bkb_counter_title {
					font-size: 14px;
					line-height: 48px;
					text-transform: uppercase;
			}
		</style>";

		echo $custom_theme; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}
