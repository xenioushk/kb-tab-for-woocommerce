<?php

/**
 * Plugin Name:    KB Tab For WooCommerce - Knowledgebase Addon
 * Plugin URI:       https://1.envato.market/bkbm-wp
 * Description:      KB tab for woocommerce Addon allows you to convert you're knowledge base posts in to WooCommerce product Knowledgebase item with in a minute. You can add unlimited number of knowledge base post as product knowledgebase items and using drag drop feature sort them according to you're choice.
 * Version:           1.1.2
 * Author:            Mahbub Alam Khan
 * Author URI:      https://bluewindlab.net
 * Text Domain:    bkb-kbtfw
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

define('BKBKBTFW_PARENT_PLUGIN_INSTALLED_VERSION', get_option('bwl_kb_plugin_version'));
define('BKBKBTFW_ADDON_PARENT_PLUGIN_TITLE', '<b>BWL Knowledge Base Manager Plugin</b> ');
define('BKBKBTFW_ADDON_TITLE', '<b>KB Tab For WooCommerce</b>');
define('BKBKBTFW_PARENT_PLUGIN_REQUIRED_VERSION', '1.4.2'); // change plugin required version in here.
define('BKBKBTFW_ADDON_CURRENT_VERSION', '1.1.2'); // change plugin current version in here.
define('BKBKBTFW_ADDON_PREFIX', 'bkb-kbtfw'); // Addon Data Prefix. It must be simmilar with $plugin slug (kb-tab-for-woocommerce\public\class-kbtfw-addon.php).
define('BKBKBTFW_ADDON_UPDATER_SLUG', plugin_basename(__FILE__)); // change plugin current version in here.

define("BKBKBTFW_ADDON_CC_ID", "11342283"); // Plugin codecanyon Id.

define('BKBKBTFW_DIR', plugin_dir_path(__FILE__));
define("BKBKBTFW_PLUGIN_DIR", plugins_url() . '/kb-tab-for-woocommerce/');

require_once(plugin_dir_path(__FILE__) . 'public/class-kbtfw-addon.php');

register_activation_hook(__FILE__, array('BKB_kbtfw', 'activate'));
register_deactivation_hook(__FILE__, array('BKB_kbtfw', 'deactivate'));

add_action('plugins_loaded', array('BKB_kbtfw', 'get_instance'));

if (is_admin()) {
    require_once(plugin_dir_path(__FILE__) . 'admin/class-kbtfw-addon-admin.php');
    add_action('plugins_loaded', array('BKB_kbtfw_Admin', 'get_instance'));
}
