<?php

use \BwlKbManager\Base\BaseController;

class BKB_kbtfw
{

	const VERSION = BKBKBTFW_ADDON_CURRENT_VERSION;
	protected $plugin_slug = 'bkb-kbtfw';
	protected static $instance = null;
	public $baseController; // parent controller of the addon.

	private function __construct()
	{

		if (class_exists('BwlKbManager\\Init') && class_exists('WooCommerce') && BKBKBTFW_PARENT_PLUGIN_INSTALLED_VERSION > '1.0.5') {

			add_action('init', array($this, 'load_plugin_textdomain'));

			$this->baseController = new BaseController();

			$this->include_files();

			// Load public-facing style sheet and JavaScript.
			add_action('wp_head', array($this, 'bkb_kbtfw_custom_scripts'));
			add_action('wp_enqueue_scripts', array($this, 'bkb_kbtfw_enqueue_styles'));
			add_action('wp_enqueue_scripts', array($this, 'bkb_kbtfw_enqueue_scripts'));
			add_filter('woocommerce_product_tabs', array($this, 'kbtfw_add_custom_product_tab'));
			//Fixed in version 1.0.4
			add_filter('kbtfw_woocommerce_custom_product_tabs_content', 'do_shortcode');
		}
	}

	public function include_files()
	{
		require_once(BKBKBTFW_DIR . 'public/shortcode/bkb-kbtfw-shortcodes.php');
	}


	public function get_plugin_slug()
	{
		return $this->plugin_slug;
	}


	public static function get_instance()
	{

		// If the single instance hasn't been set, set it now.
		if (null == self::$instance) {
			self::$instance = new self;
		}

		return self::$instance;
	}


	public static function activate($network_wide)
	{

		if (function_exists('is_multisite') && is_multisite()) {

			if ($network_wide) {

				// Get all blog ids
				$blog_ids = self::get_blog_ids();

				foreach ($blog_ids as $blog_id) {

					switch_to_blog($blog_id);
					self::single_activate();
				}

				restore_current_blog();
			} else {
				self::single_activate();
			}
		} else {
			self::single_activate();
		}
	}

	public static function deactivate($network_wide)
	{

		if (function_exists('is_multisite') && is_multisite()) {

			if ($network_wide) {

				// Get all blog ids
				$blog_ids = self::get_blog_ids();

				foreach ($blog_ids as $blog_id) {

					switch_to_blog($blog_id);
					self::single_deactivate();
				}

				restore_current_blog();
			} else {
				self::single_deactivate();
			}
		} else {
			self::single_deactivate();
		}
	}


	public function activate_new_site($blog_id)
	{

		if (1 !== did_action('wpmu_new_blog')) {
			return;
		}

		switch_to_blog($blog_id);
		self::single_activate();
		restore_current_blog();
	}

	private static function get_blog_ids()
	{

		global $wpdb;

		// get an array of blog ids
		$sql = "SELECT blog_id FROM $wpdb->blogs
			WHERE archived = '0' AND spam = '0'
			AND deleted = '0'";

		return $wpdb->get_col($sql);
	}

	private static function single_activate()
	{
		// @TODO: Define activation functionality here
	}


	private static function single_deactivate()
	{
		// @TODO: Define deactivation functionality here
	}

	public function bkb_kbtfw_custom_scripts()
	{

		$bkb_data = $this->baseController->bkb_data;


		$bkb_display_counter =  1;
		$bkb_woo_theme =  "default";
		$bkb_woo_animation =  "fade";
		$bkb_highlighter_bg =  "#FFFF80";
		$bkb_highlighter_text_color =  "#000000";
		$bkb_search_box_status =  1;
		$bkb_rtl_mode =  false;
		$bkb_pagination_status =  true;
		$bkb_items_per_page =  5;

		if (isset($bkb_data['bkb_display_counter']) && $bkb_data['bkb_display_counter'] == "") {

			$bkb_display_counter =  0;
		}

		if (isset($bkb_data['bkb_woo_theme'])) {

			$bkb_woo_theme =  $bkb_data['bkb_woo_theme'];
		}

		if (isset($bkb_data['bkb_woo_animation'])) {

			$bkb_woo_animation =  $bkb_data['bkb_woo_animation'];
		}
		if (isset($bkb_data['bkb_highlighter_bg']) && strlen($bkb_data['bkb_highlighter_bg']) == 7) {

			$bkb_highlighter_bg =  $bkb_data['bkb_highlighter_bg'];
		}
		if (isset($bkb_data['bkb_highlighter_text_color']) && strlen($bkb_data['bkb_highlighter_text_color']) == 7) {

			$bkb_highlighter_text_color =  $bkb_data['bkb_highlighter_text_color'];
		}
		if (isset($bkb_data['bkb_search_box_status'])) {

			$bkb_search_box_status =  $bkb_data['bkb_search_box_status'];
		}

		if (isset($bkb_data['bkb_rtl_mode'])) {

			$bkb_rtl_mode =  $bkb_data['bkb_rtl_mode'];
		}

		if (!isset($bkb_data['bkb_pagination_conditinal_fields']['enabled'])) {

			$bkb_pagination_status = false;
		} else if (isset($bkb_data['bkb_pagination_conditinal_fields']['enabled']) && $bkb_data['bkb_pagination_conditinal_fields']['enabled'] == 'on') {

			if (isset($bkb_data['bkb_pagination_conditinal_fields']['bkb_items_per_page']) && $bkb_data['bkb_pagination_conditinal_fields']['bkb_items_per_page'] != "") {

				$bkb_items_per_page = $bkb_data['bkb_pagination_conditinal_fields']['bkb_items_per_page'];
			}
		} else {
			// do nothing ......
		}

?>
		<script type="text/javascript">
			var bkb_woo_theme = '<?php echo $bkb_woo_theme; ?>',
				bkb_display_counter = '<?php echo $bkb_display_counter; ?>',
				bkb_woo_animation = '<?php echo $bkb_woo_animation; ?>',
				bkb_highlighter_bg = '<?php echo $bkb_highlighter_bg; ?>',
				bkb_highlighter_text_color = '<?php echo $bkb_highlighter_text_color; ?>',
				bkb_search_box_status = '<?php echo $bkb_search_box_status; ?>',
				bkb_rtl_mode = '<?php echo $bkb_rtl_mode; ?>',
				bkb_pagination_status = '<?php echo $bkb_pagination_status; ?>',
				bkb_items_per_page = '<?php echo $bkb_items_per_page; ?>',
				bkb_acc_search_text = '<?php _e('Search!', 'bkb-kbtfw'); ?>',
				bkb_acc_msg_item_found = '<?php _e(' Item(s) Found !', 'bkb-kbtfw'); ?>',
				bkb_acc_msg_no_result = '<?php _e('Nothing Found !', 'bkb-kbtfw'); ?>',
				string_singular_page = '<?php _e('Page', 'bkb-kbtfw'); ?>',
				string_plural_page = '<?php _e('Pages', 'bkb-kbtfw'); ?>',
				string_total = '<?php _e('Total', 'bkb-kbtfw'); ?>';
		</script>

<?php

	}

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain()
	{

		$domain = $this->plugin_slug;
		$locale = apply_filters('plugin_locale', get_locale(), $domain);

		load_textdomain($domain, trailingslashit(WP_LANG_DIR) . $domain . '/' . $domain . '-' . $locale . '.mo');
	}

	/**
	 * Register and enqueue public-facing style sheet.
	 *
	 * @since    1.0.0
	 */
	public function bkb_kbtfw_enqueue_styles()
	{
		if (is_singular("product")) {
			wp_enqueue_style($this->plugin_slug . '-animate', BKBKBTFW_PLUGIN_DIR . 'libs/animate/animate.css', [], self::VERSION);
			wp_enqueue_style($this->plugin_slug . '-frontend', BKBKBTFW_PLUGIN_DIR . 'assets/styles/frontend.css', [], self::VERSION);

			if (is_rtl()) {
				wp_enqueue_style($this->plugin_slug . '-frontend-rtl', BKBKBTFW_PLUGIN_DIR . 'assets/styles/frontend_rtl.css', [], self::VERSION);
			}
		}
	}

	/**
	 * Register and enqueues public-facing JavaScript files.
	 *
	 * @since    1.0.0
	 */
	public function bkb_kbtfw_enqueue_scripts()
	{
		wp_register_script($this->plugin_slug . '-frontend', BKBKBTFW_PLUGIN_DIR . 'assets/scripts/frontend.js', ['jquery'], self::VERSION);
	}

	public function kbtfw_add_custom_product_tab($tabs)
	{

		global $product;

		// Get Data From Option Panel Settings.
		$bkb_data = $this->baseController->bkb_data;
		$bkb_auto_hide_tab = 1; // Enable Auto hide
		$bkb_tab_title = __("Knowledge Base ", 'bkb-kbtfw'); // Set the title of Knowledgebase Tab.

		if (isset($bkb_data['bkb_woo_tab_title']) && $bkb_data['bkb_woo_tab_title'] != "") {
			$bkb_tab_title = $bkb_data['bkb_woo_tab_title']; // Introduced in version 1.0.1
		}

		$bkb_woo_tab_position = 100; // Set faq tab to the last position.

		if (isset($bkb_data['bkb_auto_hide_tab']) && $bkb_data['bkb_auto_hide_tab'] == "") {
			$bkb_auto_hide_tab = 0;
		}

		if ($bkb_auto_hide_tab == 1) {

			// Count no of KB for current product.
			$kbftw_kb_post_ids = (int) count(get_post_meta($product->get_id(), 'kbftw_kb_post_ids'));

			if ($kbftw_kb_post_ids == 0) {
				return $tabs;
			}
		}

		if (isset($bkb_data['bkb_woo_tab_position']) && is_numeric($bkb_data['bkb_woo_tab_position'])) {

			$bkb_woo_tab_position = trim($bkb_data['bkb_woo_tab_position']);
		}


		// Specefic Product Knowledgebase Tab Hide section.

		$bkb_woo_tab_hide_status =  get_post_meta($product->get_id(), 'bkb_woo_tab_hide_status', true);

		// Checkbox to select conversion fix
		// Issue is: For checkbox data will saved in to string format. Means, if user checked the check box then 
		// data saved as "on".  So, we are going to check that and trun this value in to a number..

		if (isset($bkb_woo_tab_hide_status) && $bkb_woo_tab_hide_status == 'on') {
			$bkb_woo_tab_hide_status = 1;
		}

		if (isset($bkb_woo_tab_hide_status) && $bkb_woo_tab_hide_status == 1) {

			return $tabs;
		}


		$kbtfw_total_kbss_string = "";

		$get_kbftw_kb_post_ids = apply_filters('filter_kbtfwc_content_data', get_post_meta($product->get_id(), 'kbftw_kb_post_ids'));

		$kbftw_kb_post_ids =  implode(',',  $get_kbftw_kb_post_ids);

		$tabs['kbtfw_tab'] = [
			'title' => $bkb_tab_title . $kbtfw_total_kbss_string,
			'priority' => $bkb_woo_tab_position, // Always display at the end of tab :)
			'callback' => [$this, 'kbtfw_custom_tab_panel_content'],
			'content' => do_shortcode('[bkb_woo_tab post_ids="' . $kbftw_kb_post_ids . '"/]') // custom field
		];

		return $tabs;
	}

	public function kbtfw_custom_tab_panel_content($key, $tab)
	{

		// allow shortcodes to function
		$content = apply_filters('the_content', $tab['content']);
		$content = str_replace(']]>', ']]&gt;', $content);
		echo apply_filters('kbtfw_woocommerce_custom_product_tabs_content', $content, $tab);
	}
}
