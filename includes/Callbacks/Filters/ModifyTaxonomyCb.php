<?php
namespace BKBRKB\Callbacks\Filters;

use BKBRKB\Helpers\PluginConstants;

/**
 * Class for registering taxonomy callback.
 *
 * @package BKBRKB
 * @since: 1.0.0
 * @author: Mahbub Alam Khan
 */
class ModifyTaxonomyCb {

	/**
	 * Modify the content of the taxonomy.
	 *
	 * @param string $content The content to be modified.
	 * @return string
	 */
	public function modify_exceprt( $content ) {
		global $post;

		$options = PluginConstants::$plugin_options;

		// Define conditions for taxonomy and post type checks.
		$is_bkb_category = ! is_admin() && is_tax( 'bkb_category' ) &&
        isset( $options['bkb_cat_default_tpl_ordering_status']['enabled'] ) &&
        $options['bkb_cat_default_tpl_ordering_status']['enabled'] === 'on';

		$is_bkb_tags = ! is_admin() && is_tax( 'bkb_tags' ) &&
        isset( $options['bkb_tag_default_tpl_ordering_status']['enabled'] ) &&
        $options['bkb_tag_default_tpl_ordering_status']['enabled'] === 'on';

		$is_bkb_post_type = ! is_admin() && get_post_type( $post->ID ) === BKBM_POST_TYPE;

		// Check conditions and apply the filter.
		if ( $is_bkb_category || $is_bkb_tags || $is_bkb_post_type ) {
			$bkb_rkb_post_access_result = apply_filters( 'bkb_rkb_post_access', $post->ID );

			return $bkb_rkb_post_access_result !== 1 ? $bkb_rkb_post_access_result : $content;
		}

		return $content;
	}
}
