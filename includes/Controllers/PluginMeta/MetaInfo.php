<?php
namespace BKBRKB\Controllers\PluginMeta;

/**
 * Class displays options panel, addons, documentation links below the plugin information.
 *
 * @since: 1.1.0
 * @package BKBRKB
 */
class MetaInfo {

	/**
	 * Register filters.
	 */
	public function register() {
		add_filter( 'plugin_row_meta', [ $this, 'get_meta_links' ], null, 2 );
	}

	/**
     * Filters the plugin action links.
     *
     * @param array  $links An array of plugin action links.
     * @param string $file  The path to the plugin file.
     *
     * @return array Filtered array of plugin action links.
     */
	public function get_meta_links( $links, $file ) {

		if ( strpos( $file, BKBRKB_PLUGIN_ROOT_FILE ) !== false && is_plugin_active( $file ) ) {

			// nt = 1 // new tab.
			$additional_links = [
				[
					'title' => esc_html__( 'Options Panel', 'bkb_rkb' ),
					'url'   => admin_url( 'edit.php?post_type=bwl_kb&page=edit.php%3Fpost_type%3Dbwl_kb_options_panel#bkb_rkb_settings' ), //phpcs:ignore
				],
				[
					'title' => esc_html__( 'Docs', 'bkb_rkb' ),
					'url'   => 'https://xenioushk.github.io/docs-plugins-addon/bkbm-addon/rkb/index.html',
					'nt'    => 1,
				],

			];

			$new_links = [];

			foreach ( $additional_links as $link ) {

				$new_tab = isset( $link['nt'] ) ? 'target="_blank"' : '';
				$class   = isset( $link['class'] ) ? 'class="' . $link['class'] . '"' : '';

				$url   = esc_url( $link['url'] );
				$title = $link['title'];

				$new_links[] = "<a href='{$url}' {$new_tab} {$class}>{$title}</a>";
			}

			$links = array_merge( $links, $new_links );
		}

		return $links;
	}
}
