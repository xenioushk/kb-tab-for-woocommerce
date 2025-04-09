<?php

use BwlKbManager\Base\BaseController;

class BKB_kbtfw {


    const VERSION              = BKBKBTFW_ADDON_CURRENT_VERSION;
    protected $plugin_slug     = 'bkb-kbtfw';
    protected static $instance = null;
    public $baseController; // parent controller of the addon.

    private function __construct() {

        if ( class_exists( 'BwlKbManager\\Init' ) && class_exists( 'WooCommerce' ) && BKBKBTFW_PARENT_PLUGIN_INSTALLED_VERSION > '1.0.5' ) {

            $this->baseController = new BaseController();

            // Load public-facing style sheet and JavaScript.
            add_filter( 'woocommerce_product_tabs', [ $this, 'kbtfw_add_custom_product_tab' ] );
            // Fixed in version 1.0.4
            add_filter( 'kbtfw_woocommerce_custom_product_tabs_content', 'do_shortcode' );
        }
    }


    public function get_plugin_slug() {
        return $this->plugin_slug;
    }


    public static function get_instance() {

        // If the single instance hasn't been set, set it now.
        if ( null == self::$instance ) {
            self::$instance = new self();
        }

        return self::$instance;
    }


    public static function activate( $network_wide ) {

        if ( function_exists( 'is_multisite' ) && is_multisite() ) {

            if ( $network_wide ) {

                // Get all blog ids
                $blog_ids = self::get_blog_ids();

                foreach ( $blog_ids as $blog_id ) {

                    switch_to_blog( $blog_id );
                    self::single_activate();
                }

                restore_current_blog();
            } else {
                self::single_activate();
            }
        } else {
            self::single_activate();
        }
    }

    public static function deactivate( $network_wide ) {

        if ( function_exists( 'is_multisite' ) && is_multisite() ) {

            if ( $network_wide ) {

                // Get all blog ids
                $blog_ids = self::get_blog_ids();

                foreach ( $blog_ids as $blog_id ) {

                    switch_to_blog( $blog_id );
                    self::single_deactivate();
                }

                restore_current_blog();
            } else {
                self::single_deactivate();
            }
        } else {
            self::single_deactivate();
        }
    }


    public function activate_new_site( $blog_id ) {

        if ( 1 !== did_action( 'wpmu_new_blog' ) ) {
            return;
        }

        switch_to_blog( $blog_id );
        self::single_activate();
        restore_current_blog();
    }

    private static function get_blog_ids() {

        global $wpdb;

        // get an array of blog ids
        $sql = "SELECT blog_id FROM $wpdb->blogs
			WHERE archived = '0' AND spam = '0'
			AND deleted = '0'";

        return $wpdb->get_col( $sql );
    }

    private static function single_activate() {
        // @TODO: Define activation functionality here
    }


    private static function single_deactivate() {
        // @TODO: Define deactivation functionality here
    }


    public function kbtfw_add_custom_product_tab( $tabs ) {

        global $product;

        // Get Data From Option Panel Settings.
        $bkb_data          = $this->baseController->bkb_data;
        $bkb_auto_hide_tab = 1; // Enable Auto hide
        $bkb_tab_title     = __( 'Knowledge Base ', 'bkb-kbtfw' ); // Set the title of Knowledgebase Tab.

        if ( isset( $bkb_data['bkb_woo_tab_title'] ) && $bkb_data['bkb_woo_tab_title'] != '' ) {
            $bkb_tab_title = $bkb_data['bkb_woo_tab_title']; // Introduced in version 1.0.1
        }

        $bkb_woo_tab_position = 100; // Set faq tab to the last position.

        if ( isset( $bkb_data['bkb_auto_hide_tab'] ) && $bkb_data['bkb_auto_hide_tab'] == '' ) {
            $bkb_auto_hide_tab = 0;
        }

        if ( $bkb_auto_hide_tab == 1 ) {

            // Count no of KB for current product.
            $kbftw_kb_post_ids = (int) count( get_post_meta( $product->get_id(), 'kbftw_kb_post_ids' ) );

            if ( $kbftw_kb_post_ids == 0 ) {
                return $tabs;
            }
        }

        if ( isset( $bkb_data['bkb_woo_tab_position'] ) && is_numeric( $bkb_data['bkb_woo_tab_position'] ) ) {

            $bkb_woo_tab_position = trim( $bkb_data['bkb_woo_tab_position'] );
        }

        // Specefic Product Knowledgebase Tab Hide section.

        $bkb_woo_tab_hide_status = get_post_meta( $product->get_id(), 'bkb_woo_tab_hide_status', true );

        // Checkbox to select conversion fix
        // Issue is: For checkbox data will saved in to string format. Means, if user checked the check box then
        // data saved as "on".  So, we are going to check that and trun this value in to a number..

        if ( isset( $bkb_woo_tab_hide_status ) && $bkb_woo_tab_hide_status == 'on' ) {
            $bkb_woo_tab_hide_status = 1;
        }

        if ( isset( $bkb_woo_tab_hide_status ) && $bkb_woo_tab_hide_status == 1 ) {

            return $tabs;
        }

        $kbtfw_total_kbss_string = '';

        $get_kbftw_kb_post_ids = apply_filters( 'filter_kbtfwc_content_data', get_post_meta( $product->get_id(), 'kbftw_kb_post_ids' ) );

        $kbftw_kb_post_ids = implode( ',',  $get_kbftw_kb_post_ids );

        $tabs['kbtfw_tab'] = [
			'title'    => $bkb_tab_title . $kbtfw_total_kbss_string,
			'priority' => $bkb_woo_tab_position, // Always display at the end of tab :)
			'callback' => [ $this, 'kbtfw_custom_tab_panel_content' ],
			'content'  => do_shortcode( '[bkb_woo_tab post_ids="' . $kbftw_kb_post_ids . '"/]' ), // custom field
        ];

        return $tabs;
    }

    public function kbtfw_custom_tab_panel_content( $key, $tab ) {

        // allow shortcodes to function
        $content = apply_filters( 'the_content', $tab['content'] );
        $content = str_replace( ']]>', ']]&gt;', $content );
        echo apply_filters( 'kbtfw_woocommerce_custom_product_tabs_content', $content, $tab );
    }
}
