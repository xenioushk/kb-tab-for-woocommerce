<?php

/**
 * Plugin Name:    KB Tab For WooCommerce - Knowledgebase Addon
 * Plugin URI:       https://1.envato.market/bkbm-wp
 * Description:      KB tab for woocommerce Addon allows you to convert your knowledge base posts in to WooCommerce product Knowledgebase item with in a minute. You can add unlimited number of knowledge base post as product knowledgebase items and using drag drop feature sort them according to you're choice.
 * Version:           1.1.4
 * Author:            Mahbub Alam Khan
 * Author URI:      https://bluewindlab.net
 * WP Requires at least: 6.0+
 * Text Domain:    bkb-kbtfw
 * Domain Path:     /languages/
 *
 * @package KTFWC
 * @author Mahbub Alam Khan
 * @license GPL-2.0+
 * @link https://codecanyon.net/user/xenioushk
 * @copyright 2025 BlueWindLab
 */

namespace KTFWC;

// security check.
defined( 'ABSPATH' ) || die( 'Unauthorized access' );

if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
	require_once __DIR__ . '/vendor/autoload.php';
}

// Load the plugin constants
if ( file_exists( __DIR__ . '/includes/Helpers/DependencyManager.php' ) ) {
	require_once __DIR__ . '/includes/Helpers/DependencyManager.php';
	Helpers\DependencyManager::register();
}

use KAFWPB\Base\Activate;
use KAFWPB\Base\Deactivate;

/**
 * Function to handle the activation of the plugin.
 *
 * @return void
 */
 function activate_plugin() { // phpcs:ignore
	$activate = new Activate();
	$activate->activate();
}

/**
 * Function to handle the deactivation of the plugin.
 *
 * @return void
 */
 function deactivate_plugin() { // phpcs:ignore
	Deactivate::deactivate();
}

register_activation_hook( __FILE__, __NAMESPACE__ . '\\activate_plugin' );
register_deactivation_hook( __FILE__, __NAMESPACE__ . '\\deactivate_plugin' );

/**
 * Function to handle the initialization of the plugin.
 *
 * @return void
 */
function init_ktfwc() {

	// Check if the parent plugin installed.
	if ( ! class_exists( 'BwlKbManager\\Init' ) ) {
		add_action( 'admin_notices', [ Helpers\DependencyManager::class, 'notice_missing_main_plugin' ] );
		return;
	}

    // Check if the WooCommerce plugin installed.
	if ( ! class_exists( 'WooCommerce' ) ) {
        add_action( 'admin_notices', [ Helpers\DependencyManager::class, 'notice_missing_woocommerce_plugin' ] );
        return;
    }

	// Check parent plugin activation status.
	if ( ! ( Helpers\DependencyManager::get_product_activation_status() ) ) {
		add_action( 'admin_notices', [ Helpers\DependencyManager::class, 'notice_missing_purchase_verification' ] );
		return;
	}

	if ( class_exists( 'KTFWC\\Init' ) ) {
		Init::register_services();
	}
}

add_action( 'init', __NAMESPACE__ . '\\init_ktfwc' );


return;
define( 'BKBKBTFW_PARENT_PLUGIN_INSTALLED_VERSION', get_option( 'bwl_kb_plugin_version' ) );
define( 'BKBKBTFW_ADDON_PARENT_PLUGIN_TITLE', '<b>BWL Knowledge Base Manager Plugin</b> ' );
define( 'BKBKBTFW_ADDON_TITLE', '<b>KB Tab For WooCommerce</b>' );
define( 'BKBKBTFW_PARENT_PLUGIN_REQUIRED_VERSION', '1.4.2' ); // change plugin required version in here.
define( 'BKBKBTFW_ADDON_CURRENT_VERSION', '1.1.3' ); // change plugin current version in here.
define( 'BKBKBTFW_ADDON_PREFIX', 'bkb-kbtfw' ); // Addon Data Prefix. It must be simmilar with $plugin slug (kb-tab-for-woocommerce\public\class-kbtfw-addon.php).
define( 'BKBKBTFW_ADDON_UPDATER_SLUG', plugin_basename( __FILE__ ) ); // change plugin current version in here.

define( 'BKBKBTFW_ADDON_INSTALLATION_TAG', 'bkbm_kbtfw_installation_' . str_replace( '.', '_', BKBKBTFW_ADDON_CURRENT_VERSION ) );

define( 'BKBKBTFW_ADDON_CC_ID', '11342283' ); // Plugin codecanyon Id.

define( 'BKBKBTFW_DIR', plugin_dir_path( __FILE__ ) );
define( 'BKBKBTFW_PLUGIN_DIR', plugins_url() . '/kb-tab-for-woocommerce/' );

require_once plugin_dir_path( __FILE__ ) . 'public/class-kbtfw-addon.php';

register_activation_hook( __FILE__, [ 'BKB_kbtfw', 'activate' ] );
register_deactivation_hook( __FILE__, [ 'BKB_kbtfw', 'deactivate' ] );

add_action( 'plugins_loaded', [ 'BKB_kbtfw', 'get_instance' ] );

if ( is_admin() ) {
    include_once plugin_dir_path( __FILE__ ) . 'admin/class-kbtfw-addon-admin.php';
    add_action( 'plugins_loaded', [ 'BKB_kbtfw_Admin', 'get_instance' ] );
}
