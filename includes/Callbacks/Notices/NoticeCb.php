<?php
namespace KAFWPB\Callbacks\Notices;

use KAFWPB\Traits\TraitAdminNotice;

/**
 * Class NoticeCb
 *
 * Handles the FAQ items shortcode callbacks.
 *
 * @package KAFWPB
 */
class NoticeCb {

	use TraitAdminNotice;

	/**
	 * The notice data.
	 *
	 * @var array $notice
	 */
	private $notice;

	/**
	 * Filter roles.
	 *
	 * @var int $filter_roles
	 */
	private $filter_roles;

	/**
	 * Show notice status.
	 *
	 * @var int $show_notice_status
	 */
	private $show_notice_status = 1;

	/**
	 * Set the filter roles.
	 */
	private function set_filter_roles() {
		$this->filter_roles = isset( $this->notice['user_roles'] ) && ! empty( $this->notice['user_roles'] ) ? 1 : 0;
	}

	/**
	 * Set the show notice status.
	 */
	private function set_show_notice_status() {

		if ( $this->filter_roles ) {
			$current_user_roles       = wp_get_current_user()->roles;
			$this->show_notice_status = in_array( $current_user_roles[0], $this->notice['user_roles'], true ) ? 1 : 0;
		}
	}

	/**
	 * Display the plugin notices.
	 *
	 * @param array $notice The notice data.
	 */
	public function get_the_notice( $notice = [] ) {

		if ( isset( $notice['msg'] ) && empty( $notice['msg'] ) ) {
			return;
		}

		$this->notice = $notice;

		$this->set_filter_roles();

		$this->set_show_notice_status();

		// Check if the user has the required role to see the notice.
		if ( $this->filter_roles && $this->show_notice_status ) {
				$this->get_notice_html( $notice );
		} else {

			if ( ! current_user_can( 'manage_options' ) || ! $this->show_notice_status ) {
				return;
			}

			$this->get_notice_html( $notice );
		}

	}
}
