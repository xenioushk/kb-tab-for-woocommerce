<?php
namespace BKBRKB\Callbacks\Actions\Admin;

/**
 * Class for registering the atfc tab callabck.
 *
 * @package BKBRKB
 * @since: 1.0.0
 * @author: Mahbub Alam Khan
 */
class ManagePostsCb {

	/**
	 * Callback for the quick edit custom box.
	 *
	 * @return mixed
	 */
	public function apply() {
		global $typenow;

		// only add filter to post type you want
		if ( $typenow == BKBM_POST_TYPE ) {

				$bkbm_all_user_roles = get_editable_roles();

				$bkbm_filter_user_roles = [];

			if ( sizeof( $bkbm_all_user_roles ) > 0 ) :
				foreach ( $bkbm_all_user_roles as $role_id => $role_info ) :
						$bkbm_filter_user_roles[ $role_id ] = $role_info['name'];
					endforeach;
				endif;
			?>
<select name="bkb_rkb_user_roles">
    <option value=""><?php _e( 'Select Role ', 'bkb_rkb' ); ?></option>
			<?php
						$current_v = isset( $_GET['bkb_rkb_user_roles'] ) ? $_GET['bkb_rkb_user_roles'] : '';
			foreach ( $bkbm_filter_user_roles as $label => $value ) {
				printf(
					'<option value="%s"%s>%s</option>',
					$label,
					$label == $current_v ? ' selected="selected"' : '',
					$value
				);
			}
			?>
</select>
			<?php
		}
	}
}
