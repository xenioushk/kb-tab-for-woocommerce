<?php
namespace KTFWC\Controllers\Filters\Admin;

/**
 * Custom Product Columns
 *
 * @package KTFWC
 */
class CustomColumns {

    /**
     * Register the column filters.
     */
	public function register() {
		if ( is_admin() ) {
			add_filter( 'manage_product_posts_columns', [ $this,'columns_header' ] );
			add_action( 'manage_product_posts_custom_column', [ $this,'columns_content' ], 10, 1 );
		}
	}

    /**
     * Add custom columns to the product post type.
     *
     * @param array $columns The columns.
     *
     * @return array
     */
	public function columns_header( $columns ) {
		$columns['kbftw_kb_post_ids']       = esc_html__( 'Total KBs', 'bkb-kbtfw' );
		$columns['bkb_woo_tab_hide_status'] = esc_html__( 'KB Tab', 'bkb-kbtfw' );

		return $columns;
	}

    /**
     * Add content to the custom columns.
     *
     * @param string $column The column.
     */
	public function columns_content( $column ) {
		// Add A Custom Image Size For Admin Panel.

		global $post;

		switch ( $column ) {

			case 'kbftw_kb_post_ids':
				$kbftw_kb_post_ids = (int) count( apply_filters( 'filter_kbtfwc_content_data', get_post_meta( $post->ID, 'kbftw_kb_post_ids' ) ) );
				echo '<div id="kbftw_kb_post_ids-' . $post->ID . '" >&nbsp;' . $kbftw_kb_post_ids . '</div>';

                break;

			case 'bkb_woo_tab_hide_status':
				$bkb_woo_tab_hide_status = ( get_post_meta( $post->ID, 'bkb_woo_tab_hide_status', true ) == '' ) ? '' : get_post_meta( $post->ID, 'bkb_woo_tab_hide_status', true );

				// FAQ Display Status In Text.

				$bkb_woo_tab_hide_status_in_text = ( $bkb_woo_tab_hide_status == 1 ) ? esc_html__( 'Hidden', 'bkb-kbtfw' ) : esc_html__( 'Visible', 'bkb-kbtfw' );

				echo '<div id="bkb_woo_tab_hide_status-' . $post->ID . '" data-status_code="' . $bkb_woo_tab_hide_status . '" >' . $bkb_woo_tab_hide_status_in_text . '</div>';

                break;
		}
	}
}
