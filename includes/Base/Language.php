<?php
namespace BKBRKB\Base;

/**
 * Class for plugin language.
 *
 * @since: 1.1.0
 * @package BKBRKB
 */
class Language {

  	/**
     * Register the plugin text domain.
     */
	public function register() {
		add_action( 'plugin_loaded', [ $this, 'load_plugin_textdomain' ] );
	}

	/**
     * Load the translation file.
     */
	public function load_plugin_textdomain() {
		$domain = BKBRKB_TEXT_DOMAIN; // only change here.
		$locale = \apply_filters( 'plugin_locale', get_locale(), $domain ); // returns en_US
		load_textdomain( $domain, trailingslashit( WP_LANG_DIR ) . $domain . '/' . $domain . '-' . $locale . '.mo' );
	}
}
