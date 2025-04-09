<?php
namespace BKBRKB\Base;

use Xenioushk\BwlPluginApi\Api\AjaxHandlers\AjaxHandlersApi;
use BKBRKB\Callbacks\AdminAjaxHandlers\PluginInstallationCb;
/**
 * Class for admin ajax handlers.
 *
 * @package BKBRKB
 */
class AdminAjaxHandlers {

	/**
	 * Register admin ajax handlers.
	 */
	public function register() {

		$ajax_handlers_api      = new AjaxHandlersApi();
		$plugin_installation_cb = new PluginInstallationCb();

		// Do not change the tag.
		// If do so, you need to change in js file too.
		$ajax_requests = [
			[
				'tag'      => 'bkbm_rkbur_installation_counter',
				'callback' => [ $plugin_installation_cb, 'save' ],
			],
		];
		$ajax_handlers_api->add_ajax_handlers( $ajax_requests )->register();
	}
}
