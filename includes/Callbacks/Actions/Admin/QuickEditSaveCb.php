<?php
namespace BKBRKB\Callbacks\Actions\Admin;

/**
 * Class for registering the atfc tab callabck.
 *
 * @package BKBRKB
 * @since: 1.0.0
 * @author: Mahbub Alam Khan
 */
class QuickEditSaveCb {

	/**
	 * Save data.
     *
	 * @param id     $post_id post id.
	 * @param object $post post.
	 *
	 * @return mixed
	 */
	public function save_data( $post_id, $post ) {
		// pointless if $_POST is empty (this happens on bulk edit)
		if ( empty( $_POST ) ) {
			return $post_id;
		}

		// verify quick edit nonce
		if ( isset( $_POST['_inline_edit'] ) && ! wp_verify_nonce( $_POST['_inline_edit'], 'inlineeditnonce' ) ) {
			return $post_id;
		}

		// don't save for autosave
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_id;
		}

		// dont save for revisions
		if ( isset( $post->post_type ) && $post->post_type == 'revision' ) {
			return $post_id;
		}

		switch ( $post->post_type ) {

			case $post->post_type:
					/**
					 * Because this action is run in several places, checking for the array key
					 * keeps WordPress from editing data that wasn't in the form, i.e. if you had
					 * this post meta on your "Quick Edit" but didn't have it on the "Edit Post" screen.
					 */
					$custom_fields = [ 'bkb_rkb_status' ];

				foreach ( $custom_fields as $field ) {

					if ( array_key_exists( $field, $_POST ) ) {

							update_post_meta( $post_id, $field, $_POST[ $field ] );
					}
				}

                break;
		}

	}
}
