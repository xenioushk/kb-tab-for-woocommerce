<?php
namespace KTFWC\Callbacks\Actions\Admin;

/**
 * Class for registering the atfc tab callabck.
 *
 * @package KTFWC
 * @since: 1.0.0
 * @author: Mahbub Alam Khan
 */
class BulkEditSaveCb {

	/**
	 * Save data.
	 *
	 * @return mixed
	 */
	public function save_data() {

		// we need the post IDs
		$post_ids = ( isset( $_POST['post_ids'] ) && ! empty( $_POST['post_ids'] ) ) ? $_POST['post_ids'] : null;

		// if we have post IDs
		if ( ! empty( $post_ids ) && is_array( $post_ids ) ) {

				// Get the custom fields

				$custom_fields = [ 'bkb_woo_tab_hide_status' ];

			foreach ( $custom_fields as $field ) {

					// if it has a value, doesn't update if empty on bulk
				if ( isset( $_POST[ $field ] ) && trim( $_POST[ $field ] ) != '' ) {

						// update for each post ID
					foreach ( $post_ids as $post_id ) {

						if ( $_POST[ $field ] == 2 ) {

								update_post_meta( $post_id, $field, '' );
						} elseif ( $_POST[ $field ] == 1 ) {

								update_post_meta( $post_id, $field, 1 );
						} else {
								// do nothing
						}
					}
				}
			}
		}
	}
}
