<?php

namespace KAFWPB\Callbacks\WPBakery\Shortcodes;

/**
 * Get all the KB counter
 *
 * @package KAFWPB
 * @since: 1.0.0
 * @author: Mahbub Alam Khan
 */
class CounterShortcodeParamCb {

	/**
	 * Get the output.
	 *
	 * @param array  $settings Settings.
	 * @param string $value Values.
	 *
	 * @return string
	 */
	public function get_the_output( $settings, $value ) {
		$param_name = isset( $settings['param_name'] ) ? $settings['param_name'] : '';
		$type       = isset( $settings['type'] ) ? $settings['type'] : '';
		$class      = isset( $settings['class'] ) ? $settings['class'] : '';

		if ( ! empty( $value ) ) {

			$explode_value = explode( ',', $value );
		} else {

			$explode_value = [ 'total_kb', 'total_cat', 'total_tag', 'total_likes' ];
		}

		// Now we pick those array data which index is cat-1 and cat-2
		$parent_list = [];

		if ( count( $explode_value ) > 0 ) {

			foreach ( $explode_value as $key => $value ) {

				$parent_list[ $value ] = ucfirst( str_replace( '_', ' ', $value ) );
			}
		}

		$parent_list_string = '<ul id="sortable1" class="connectedSortable bkb_connected list bkb_counter">';

		foreach ( $parent_list as $key => $value ) :
			$parent_list_string .= '<li data-value="' . $key . '">' . $value . '</li>';
    endforeach;

		$parent_list_string .= '</ul>';
		$output              = '';

		$output .= '<section id="bkb_connected">
                        ' . $parent_list_string . '
                   </section>';

		$output .= '<input type="hidden" class="wpb_vc_param_value wpbc ' . $param_name . ' ' . $type . ' ' . $class . '" name="' . $param_name . '" value="' . $value . '" />';

		return $output;
	}
}
