<?php
namespace BKBRKB\Controllers\Filters\Admin;

/**
 * Custom Product Columns
 *
 * @package BKBRKB
 */
class CustomColumns {

    /**
     * Register the column filters.
     */
	public function register() {
		if ( is_admin() ) {
			add_filter( 'manage_bwl_kb_posts_columns', [ $this,'columns_header' ] );
			add_action( 'manage_bwl_kb_posts_custom_column', [ $this,'columns_content' ], 10, 1 );
		}
	}

    /**
     * Add custom columns to the bwl_kb post type.
     *
     * @param array $columns The columns.
     *
     * @return array
     */
	public function columns_header( $columns ) {
		$columns['bkb_rkb_status'] = esc_html__( 'Access', 'bkb_rkb' );

		return $columns;
	}

    /**
     * Add content to the custom columns.
     *
     * @param string $column The column.
     */
	public function columns_content( $column ) {
		global $post;

		switch ( $column ) {

			case 'bkb_rkb_status':
				$bkb_rkb_status = get_post_meta( $post->ID, 'bkb_rkb_status', true ) ?? 0;

				// FAQ Display Status In Text.

				$status_icon = ( $bkb_rkb_status == 1 ) ? '<span class="dashicons dashicons-lock"></span>' : '<span class="dashicons dashicons-unlock"></span>';

				$access_text = __( 'All types of user can view this KB content', 'bkb_rkb' );

				if ( $bkb_rkb_status == 1 ) {
					$alllowed_roles = get_post_meta( $post->ID, 'bkb_rkb_user_roles', true );

					if ( ! is_array( $alllowed_roles ) ) {
						$access_text = __( 'only administrator can access this KB', 'bkb_rkb' );
					} else {
						$bkb_roles   = implode( ', ', $alllowed_roles );
						$access_text = __( 'only', 'bkb_rkb' ) . ' ' . $bkb_roles . ' ' . __( 'can access this KB', 'bkb_rkb' );
					}
				}

				echo '<div id="bkb_rkb_status-' . $post->ID . '" data-status_code="' . $bkb_rkb_status . '" title="' . ucwords( $access_text ) . '">' . $status_icon . '</div>';

				break;
		}
	}
}
