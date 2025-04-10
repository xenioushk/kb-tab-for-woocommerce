<?php
namespace KTFWC\Callbacks\Actions\Admin;

/**
 * Class for registering the atfc tab callabck.
 *
 * @package KTFWC
 * @since: 1.0.0
 * @author: Mahbub Alam Khan
 */
class QuickEditCb {

	/**
	 * Callback for the quick edit custom box.
	 *
	 * @param string $column_name column name.
	 * @param string $post_type post type.
	 *
	 * @return mixed
	 */
	public function get_edit_box( $column_name, $post_type ) {

		global $post;

		switch ( $post_type ) {

			case $post_type:
				switch ( $column_name ) {

					case 'bkb_woo_tab_hide_status':
						$bkb_woo_tab_hide_status_val = get_post_meta( $post->ID, 'bkb_woo_tab_hide_status', true );

						$bkb_woo_tab_hide_status = ( $bkb_woo_tab_hide_status_val == '' ) ? '' : $bkb_woo_tab_hide_status_val;

						?>


<fieldset class="inline-edit-col-left">
    <div class="inline-edit-col">
    <div class="inline-edit-group">
        <label class="alignleft">

        <span class="checkbox-title"><?php esc_html_e( 'Hide KB Tab?', 'bkb-kbtfw' ); ?></span>
        <select name="bkb_woo_tab_hide_status">
            <option value="3"><?php esc_html_e( '- No Change -', 'bkb-kbtfw' ); ?></option>
            <option value="1"><?php esc_html_e( 'Yes', 'bkb-kbtfw' ); ?></option>
            <option value="2"><?php esc_html_e( 'No', 'bkb-kbtfw' ); ?></option>
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
}
