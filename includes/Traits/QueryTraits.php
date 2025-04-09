<?php
namespace BKBRKB\Traits;

trait QueryTraits {

	/**
	 * Insert data into a specified table.
	 *
	 * @param string $table_name The name of the table.
	 * @param array  $table_data The data to insert.
	 * @param array  $table_data_type The data types of the columns.
	 */
	public function bwl_wp_insert_query( $table_name, $table_data = [], $table_data_type = [] ) {
		global $wpdb;

		$wpdb->insert( $table_name, $table_data, $table_data_type );
	}
}
