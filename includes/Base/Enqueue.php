<?php
namespace KTFWC\Base;

/**
 * Class for registering the plugin scripts and styles.
 *
 * @package KTFWC
 */
class Enqueue {

	/**
	 * Frontend script slug.
	 *
	 * @var string $frontend_script_slug
	 */
	private $frontend_script_slug;

	/**
	 * Constructor.
	 */
	public function __construct() {
		// Frontend script slug.
		// This is required to hook the loclization texts.
		$this->frontend_script_slug = 'bkb-kbtfw';
	}

	/**
	 * Register the plugin scripts and styles loading actions.
	 */
	public function register() {
		add_action( 'wp_enqueue_scripts', [ $this, 'get_the_styles' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'get_the_scripts' ] );
	}

	/**
	 * Load the plugin styles.
	 */
	public function get_the_styles() {

		wp_enqueue_style(
			$this->frontend_script_slug . '-animate',
			KTFWC_PLUGIN_LIBS_DIR . 'animate/animate.css',
			[],
			KTFWC_PLUGIN_VERSION
		);

		wp_enqueue_style(
            $this->frontend_script_slug,
            KTFWC_PLUGIN_STYLES_ASSETS_DIR . 'frontend.css',
            [],
            KTFWC_PLUGIN_VERSION
		);

		if ( is_rtl() ) {

			wp_enqueue_style(
				$this->frontend_script_slug . '-rtl',
				KTFWC_PLUGIN_STYLES_ASSETS_DIR . 'frontend_rtl.css',
				[],
				KTFWC_PLUGIN_VERSION
			);
		}
	}

	/**
	 * Load the plugin scripts.
	 */
	public function get_the_scripts() {

		// Register JS

		wp_enqueue_script(
            $this->frontend_script_slug,
            KTFWC_PLUGIN_SCRIPTS_ASSETS_DIR . 'frontend.js',
            [ 'jquery' ],
            KTFWC_PLUGIN_VERSION,
            true
        );

		// Load frontend variables used by the JS files.
		$this->get_the_localization_texts();
	}

	/**
	 * Load the localization texts.
	 */
	private function get_the_localization_texts() {

		// Localize scripts.
		// Frontend.
		// Access data: KtfwcFrontendData.version
		wp_localize_script(
            $this->frontend_script_slug,
            'KtfwcFrontendData',
            [
				'version' => KTFWC_PLUGIN_VERSION,
            ]
		);
	}
}
