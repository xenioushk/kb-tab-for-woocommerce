<?php

namespace KTFWC\Base;

use KTFWC\Helpers\PluginConstants;

/**
 * Class for plucin frontend inline js.
 *
 * @package KTFWC
 * @since: 1.1.0
 * @auther: Mahbub Alam Khan
 */
class FrontendInlineJs {

	/**
	 * Register the methods.
	 */
	public function register() {
		add_action( 'wp_head', [ $this, 'set_inline_js' ] );
	}

	/**
	 * Set the inline js.
	 */
	public function set_inline_js() {

		$options = PluginConstants::$plugin_options;

        $bkb_display_counter        = 1;
        $bkb_woo_theme              = 'default';
        $bkb_woo_animation          = 'fade';
        $bkb_highlighter_bg         = '#FFFF80';
        $bkb_highlighter_text_color = '#000000';
        $bkb_search_box_status      = 1;
        $bkb_rtl_mode               = false;
        $bkb_pagination_status      = true;
        $bkb_items_per_page         = 5;

        if ( isset( $options['bkb_display_counter'] ) && $options['bkb_display_counter'] == '' ) {

            $bkb_display_counter = 0;
        }

        if ( isset( $options['bkb_woo_theme'] ) ) {

            $bkb_woo_theme = $options['bkb_woo_theme'];
        }

        if ( isset( $options['bkb_woo_animation'] ) ) {

            $bkb_woo_animation = $options['bkb_woo_animation'];
        }
        if ( isset( $options['bkb_highlighter_bg'] ) && strlen( $options['bkb_highlighter_bg'] ) == 7 ) {

            $bkb_highlighter_bg = $options['bkb_highlighter_bg'];
        }
        if ( isset( $options['bkb_highlighter_text_color'] ) && strlen( $options['bkb_highlighter_text_color'] ) == 7 ) {

            $bkb_highlighter_text_color = $options['bkb_highlighter_text_color'];
        }
        if ( isset( $options['bkb_search_box_status'] ) ) {

            $bkb_search_box_status = $options['bkb_search_box_status'];
        }

        if ( isset( $options['bkb_rtl_mode'] ) ) {

            $bkb_rtl_mode = $options['bkb_rtl_mode'];
        }

        if ( ! isset( $options['bkb_pagination_conditinal_fields']['enabled'] ) ) {

            $bkb_pagination_status = false;
        } elseif ( isset( $options['bkb_pagination_conditinal_fields']['enabled'] ) && $options['bkb_pagination_conditinal_fields']['enabled'] == 'on' ) {

            if ( isset( $options['bkb_pagination_conditinal_fields']['bkb_items_per_page'] ) && $options['bkb_pagination_conditinal_fields']['bkb_items_per_page'] != '' ) {

                $bkb_items_per_page = $options['bkb_pagination_conditinal_fields']['bkb_items_per_page'];
            }
        } else {
            // do nothing ......
        }

        ?>
<script type="text/javascript">
var bkb_woo_theme = '<?php echo $bkb_woo_theme; ?>',
    bkb_display_counter = '<?php echo $bkb_display_counter; ?>',
    bkb_woo_animation = '<?php echo $bkb_woo_animation; ?>',
    bkb_highlighter_bg = '<?php echo $bkb_highlighter_bg; ?>',
    bkb_highlighter_text_color = '<?php echo $bkb_highlighter_text_color; ?>',
    bkb_search_box_status = '<?php echo $bkb_search_box_status; ?>',
    bkb_rtl_mode = '<?php echo $bkb_rtl_mode; ?>',
    bkb_pagination_status = '<?php echo $bkb_pagination_status; ?>',
    bkb_items_per_page = '<?php echo $bkb_items_per_page; ?>',
    bkb_acc_search_text = '<?php _e( 'Search!', 'bkb-kbtfw' ); ?>',
    bkb_acc_msg_item_found = '<?php _e( ' Item(s) Found !', 'bkb-kbtfw' ); ?>',
    bkb_acc_msg_no_result = '<?php _e( 'Nothing Found !', 'bkb-kbtfw' ); ?>',
    string_singular_page = '<?php _e( 'Page', 'bkb-kbtfw' ); ?>',
    string_plural_page = '<?php _e( 'Pages', 'bkb-kbtfw' ); ?>',
    string_total = '<?php _e( 'Total', 'bkb-kbtfw' ); ?>';
</script>

		<?php
	}
}
