<?php

class BKB_kbtfw_Admin
{

    protected static $instance = null;

    protected $plugin_screen_hook_suffix = null;

    private function __construct()
    {

        //@Description: First we need to check if KB Plugin & WooCommerce is activated or not. If not then we display a message and return false.
        //@Since: Version 1.0.5

        if (!class_exists('BWL_KB_Manager') || !class_exists('WooCommerce') || BKBKBTFW_PARENT_PLUGIN_INSTALLED_VERSION < '1.0.5') {
            add_action('admin_notices', array($this, 'kbtfw_version_update_admin_notice'));
            return false;
        }

        // Start Plugin Admin Panel Code.

        $plugin = BKB_kbtfw::get_instance();
        $this->plugin_slug = $plugin->get_plugin_slug();
        $post_types = 'product';

        add_action('admin_init', array($this, 'kbtfw_cmb_framework'));

        add_action('admin_enqueue_scripts', array($this, 'bkb_kbtfw_admin_enqueue_scripts'));

        // After manage text we need to add "custom_post_type" value.
        add_filter('manage_' . $post_types . '_posts_columns', array($this, 'kbtfw_custom_column_header'));

        // After manage text we need to add "custom_post_type" value.
        add_action('manage_' . $post_types . '_posts_custom_column', array($this, 'kbtfw_display_custom_column'), 10, 1);


        // Quick & Bulk Edit Section.

        add_action('bulk_edit_custom_box', array($this, 'kbtfw_product_quick_edit_box'), 10, 2);
        add_action('quick_edit_custom_box', array($this, 'kbtfw_product_quick_edit_box'), 10, 2);

        add_action('save_post', array($this, 'kbtfw_product_save_quick_edit_data'), 10, 2);
        add_action('wp_ajax_manage_wp_posts_using_bulk_edit_kbtfw', array($this, 'manage_wp_posts_using_bulk_edit_kbtfw'));
    }

    /**
     * Return an instance of this class.
     *
     * @since     1.0.0
     *
     * @return    object    A single instance of this class.
     */
    public static function get_instance()
    {

        /*
         * @TODO :
         *
         * - Uncomment following lines if the admin class should only be available for super admins
         */
        /* if( ! is_super_admin() ) {
          return;
          } */

        // If the single instance hasn't been set, set it now.
        if (null == self::$instance) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    //Version Manager:  Update Checking

    public function kbtfw_version_update_admin_notice()
    {


        echo '<div class="updated"><p>You need to download & install both '
            . '<b><a href="http://downloads.wordpress.org/plugin/woocommerce.zip" target="_blank">WooCommerce Plugin</a></b> && '
            . '<b><a href="https://1.envato.market/bkbm-wp" target="_blank">BWL Knowledge Base Manager Plugin</a></b> '
            . 'to use <b>KB Tab For WooCommerce - Knowledgebase Addon</b>. </p></div>';
    }

    /**
     * Register and enqueues public-facing JavaScript files.
     *
     * @since    1.0.0
     */
    public function bkb_kbtfw_admin_enqueue_scripts($hook)
    {

        // We only load this JS script in product add/edit page.

        $current_post_type = "";

        if (isset($_GET['post_type']) && $_GET['post_type'] == "product") {

            $current_post_type = "product";
        } else if (isset($_GET['post']) && get_post_type($_GET['post']) === 'product') {

            $current_post_type = "product";
        } else {

            $current_post_type = "";
        }

        if ($current_post_type == "product") {

            wp_register_script('bkb-cmb-admin-main', BWL_KB_PLUGIN_DIR . 'includes/bkb-cmb-framework/admin/js/bkb_cmb.js', array('jquery', 'jquery-ui-core', 'jquery-ui-sortable'), false, false);
            wp_register_style('bkb-cmb-admin-style', BWL_KB_PLUGIN_DIR . 'includes/bkb-cmb-framework/admin/css/bkb_cmb.css', array(), false, 'all');

            wp_enqueue_script('bkb-cmb-admin-main');
            wp_enqueue_style('bkb-cmb-admin-style');

            wp_enqueue_script($this->plugin_slug . '-admin-custom-script', plugins_url('assets/js/kbtfw-admin-scripts.js', __FILE__), array('jquery'), BKB_kbtfw::VERSION, TRUE);
        } else {

            return;
        }
    }

    function kbtfw_cmb_framework()
    {

        $args = array(
            'post_status' => 'publish',
            'post_type' => 'bwl_kb',
            'orderby' => 'title',
            'order' => 'ASC',
            'posts_per_page' => -1
        );

        $loop = new WP_Query($args);

        $kbftw_kb_post_ids = array();

        if ($loop->have_posts()) :

            while ($loop->have_posts()) :

                $loop->the_post();

                $bkb_title = ucfirst(get_the_title());

                $bkb_post_id = get_the_ID();

                $kbftw_kb_post_ids[$bkb_post_id] = $bkb_title;

            endwhile;

        endif;

        wp_reset_query();

        $cmb_bkb_woo_item_fields = array(

            'meta_box_id'           => 'cmb_bkb_woo_item_settings', // Unique id of meta box.
            'meta_box_heading'  => 'Knowledgebase Item Settings', // That text will be show in meta box head section.
            'post_type'               => 'product', // define post type. go to register_post_type method to view post_type name.        
            'context'                   => 'normal',
            'priority'                    => 'high',
            'fields'                       => array(

                'bkb_woo_tab_hide_status'  => array(
                    'title'      => __('Hide Knowledge Base Tab?', 'bkb-kbtfw'),
                    'id'         => 'bkb_woo_tab_hide_status',
                    'name'    => 'bkb_woo_tab_hide_status',
                    'type'      => 'select',
                    'value'     => array(
                        '1' => __('Yes', 'bkb-kbtfw'),
                        '2' => __('No', 'bkb-kbtfw')
                    ),
                    'default_value' => 2,
                    'class'      => 'widefat'
                ),
                'kbftw_kb_post_ids'  => array(
                    'title'      => __('Add Knowledgebase Items', 'bkb-kbtfw'),
                    'id'         => 'kbftw_kb_post_ids',
                    'name'    => 'kbftw_kb_post_ids',
                    'type'      => 'repeatable_select',
                    'value'     => '',
                    'default_value' => $kbftw_kb_post_ids,
                    'class'      => 'widefat',
                    'btn_text'      => 'Add New KB',
                    'label_text'      => 'KB Post',
                    'field_type' => 'select'
                ),
            )
        );


        // new BKB_Meta_Box( $cmb_bkb_woo_item_fields );

    }

    function kbtfw_custom_column_header($columns)
    {

        return array_merge(
            $columns,
            array(
                'kbftw_kb_post_ids' => __('Total <br />KBs', 'bkb-kbtfw'),
                'bkb_woo_tab_hide_status' => __('KB Tab <br />Status', 'bkb-kbtfw')
            )
        );
    }

    function kbtfw_display_custom_column($column)
    {

        // Add A Custom Image Size For Admin Panel.

        global $post;

        switch ($column) {

            case 'kbftw_kb_post_ids':

                $kbftw_kb_post_ids = (int) count(apply_filters('filter_kbtfwc_content_data', get_post_meta($post->ID, 'kbftw_kb_post_ids')));
                echo '<div id="kbftw_kb_post_ids-' . $post->ID . '" >&nbsp;' . $kbftw_kb_post_ids . '</div>';

                break;

            case 'bkb_woo_tab_hide_status':

                $bkb_woo_tab_hide_status = (get_post_meta($post->ID, "bkb_woo_tab_hide_status", true) == "") ? "" : get_post_meta($post->ID, "bkb_woo_tab_hide_status", true);

                // FAQ Display Status In Text.

                $bkb_woo_tab_hide_status_in_text = ($bkb_woo_tab_hide_status == 1) ? __("Hidden", "bkb-kbtfw") : __("Visible", "bkb-kbtfw");

                echo '<div id="bkb_woo_tab_hide_status-' . $post->ID . '" data-status_code="' . $bkb_woo_tab_hide_status . '" >' . $bkb_woo_tab_hide_status_in_text . '</div>';

                break;
        }
    }

    /* ------------------------------ Bulk & Quick Edit Section --------------------------------- */

    function kbtfw_product_quick_edit_box($column_name, $post_type)
    {

        global $post;

        switch ($post_type) {

            case $post_type:

                switch ($column_name) {

                    case 'bkb_woo_tab_hide_status':

                        $bkb_woo_tab_hide_status_val = get_post_meta($post->ID, "bkb_woo_tab_hide_status", true);

                        $bkb_woo_tab_hide_status = ($bkb_woo_tab_hide_status_val == "") ? "" : $bkb_woo_tab_hide_status_val;

?>


                        <fieldset class="inline-edit-col-left">
                            <div class="inline-edit-col">
                                <div class="inline-edit-group">
                                    <label class="alignleft">

                                        <span class="checkbox-title"><?php _e('Hide KB Tab?', 'bkb-kbtfw'); ?></span>
                                        <select name="bkb_woo_tab_hide_status">
                                            <option value="3"><?php _e('- No Change -', 'bkb-kbtfw'); ?></option>
                                            <option value="1"><?php _e('Yes', 'bkb-kbtfw'); ?></option>
                                            <option value="2"><?php _e('No', 'bkb-kbtfw'); ?></option>
                                        </select>
                                    </label>

                                </div>
                            </div>
                        </fieldset>


                    <?php
                        break;
                }

                break;
        }
    }

    function kbtfw_product_save_quick_edit_data($post_id, $post)
    {

        // pointless if $_POST is empty (this happens on bulk edit)
        if (empty($_POST))
            return $post_id;

        // verify quick edit nonce
        if (isset($_POST['_inline_edit']) && !wp_verify_nonce($_POST['_inline_edit'], 'inlineeditnonce'))
            return $post_id;

        // don't save for autosave
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
            return $post_id;

        // dont save for revisions
        if (isset($post->post_type) && $post->post_type == 'revision')
            return $post_id;

        switch ($post->post_type) {

            case $post->post_type:

                /**
                 * Because this action is run in several places, checking for the array key
                 * keeps WordPress from editing data that wasn't in the form, i.e. if you had
                 * this post meta on your "Quick Edit" but didn't have it on the "Edit Post" screen.
                 */
                $custom_fields = array('bkb_woo_tab_hide_status');

                foreach ($custom_fields as $field) {

                    if (array_key_exists($field, $_POST)) {

                        update_post_meta($post_id, $field, $_POST[$field]);
                    }
                }

                break;
        }
    }

    function kbtfw_product_bulk_edit_box($column_name, $post_type)
    {

        global $post;

        switch ($post_type) {

            case $post_type:

                switch ($column_name) {

                    case 'bkb_woo_tab_hide_status':
                    ?>
                        <fieldset class="inline-edit-col-right">
                            <div class="inline-edit-col">
                                <div class="inline-edit-group">
                                    <label class="alignleft">
                                        <span class="checkbox-title"><?php _e('Hide FAQ Tab?', 'bkb-kbtfw'); ?></span>
                                        <select name="bkb_woo_tab_hide_status">
                                            <option value="3"><?php _e('- No Change -', 'bkb-kbtfw'); ?></option>
                                            <option value="1"><?php _e('Yes', 'bkb-kbtfw'); ?></option>
                                            <option value="2"><?php _e('No', 'bkb-kbtfw'); ?></option>
                                        </select>
                                    </label>
                                </div>
                            </div>
                        </fieldset>

<?php
                        break;
                }

                break;
        }
    }

    function manage_wp_posts_using_bulk_edit_kbtfw()
    {

        // we need the post IDs
        $post_ids = (isset($_POST['post_ids']) && !empty($_POST['post_ids'])) ? $_POST['post_ids'] : NULL;

        // if we have post IDs
        if (!empty($post_ids) && is_array($post_ids)) {

            // Get the custom fields

            $custom_fields = array('bkb_woo_tab_hide_status');

            foreach ($custom_fields as $field) {

                // if it has a value, doesn't update if empty on bulk
                if (isset($_POST[$field]) && trim($_POST[$field]) != "") {

                    // update for each post ID
                    foreach ($post_ids as $post_id) {

                        if ($_POST[$field] == 2) {

                            update_post_meta($post_id, $field, "");
                        } elseif ($_POST[$field] == 1) {

                            update_post_meta($post_id, $field, 1);
                        } else {
                            // do nothing
                        }
                    }
                }
            }
        }
    }
}
