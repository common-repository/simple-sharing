<?php

/**
 * The file that defines the core plugin class
 *
 * @link       http://exxica.com
 * @since      1.0.0
 *
 * @package    Exxica_Simple_Sharing
 * @subpackage Exxica_Simple_Sharing/includes
 */

/**
 * The core plugin class.
 *
 * @since      1.0.0
 * @package    Exxica_Simple_Sharing
 * @subpackage Exxica_Simple_Sharing/admin
 * @author     Gaute Rønningen <gaute@exxica.com>
 */
class Exxica_Simple_Sharing {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Exxica_Simple_Sharing_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the Dashboard and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->plugin_name = 'exxica-simple-sharing';
		$this->version = '2.0.2';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

		$dummy = array(
			__('page_email', $this->plugin_name),
			__('post_email', $this->plugin_name)
		);

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Exxica_Simple_Sharing_Loader. Orchestrates the hooks of the plugin.
	 * - Exxica_Simple_Sharing_i18n. Defines internationalization functionality.
	 * - Exxica_Simple_Sharing_Admin. Defines all hooks for the dashboard.
	 * - Exxica_Simple_Sharing_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {


		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-exxica-simple-sharing-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-exxica-simple-sharing-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the Dashboard.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-exxica-simple-sharing-admin.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-exxica-simple-sharing-settings.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-exxica-simple-sharing-public.php';

		$this->loader = new Exxica_Simple_Sharing_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Exxica_Simple_Sharing_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Exxica_Simple_Sharing_i18n();
		$plugin_i18n->set_domain( $this->get_plugin_name() );

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the dashboard functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @since 	 1.1.2 			Added handlers.
	 * @access   private
	 */
	private function define_admin_hooks() {
		// Admin
		$plugin_admin = new Exxica_Simple_Sharing_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

		//$this->loader->add_action( 'add_meta_boxes', $plugin_admin, 'exxica_simple_sharing_content_box' );
		//$this->loader->add_action( 'save_post', $plugin_admin, 'exxica_simple_sharing_save_meta_box' );

		$settings_admin = new Exxica_Simple_Sharing_Admin_Settings( $this->get_plugin_name(), $this->get_version() );
		
		$this->loader->add_action( 'admin_menu', $settings_admin, 'exxica_sharing_options_page');
  		$this->loader->add_action( 'admin_init', $settings_admin, 'exxica_sharing_register_settings' );
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		// Public
		$plugin_public = new Exxica_Simple_Sharing_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

		// Load shortcodes
		$this->loader->add_action( 'init', $plugin_public, 'init_shortcodes' );

		// Insert sharing shortcode
		//$this->loader->add_filter( 'the_content', $plugin_public, 'insert_sharing_shortcode');
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Exxica_Simple_Sharing_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
