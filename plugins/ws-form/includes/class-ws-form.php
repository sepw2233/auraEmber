<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 */
final class WS_Form {

	// Loader
	protected $loader;

	// Plugin name
	protected $plugin_name;

	// Version
	protected $version;


	// Plugin Public
	public $plugin_public;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 */
	public function __construct() {

		$this->plugin_name = WS_FORM_NAME;
		$this->version = WS_FORM_VERSION;
		$plugin_path = plugin_dir_path(dirname(__FILE__));

		// The class responsible for all common functions
		require_once $plugin_path . 'includes/class-ws-form-common.php';


		$this->load_dependencies();

		$this->plugin_public = new WS_Form_Public();

		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
		$this->define_public_shortcodes();
		$this->define_api_hooks();

	}

	// Load the required dependencies for this plugin.
	private function load_dependencies() {

		// Configuration (Options, field types, field variables)
		require_once WS_FORM_PLUGIN_DIR_PATH . 'includes/class-ws-form-config.php';

		// The class responsible for orchestrating the actions and filters of the core plugin
		require_once WS_FORM_PLUGIN_DIR_PATH . 'includes/class-ws-form-loader.php';

		// The class responsible for defining internationalization functionality of the plugin
		require_once WS_FORM_PLUGIN_DIR_PATH . 'includes/class-ws-form-i18n.php';

		// The classes responsible for populating WP List Tables
		if(is_admin()) {

			require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
			require_once WS_FORM_PLUGIN_DIR_PATH . 'admin/class-ws-form-wp-list-table-form.php';
			require_once WS_FORM_PLUGIN_DIR_PATH . 'admin/class-ws-form-wp-list-table-submit.php';
			require_once WS_FORM_PLUGIN_DIR_PATH . 'admin/class-ws-form-wp-list-table-style.php';
		}

		// The class responsible for defining all actions that occur in the admin area
		require_once WS_FORM_PLUGIN_DIR_PATH . 'admin/class-ws-form-admin.php';

		// The class responsible for defining all actions that occur in the public-facing side of the site
		require_once WS_FORM_PLUGIN_DIR_PATH . 'public/class-ws-form-public.php';

		// The class responsible for managing form previews
		require_once WS_FORM_PLUGIN_DIR_PATH . 'public/class-ws-form-preview.php';

		// The class responsible for the widget
		require_once WS_FORM_PLUGIN_DIR_PATH . 'includes/class-ws-form-widget.php';

		// Core
		require_once WS_FORM_PLUGIN_DIR_PATH . 'includes/core/class-ws-form-core.php';

		// Cron
		require_once WS_FORM_PLUGIN_DIR_PATH . 'includes/core/class-ws-form-cron.php';

		// Color
		require_once WS_FORM_PLUGIN_DIR_PATH . 'includes/class-ws-form-color.php';


		// Object classes
		require_once WS_FORM_PLUGIN_DIR_PATH . 'includes/core/class-ws-form-meta.php';
		require_once WS_FORM_PLUGIN_DIR_PATH . 'includes/core/class-ws-form-form.php';
		require_once WS_FORM_PLUGIN_DIR_PATH . 'includes/core/class-ws-form-group.php';
		require_once WS_FORM_PLUGIN_DIR_PATH . 'includes/core/class-ws-form-section.php';
		require_once WS_FORM_PLUGIN_DIR_PATH . 'includes/core/class-ws-form-field.php';
		require_once WS_FORM_PLUGIN_DIR_PATH . 'includes/core/class-ws-form-submit-meta.php';
		require_once WS_FORM_PLUGIN_DIR_PATH . 'includes/core/class-ws-form-submit.php';
		require_once WS_FORM_PLUGIN_DIR_PATH . 'includes/core/class-ws-form-submit-export.php';
		require_once WS_FORM_PLUGIN_DIR_PATH . 'includes/core/class-ws-form-template.php';
		require_once WS_FORM_PLUGIN_DIR_PATH . 'includes/core/class-ws-form-css.php';
		require_once WS_FORM_PLUGIN_DIR_PATH . 'includes/core/class-ws-form-style.php';
		require_once WS_FORM_PLUGIN_DIR_PATH . 'includes/core/class-ws-form-form-stat.php';

		// Actions
		require_once WS_FORM_PLUGIN_DIR_PATH . 'includes/core/class-ws-form-action.php';

		// Actions - Spam protection
		require_once WS_FORM_PLUGIN_DIR_PATH . 'includes/actions/class-ws-form-action-akismet.php';
		require_once WS_FORM_PLUGIN_DIR_PATH . 'includes/actions/class-ws-form-action-human-presence.php';

		// Actions - GDPR
		require_once WS_FORM_PLUGIN_DIR_PATH . 'includes/actions/class-ws-form-action-data-erasure-request.php';
		require_once WS_FORM_PLUGIN_DIR_PATH . 'includes/actions/class-ws-form-action-data-export-request.php';

		// Actions - Basic
		require_once WS_FORM_PLUGIN_DIR_PATH . 'includes/actions/class-ws-form-action-database.php';
		require_once WS_FORM_PLUGIN_DIR_PATH . 'includes/actions/class-ws-form-action-message.php';
		require_once WS_FORM_PLUGIN_DIR_PATH . 'includes/actions/class-ws-form-action-redirect.php';
		require_once WS_FORM_PLUGIN_DIR_PATH . 'includes/actions/class-ws-form-action-email.php';

		// Data Sources
		require_once WS_FORM_PLUGIN_DIR_PATH . 'includes/core/class-ws-form-data-source.php';
		require_once WS_FORM_PLUGIN_DIR_PATH . 'includes/core/class-ws-form-data-source-cron.php';

		require_once WS_FORM_PLUGIN_DIR_PATH . 'includes/data-sources/class-ws-form-data-source-preset.php';
		require_once WS_FORM_PLUGIN_DIR_PATH . 'includes/data-sources/class-ws-form-data-source-post.php';
		require_once WS_FORM_PLUGIN_DIR_PATH . 'includes/data-sources/class-ws-form-data-source-post-status.php';
		require_once WS_FORM_PLUGIN_DIR_PATH . 'includes/data-sources/class-ws-form-data-source-term.php';
		require_once WS_FORM_PLUGIN_DIR_PATH . 'includes/data-sources/class-ws-form-data-source-user.php';

		// API core
		require_once WS_FORM_PLUGIN_DIR_PATH . 'api/class-ws-form-api.php';

		// Functions
		require_once WS_FORM_PLUGIN_DIR_PATH . 'includes/functions.php';

		// Visual builders
		require_once WS_FORM_PLUGIN_DIR_PATH . 'includes/third-party/beaver-builder/fl-ws-form.php';
		require_once WS_FORM_PLUGIN_DIR_PATH . 'includes/third-party/divi/ws-form/ws-form.php';
		require_once WS_FORM_PLUGIN_DIR_PATH . 'includes/third-party/elementor/elementor.php';
		require_once WS_FORM_PLUGIN_DIR_PATH . 'includes/third-party/oxygen/oxygen.php';
		require_once WS_FORM_PLUGIN_DIR_PATH . 'includes/third-party/bricks/bricks.php';
		require_once WS_FORM_PLUGIN_DIR_PATH . 'includes/third-party/breakdance/breakdance.php';

		// Litespeed
		if(class_exists('LiteSpeed\Core')) {

			require_once WS_FORM_PLUGIN_DIR_PATH . 'includes/third-party/litespeed/litespeed.php';
		}

		// Check for third party components when plugins loaded. Run before add-ons with priority 5.
		add_action('plugins_loaded', function() {

			// WooCommerce
			if(defined('WC_VERSION')) {

				require_once WS_FORM_PLUGIN_DIR_PATH . 'includes/third-party/woocommerce/class-ws-form-woocommerce.php';
				require_once WS_FORM_PLUGIN_DIR_PATH . 'includes/data-sources/class-ws-form-data-source-woocommerce.php';
			}

			// ACF
			if(class_exists('ACF')) {

				require_once WS_FORM_PLUGIN_DIR_PATH . 'includes/third-party/acf/class-ws-form-acf.php';
				require_once WS_FORM_PLUGIN_DIR_PATH . 'includes/data-sources/class-ws-form-data-source-acf.php';
			}

			// Meta Box
			if(class_exists('RWMB_Loader')) {

				require_once WS_FORM_PLUGIN_DIR_PATH . 'includes/third-party/meta-box/class-ws-form-meta-box.php';
				require_once WS_FORM_PLUGIN_DIR_PATH . 'includes/data-sources/class-ws-form-data-source-meta-box.php';
			}

			// Pods
			if(defined('PODS_VERSION')) {

				require_once WS_FORM_PLUGIN_DIR_PATH . 'includes/third-party/pods/class-ws-form-pods.php';
				require_once WS_FORM_PLUGIN_DIR_PATH . 'includes/data-sources/class-ws-form-data-source-pods.php';
			}

			// Toolset
			if(defined('TYPES_VERSION')) {

				require_once WS_FORM_PLUGIN_DIR_PATH . 'includes/third-party/toolset/class-ws-form-toolset.php';
				require_once WS_FORM_PLUGIN_DIR_PATH . 'includes/data-sources/class-ws-form-data-source-toolset.php';
			}

			// JetEngine
			if(class_exists('Jet_Engine')) {

				require_once WS_FORM_PLUGIN_DIR_PATH . 'includes/third-party/jetengine/class-ws-form-jetengine.php';
				require_once WS_FORM_PLUGIN_DIR_PATH . 'includes/data-sources/class-ws-form-data-source-jetengine.php';
			}

			// ACPT
			if(
				class_exists('ACPT') &&
				defined('ACPT_PLUGIN_VERSION') &&
				(WS_Form_Common::version_compare(ACPT_PLUGIN_VERSION, '2.0.0') >= 0)
			) {
				require_once WS_FORM_PLUGIN_DIR_PATH . 'includes/third-party/acpt/class-ws-form-acpt-v2.php';
				require_once WS_FORM_PLUGIN_DIR_PATH . 'includes/data-sources/class-ws-form-data-source-acpt.php';
			}

/*			// Translation

			// WPML
			$translation_enabled = false;
			if(
				defined('ICL_SITEPRESS_VERSION') &&
				defined('WPML_ST_VERSION')
			) {
				require_once WS_FORM_PLUGIN_DIR_PATH . 'includes/third-party/wpml/class-ws-form-wpml.php';

				$translation_enabled = true;
			}

			if($translation_enabled) {

				require_once WS_FORM_PLUGIN_DIR_PATH . 'includes/core/class-ws-form-translate.php';
			}
*/

			// Run wsf_loaded action
			do_action('wsf_loaded');
		});

		$this->loader = new WS_Form_Loader();
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the WS_Form_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 */
	private function set_locale() {

		$plugin_i18n = new WS_Form_i18n();

		// Set priority to 0 to ensure it runs before register_widget is called otherwise it knocks out translations
		$this->loader->add_action('init', $plugin_i18n, 'load_plugin_textdomain', 0);
	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 */
	private function define_admin_hooks() {

		global $wp_version;

		$plugin_admin = new WS_Form_Admin();

		// General
		$this->loader->add_action('admin_init', $plugin_admin, 'admin_init');
		$this->loader->add_action('admin_menu', $plugin_admin, 'admin_menu');

		// Gutenberg block
		$this->loader->add_action('init', $plugin_admin, 'register_blocks');

		// Screen options
		$this->loader->add_action('wp_ajax_ws_form_hidden_columns', $plugin_admin, 'ws_form_hidden_columns', 1);
		$this->loader->add_action('set-screen-option', $plugin_admin, 'ws_form_set_screen_option', 10, 3);

		// Enqueuing
		$this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles', 9999);	// Make sure we're overriding other styles
		$this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');

		if(is_admin()) {

			$this->loader->add_action('wp_print_scripts', $plugin_admin, 'wp_print_scripts', 1);
		}

		// Admin notifications
		$this->loader->add_action('admin_notices', 'WS_Form_Common', 'admin_messages_render');

		// Customize
		$this->loader->add_action('customize_register', $plugin_admin, 'customize_register');

		// Theme switching
		$this->loader->add_action('switch_theme', $plugin_admin, 'switch_theme');

		// Plugins
		$this->loader->add_filter('plugin_action_links_' . WS_FORM_PLUGIN_BASENAME, $plugin_admin, 'plugin_action_links');

		// Blocks
		$this->loader->add_action('enqueue_block_assets', $plugin_admin, 'enqueue_block_assets');
		$this->loader->add_action('enqueue_block_editor_assets', $plugin_admin, 'enqueue_block_editor_assets');

 		if(WS_Form_Common::version_compare($wp_version, '5.8') >= 0) {

			$this->loader->add_filter('block_categories_all', $plugin_admin, 'block_categories', 10, 2);

		} else {

			$this->loader->add_filter('block_categories', $plugin_admin, 'block_categories', 10, 2);
		}

		// Patterns
		$this->loader->add_action('init', $plugin_admin, 'pattern_categories');
		$this->loader->add_action('init', $plugin_admin, 'patterns');

		// Dashboard glance items
		$this->loader->add_filter('dashboard_glance_items', $plugin_admin, 'dashboard_glance_items');

		// Toolbar
		$this->loader->add_action('admin_bar_menu', $plugin_admin, 'admin_bar_menu', 99, 1);
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 */
	private function define_public_hooks() {

		// General
		$this->loader->add_action('init', $this->plugin_public, 'init');
		$this->loader->add_action('wp', $this->plugin_public, 'wp');

		// Enqueuing
		$this->loader->add_action('wp_enqueue_scripts', $this->plugin_public, 'enqueue');

		if(!is_admin()) {

			$this->loader->add_action('wp_print_scripts', $this->plugin_public, 'wp_print_scripts', 1);
		}

		// Footer scripts
		$this->loader->add_action('wp_footer', $this->plugin_public, 'wp_footer', 9999);

		// NONCE management
		$this->loader->add_filter('nonce_user_logged_out', $this->plugin_public, 'nonce_user_logged_out', 9999, 2);

		// Divi
		$this->loader->add_action('wp_ajax_ws_form_divi_form', $this->plugin_public, 'ws_form_divi_form');
	}

	/**
	 * Register all of the shortcodes related to the public-facing functionality
	 * of the plugin.
	 */
	private function define_public_shortcodes() {

		$this->loader->add_shortcode('ws_form', $this->plugin_public, 'shortcode_ws_form');
	}

	/**
	 * Register all of the hooks related to the API
	 */
	private function define_api_hooks() {

		$plugin_api = new WS_Form_API();

		// Initialize API
		$this->loader->add_action('rest_api_init', $plugin_api, 'api_rest_api_init');
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}
}
