<?php
namespace KTFWC\Callbacks\Filters;

use KTFWC\Helpers\PluginConstants;

/**
 * Class for registering the product tab.
 *
 * @package KTFWC
 * @since: 1.0.0
 * @author: Mahbub Alam Khan
 */
class ProductTabCb {

	/**
	 * Get the tab.
	 *
	 * @param array $tabs tabs.
	 * @return array
	 */
	public function get_the_tab( $tabs ) {

		global $product;

		// Get Data From Option Panel Settings.
		$bkb_data          = PluginConstants::$plugin_options;
		$bkb_auto_hide_tab = 1; // Enable Auto hide
		$bkb_tab_title     = $bkb_data['bkb_woo_tab_title'] ?? esc_html__( 'Knowledge Base ', 'bkb-kbtfw' ); // Set the title of Knowledgebase Tab.

		$bkb_woo_tab_position = $bkb_data['bkb_auto_hide_tab'] ?? 100; // Set faq tab to the last position.

		if ( $bkb_auto_hide_tab === 1 ) {

				// Count no of KB for current product.
				$kbftw_kb_post_ids = (int) count( get_post_meta( $product->get_id(), 'kbftw_kb_post_ids' ) );

			if ( $kbftw_kb_post_ids === 0 ) {
					return $tabs;
			}
		}

		// Specefic Product Knowledgebase Tab Hide section.

		$bkb_woo_tab_hide_status = get_post_meta( $product->get_id(), 'bkb_woo_tab_hide_status', true );

		// Checkbox to select conversion fix
		// Issue is: For checkbox data will saved in to string format. Means, if user checked the check box then
		// data saved as "on".  So, we are going to check that and trun this value in to a number..

		if ( isset( $bkb_woo_tab_hide_status ) && $bkb_woo_tab_hide_status == 'on' ) {
				$bkb_woo_tab_hide_status = 1;
		}

		if ( isset( $bkb_woo_tab_hide_status ) && $bkb_woo_tab_hide_status == 1 ) {

				return $tabs;
		}

		$kbtfw_total_kbss_string = '';

		$get_kbftw_kb_post_ids = apply_filters( 'filter_kbtfwc_content_data', get_post_meta( $product->get_id(), 'kbftw_kb_post_ids' ) );

		$kbftw_kb_post_ids = implode( ',',  $get_kbftw_kb_post_ids );

		$tabs['kbtfw_tab'] = [
			'title'    => $bkb_tab_title . $kbtfw_total_kbss_string,
			'priority' => intval( $bkb_woo_tab_position ), // Always display at the end of tab :)
			'callback' => [ $this, 'get_tab_content' ],
			'content'  => do_shortcode( '[bkb_woo_tab post_ids="' . $kbftw_kb_post_ids . '"/]' ), // custom field
		];

		return $tabs;
	}

	/**
	 * Get the tab content.
	 *
	 * @param string $key key.
	 * @param array  $tab tab.
	 */
	public function get_tab_content( $key, $tab ) {

		// allow shortcodes to function
		$content = apply_filters( 'the_content', $tab['content'] );
		$content = str_replace( ']]>', ']]&gt;', $content );
		echo apply_filters( 'kbtfw_woocommerce_custom_product_tabs_content', $content, $tab ); //phpcs:ignore
	}
}
