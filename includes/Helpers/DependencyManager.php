<?php
namespace KTFWC\Helpers;

/**
 * Class for plugin dependency manager.
 *
 * @package KTFWC
 */
class DependencyManager {

	/**
	 * Allowed themes.
	 *
	 * @var array
	 */
	public static $allowed_themes = [ 'knowledgedesk', 'knowledgedesk Child' ];

	/**
	 * Plugin parent BKBM URL.
	 *
	 * @var string
	 */
	public static $bkbm_url;
	/**
	 * Plugin parent BKBM license URL.
	 *
	 * @var string
	 */
	public static $bkbm_license_url;
	/**
     * Plugin parent WPBakery Page Builder URL.
     *
     * @var string
     */
	public static $woocommerce_url;

	/**
	 * Plugin addon title.
	 *
	 * @var string
	 */
	public static $addon_title;

	/**
	 * Register the plugin constants.
	 */
	public static function register() {
		self::set_dependency_constants();
		self::set_urls();
	}

	/**
	 * Set the plugin dependency URLs.
	 */
	private static function set_urls() {
		self::$bkbm_url         = "<strong><a href='https://1.envato.market/bkbm-wp' target='_blank'>BWL Knowledge Base Manager</a></strong>";
		self::$bkbm_license_url = "<strong><a href='" . admin_url( 'edit.php?post_type=bwl_kb&page=bkb-license' ) . "'>BWL Knowledge Base Manager license</a></strong>";
		self::$addon_title      = '<strong>KB Tab For WooCommerce Addon</strong>';
		self::$woocommerce_url  = "<strong><a href='https://downloads.wordpress.org/plugin/woocommerce.zip' target='_blank'>WooCommerce</a></strong>";
	}

	/**
	 * Set the plugin dependency constants.
	 */
	private static function set_dependency_constants() {
		define( 'KTFWC_MIN_BKBM_VERSION', '1.5.5' );
		define( 'KTFWC_MIN_PHP_VERSION', '7.0' );
	}

	/**
	 * Set the product activation constants.
     *
	 * @return bool
	 */
	public static function get_product_activation_status() {
		$kdesk_bundle = 0;

		if ( function_exists( 'wp_get_theme' ) ) {
			// Get the current active theme info
			$currentTheme = \wp_get_theme();

			// Checking if current theme exists in the allowed theme list .
			if ( in_array( $currentTheme->get( 'Name' ), self::$allowed_themes, true ) ) {
				$kdesk_bundle = 1;
			}
		}

		if ( $kdesk_bundle === 1 ) {
			$purchase_status = 1;
		} elseif ( intval( get_option( 'bkbm_purchase_verified' ) ) === 1 ) {
			$purchase_status = 1;
		} else {
			$purchase_status = 0;
		}

		return $purchase_status;

	}

	/**
     * Function to handle the missing plugin notice.
     *
     * @return void
     */
	public static function notice_missing_main_plugin() {

		$message = sprintf(
						// translators: 1: Plugin name, 2: Addon title
            esc_html__( 'Please install and activate the %1$s plugin to use %2$s.', 'bkb_vc' ),
            self::$bkbm_url,
            self::$addon_title
		);

	printf( '<div class="notice notice-error"><p>⚠️ %1$s</p></div>', $message ); // phpcs:ignore
	}

	/**
     * Function to handle the missing woocommerce plugin notice.
     *
     * @return void
     */
	public static function notice_missing_woocommerce_plugin() {

		$message = sprintf(
						// translators: 1: Plugin name, 2: Addon title
            esc_html__( 'Please install and activate the %1$s plugin to use %2$s.', 'bkb_vc' ),
            self::$woocommerce_url,
            self::$addon_title
		);

		printf( '<div class="notice notice-error"><p>⚠️ %1$s</p></div>', $message ); // phpcs:ignore
	}

	/**
     * Function to handle the purchase verification notice.
     *
     * @return void
     */
	public static function notice_missing_purchase_verification() {

		$message = sprintf(
						// translators: 1: Plugin activation link, 2: Addon title
            esc_html__( 'Please Activate the %1$s to use the %2$s.', 'bkb_vc' ),
            self::$bkbm_license_url,
            self::$addon_title
		);

		printf( '<div class="notice notice-error"><p>🔑 %1$s</p></div>', $message ); // phpcs:ignore
	}
}
