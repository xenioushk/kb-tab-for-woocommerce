<?php

use BwlKbManager\Base\BaseController;
use BwlKbManager\Api\CmbMetaBoxApi;


class BKB_kbtfw_Admin {


    protected static $instance = null;
    public $plugin_slug;
    public $baseController; // parent controller of the addon.
    protected $plugin_screen_hook_suffix = null;

    private function __construct() {

        // Start Plugin Admin Panel Code.

        $plugin               = BKB_kbtfw::get_instance();
        $this->plugin_slug    = $plugin->get_plugin_slug();
        $this->baseController = new BaseController();
        $post_types           = 'product';

        add_action( 'admin_init', [ $this, 'kbtfw_cmb_framework' ] );

        // Quick & Bulk Edit Section.

        add_action( 'save_post', [ $this, 'kbtfw_product_save_quick_edit_data' ], 10, 2 );
    }

    public static function get_instance() {

        // If the single instance hasn't been set, set it now.
        if ( null == self::$instance ) {
            self::$instance = new self();
        }

        return self::$instance;
    }



    function kbtfw_cmb_framework() {

        $args = [
            'post_status'    => 'publish',
            'post_type'      => $this->baseController->plugin_post_type,
            'orderby'        => 'title',
            'order'          => 'ASC',
            'posts_per_page' => -1,
        ];

        $loop = new WP_Query( $args );

        $kbftw_kb_post_ids = [];

        if ( $loop->have_posts() ) :

            while ( $loop->have_posts() ) :

                $loop->the_post();

                $bkb_title = ucfirst( get_the_title() );

                $bkb_post_id = get_the_ID();

                $kbftw_kb_post_ids[ $bkb_post_id ] = $bkb_title;

            endwhile;

        endif;

        wp_reset_query();

        $custom_fields = [

            'meta_box_id'      => 'cmb_bkb_woo_item_settings', // Unique id of meta box.
            'meta_box_heading' => 'Knowledgebase Item Settings', // That text will be show in meta box head section.
            'post_type'        => 'product', // define post type. go to register_post_type method to view post_type name.
            'context'          => 'normal',
            'priority'         => 'high',
            'fields'           => [

                'bkb_woo_tab_hide_status' => [
                    'title'         => __( 'Hide Knowledge Base Tab?', 'bkb-kbtfw' ),
                    'id'            => 'bkb_woo_tab_hide_status',
                    'name'          => 'bkb_woo_tab_hide_status',
                    'type'          => 'select',
                    'value'         => [
                        '1' => __( 'Yes', 'bkb-kbtfw' ),
                        '2' => __( 'No', 'bkb-kbtfw' ),
                    ],
                    'default_value' => 2,
                    'class'         => 'widefat',
                ],
                'kbftw_kb_post_ids' => [
                    'title'         => __( 'Add Knowledgebase Items', 'bkb-kbtfw' ),
                    'id'            => 'kbftw_kb_post_ids',
                    'name'          => 'kbftw_kb_post_ids',
                    'type'          => 'repeatable_select',
                    'value'         => '',
                    'default_value' => $kbftw_kb_post_ids,
                    'class'         => 'widefat',
                    'btn_text'      => 'Add New KB',
                    'label_text'    => 'KB Post',
                    'field_type'    => 'select',
                ],
            ],
        ];

        // A new meta box will be created in KB add/edit page.
        if ( class_exists( 'BwlKbManager\\Init' ) ) {
            new CmbMetaBoxApi( $custom_fields );
        }
    }
}
