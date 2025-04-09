<?php
namespace KAFWPB\Base;

/**
 * Class for plucin redirection to about page.
 *
 * @package KAFWPB
 */
class AboutPluginRedirect {

	/**
	 * Register the methods.
	 */
	public function register() {
		add_action( 'admin_init', [ $this, 'redirect_to_about' ] );
	}

	/**
	 * Redirect to about page.
	 */
	public function redirect_to_about() {
		$redirect_url = 'edit.php?post_type=petitions';
		if ( get_transient( 'bptm_activation_redirect' ) ) {

			delete_transient( 'bptm_activation_redirect' );

			if ( is_admin() && ! isset( $_GET['activate-multi'] ) ) {
				wp_safe_redirect( admin_url( $redirect_url ) );
				exit;
			}
		}
	}
}
