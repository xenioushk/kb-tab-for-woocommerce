<?php

/**
 * Plugin Name:    KB Tab For WooCommerce - Knowledgebase Addon
 * Plugin URI:       https://1.envato.market/bkbm-wp
 * Description:      KB tab for woocommerce Addon allows you to convert your knowledge base posts in to WooCommerce product Knowledgebase item with in a minute. You can add unlimited number of knowledge base post as product knowledgebase items and using drag drop feature sort them according to you're choice.
 * Version:           2.1.0
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

use KTFWC\Base\Activate;
use KTFWC\Base\Deactivate;

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

	if ( class_exists( 'KTFWC\\Init' ) ) {

		// Check the required minimum version of the parent plugin.
		if ( ! ( Helpers\DependencyManager::check_minimum_version_requirement_status() ) ) {
			add_action( 'admin_notices', [ Helpers\DependencyManager::class, 'notice_min_version_main_plugin' ] );
			return;
		}

		Init::register_services();
	}
}

add_action( 'init', __NAMESPACE__ . '\\init_ktfwc' );
