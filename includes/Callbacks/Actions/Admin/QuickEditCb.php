<?php
namespace BKBRKB\Callbacks\Actions\Admin;

/**
 * Class for registering the atfc tab callabck.
 *
 * @package BKBRKB
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

					case 'bkb_rkb_status':
						$bkb_rkb_status = ( get_post_meta( $post->ID, 'bkb_rkb_status', true ) == '' ) ? '' : get_post_meta( $post->ID, 'bkb_rkb_status', true );
						?>

<fieldset class="inline-edit-col-right">
    <div class="inline-edit-col">
    <div class="inline-edit-group">
        <label class="inline-edit-status alignleft">
        <span class="title"><?php _e( 'Restrict Access', 'bkb_rkb' ); ?></span>
        <select name="bkb_rkb_status">
            <option value=""><?php _e( '- No Change -', 'bkb_rkb' ); ?></option>
            <option value="1"><?php _e( 'Yes', 'bkb_rkb' ); ?></option>
            <option value="0"><?php _e( 'No', 'bkb_rkb' ); ?></option>
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
