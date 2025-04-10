<?php
namespace KTFWC\Cmb;

use BwlKbManager\Api\CmbMetaBoxApi;

use WP_Query;

/**
 * Class for plugin custom meta box.
 *
 * @package KTFWC
 */
class KtfwcCmb {

    /**
     * Register the meta box.
     *
     * @return void
     */
    public function register() {
        add_action( 'admin_init', [ $this, 'init_ktwfc_cmb' ] );
    }

    /**
     * Initialize the meta box.
     *
     * @return void
     */
    public function init_ktwfc_cmb() {

        $custom_fields = [

            'meta_box_id'      => 'cmb_bkb_woo_item_settings', // Unique id
            'meta_box_heading' => 'Knowledgebase Item Settings',
            'post_type'        => 'product',
            'context'          => 'normal',
            'priority'         => 'high',
            'fields'           => [

                'bkb_woo_tab_hide_status' => [
                    'title'         => esc_html__( 'Hide Knowledge Base Tab?', 'bkb-kbtfw' ),
                    'id'            => 'bkb_woo_tab_hide_status',
                    'name'          => 'bkb_woo_tab_hide_status',
                    'type'          => 'select',
                    'value'         => [
                        '1' => esc_html__( 'Yes', 'bkb-kbtfw' ),
                        '2' => esc_html__( 'No', 'bkb-kbtfw' ),
                    ],
                    'default_value' => 2,
                    'class'         => 'widefat',
                ],
                'kbftw_kb_post_ids' => [
                    'title'         => esc_html__( 'Add Knowledgebase Items', 'bkb-kbtfw' ),
                    'id'            => 'kbftw_kb_post_ids',
                    'name'          => 'kbftw_kb_post_ids',
                    'type'          => 'repeatable_select',
                    'value'         => '',
                    'default_value' => $this->get_the_kb_posts(),
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

    /**
     * Get all the KB posts.
     *
     * @return array
     */
    private function get_the_kb_posts() {

        $args = [
            'post_status'    => 'publish',
            'post_type'      => BKBM_POST_TYPE,
            'orderby'        => 'title',
            'order'          => 'ASC',
            'posts_per_page' => -1,
        ];

        $loop = new WP_Query( $args );

        $post_ids = [];

        if ( $loop->have_posts() ) :

            while ( $loop->have_posts() ) :

                $loop->the_post();

                $post_ids[ get_the_ID() ] = ucfirst( get_the_title() );

            endwhile;

        endif;

        wp_reset_postdata();

        return $post_ids;
    }
}
