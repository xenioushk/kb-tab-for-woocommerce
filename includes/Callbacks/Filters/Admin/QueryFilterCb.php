<?php
namespace BKBRKB\Callbacks\Filters\Admin;

/**
 * Class for registering query filter callback.
 *
 * @package BKBRKB
 * @since: 1.0.0
 * @author: Mahbub Alam Khan
 */
class QueryFilterCb {

	/**
	 * Apply the filter to the query arguments.
	 *
	 * @param object $query The query arguments.
	 * @return void
	 */
	public function apply( $query ) {

		global $pagenow;
        global $typenow;

        if ( BKBM_POST_TYPE == $typenow &&
					is_admin() &&
					$pagenow == 'edit.php' &&
					isset( $_GET['bkb_rkb_user_roles'] ) &&
					! empty( $_GET['bkb_rkb_user_roles'] )
				) {
            $query->query_vars['meta_key']     = 'bkb_rkb_user_roles';
            $query->query_vars['meta_value']   = $_GET['bkb_rkb_user_roles'];
            $query->query_vars['meta_compare'] = 'LIKE';
        }

	}
}
