<?php
namespace KTFWC\Helpers;

/**
 * Class for plugin constants.
 *
 * @package KTFWC
 */
class PluginConstants {

		/**
         * Static property to hold plugin options.
         *
         * @var array
         */
	public static $plugin_options = [];

	/**
	 * Initialize the plugin options.
	 */
	public static function init() {

		self::$plugin_options = get_option( 'bkb_options' );
	}

		/**
         * Get the relative path to the plugin root.
         *
         * @return string
         * @example wp-content/plugins/<plugin-name>/
         */
	public static function get_plugin_path(): string {
		return dirname( dirname( __DIR__ ) ) . '/';
	}


    /**
     * Get the plugin URL.
     *
     * @return string
     * @example http://appealwp.local/wp-content/plugins/<plugin-name>/
     */
	public static function get_plugin_url(): string {
		return plugin_dir_url( self::get_plugin_path() . KTFWC_PLUGIN_ROOT_FILE );
	}

	/**
	 * Register the plugin constants.
	 */
	public static function register() {
		self::init();
		self::set_paths_constants();
		self::set_base_constants();
		self::set_assets_constants();
		self::set_updater_constants();
		self::set_product_info_constants();
	}

	/**
	 * Set the plugin base constants.
     *
	 * @example: $plugin_data = get_plugin_data( KTFWC_PLUGIN_DIR . '/' . KTFWC_PLUGIN_ROOT_FILE );
	 * echo '<pre>';
	 * print_r( $plugin_data );
	 * echo '</pre>';
	 * @example_param: Name,PluginURI,Description,Author,Version,AuthorURI,RequiresAtLeast,TestedUpTo,TextDomain,DomainPath
	 */
	private static function set_base_constants() {

		$plugin_data = get_plugin_data( KTFWC_PLUGIN_DIR . '/' . KTFWC_PLUGIN_ROOT_FILE );

		define( 'KTFWC_PLUGIN_VERSION', $plugin_data['Version'] ?? '1.0.0' );
		define( 'KTFWC_PLUGIN_TITLE', $plugin_data['Name'] ?? 'KB Tab For WooCommerce Addon' );
		define( 'KTFWC_TRANSLATION_DIR', $plugin_data['DomainPath'] ?? '/languages/' );
		define( 'KTFWC_TEXT_DOMAIN', $plugin_data['TextDomain'] ?? '' );

		define( 'KTFWC_PLUGIN_FOLDER', 'kb-tab-for-woocommerce' );
		define( 'KTFWC_PLUGIN_CURRENT_VERSION', KTFWC_PLUGIN_VERSION );
		define( 'KTFWC_PLUGIN_POST_TYPE', 'bwl_kb' );
		define( 'KTFWC_PLUGIN_TAXONOMY_CAT', 'bkb_category' );
		define( 'KTFWC_PLUGIN_TAXONOMY_TAGS', 'bkb_tags' );
	}

	/**
	 * Set the plugin paths constants.
	 */
	private static function set_paths_constants() {
		define( 'KTFWC_PLUGIN_ROOT_FILE', 'kb-tab-for-woocommerce.php' );
		define( 'KTFWC_PLUGIN_DIR', self::get_plugin_path() );
		define( 'KTFWC_PLUGIN_FILE_PATH', KTFWC_PLUGIN_DIR );
		define( 'KTFWC_PLUGIN_URL', self::get_plugin_url() );
	}

	/**
	 * Set the plugin assets constants.
	 */
	private static function set_assets_constants() {
		define( 'KTFWC_PLUGIN_STYLES_ASSETS_DIR', KTFWC_PLUGIN_URL . 'assets/styles/' );
		define( 'KTFWC_PLUGIN_SCRIPTS_ASSETS_DIR', KTFWC_PLUGIN_URL . 'assets/scripts/' );
		define( 'KTFWC_PLUGIN_LIBS_DIR', KTFWC_PLUGIN_URL . 'libs/' );
	}

	/**
	 * Set the updater constants.
	 */
	private static function set_updater_constants() {

		// Only change the slug.
		$slug        = 'bkbm/notifier_bkbm_kbtfw.php';
		$updater_url = "https://projects.bluewindlab.net/wpplugin/zipped/plugins/{$slug}";

		define( 'KTFWC_PLUGIN_UPDATER_URL', $updater_url ); // phpcs:ignore
		define( 'KTFWC_PLUGIN_UPDATER_SLUG', KTFWC_PLUGIN_FOLDER . '/' . KTFWC_PLUGIN_ROOT_FILE ); // phpcs:ignore
		define( 'KTFWC_PLUGIN_PATH', KTFWC_PLUGIN_DIR );
	}

	/**
	 * Set the product info constants.
	 */
	private static function set_product_info_constants() {
		define( 'KTFWC_PRODUCT_ID', '11342283' ); // Plugin codecanyon/themeforest Id.
		define( 'KTFWC_PRODUCT_INSTALLATION_TAG', 'bkbm_kbtfw_installation_' . str_replace( '.', '_', KTFWC_PLUGIN_VERSION ) );
	}
}
