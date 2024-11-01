<?php

/**
 * @link       http://exxica.com
 * @since      1.0.0
 *
 */

/**
 * @package    Exxica_Simple_Sharing
 * @subpackage Exxica_Simple_Sharing/admin
 * @author     Gaute Rønningen <gaute@exxica.com>
 */
class Exxica_Simple_Sharing_Admin_Settings {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	public function exxica_sharing_register_settings() {
		register_setting( 'exxica_sharing_settings', 'exxica_sharing_enabled_default' );
		register_setting( 'exxica_sharing_settings', 'exxica_sharing_title_enabled_default' );
		register_setting( 'exxica_sharing_settings', 'exxica_sharing_title_default' );
		register_setting( 'exxica_sharing_settings', 'exxica_sharing_button_size_default' );
		register_setting( 'exxica_sharing_settings', 'exxica_sharing_button_icon_type_default' );
		register_setting( 'exxica_sharing_settings', 'exxica_sharing_button_has_text_default' );
		register_setting( 'exxica_sharing_settings', 'exxica_sharing_list_horizontal_default' );

        add_settings_section(
            'exxica_sharing_settings_section',
            __( 'Default values', $this->plugin_name ),
            array($this, 'exxica_sharing_settings_cb'),
            'exxica_settings'
        );

        add_settings_field(
            'exxica_sharing_enabled_default',
            __( 'Sharing box enabled?', $this->plugin_name ),
            array($this, 'exxica_sharing_enabled_default_cb'),
            'exxica_settings',
            'exxica_sharing_settings_section',
            [
                'field_name' => 'exxica_sharing_enabled_default'
            ]
        );

        add_settings_field(
            'exxica_sharing_title_enabled_default',
            __( 'Sharing title enabled?', $this->plugin_name ),
            array($this, 'exxica_sharing_title_enabled_default_cb'),
            'exxica_settings',
            'exxica_sharing_settings_section',
            [
                'field_name' => 'exxica_sharing_title_enabled_default'
            ]
        );

        add_settings_field(
            'exxica_sharing_title_default',
            __( 'Title', $this->plugin_name ),
            array($this, 'exxica_sharing_title_default_cb'),
            'exxica_settings',
            'exxica_sharing_settings_section',
            [
                'field_name' => 'exxica_sharing_title_default'
            ]
        );

        add_settings_field(
            'exxica_sharing_button_icon_type_default',
            __('Button icon type:', $this->plugin_name),
            array($this, 'exxica_sharing_button_icon_type_default_cb'),
            'exxica_settings',
            'exxica_sharing_settings_section',
            [
                'field_name' => 'exxica_sharing_button_icon_type_default'
            ]
        );

        add_settings_field(
            'exxica_sharing_button_size_default',
            __('Button size:', $this->plugin_name),
            array($this, 'exxica_sharing_button_size_default_cb'),
            'exxica_settings',
            'exxica_sharing_settings_section',
            [
                'field_name' => 'exxica_sharing_button_size_default'
            ]
        );

        add_settings_field(
            'exxica_sharing_button_has_text_default',
            __('Button text enabled:', $this->plugin_name),
            array($this, 'exxica_sharing_button_has_text_default_cb'),
            'exxica_settings',
            'exxica_sharing_settings_section',
            [
                'field_name' => 'exxica_sharing_button_has_text_default'
            ]
        );

        add_settings_field(
            'exxica_sharing_list_horizontal_default',
            __('List direction:', $this->plugin_name),
            array($this, 'exxica_sharing_list_horizontal_default_cb'),
            'exxica_settings',
            'exxica_sharing_settings_section',
            [
                'field_name' => 'exxica_sharing_list_horizontal_default'
            ]
        );
	}

    function exxica_sharing_settings_cb( $args ) {
    }

    function exxica_sharing_enabled_default_cb( $args ) {
        $options = get_option( 'exxica_sharing_enabled_default' );
        ?>
        <input type="checkbox" name="<?= esc_attr($args['field_name']) ?>" id="<?= esc_attr($args['field_name']) ?>" value="1" <?php checked( $options, "1", true ); ?> />
        <?php
    }

    function exxica_sharing_title_enabled_default_cb( $args ) {
        $options = get_option( 'exxica_sharing_title_enabled_default' );
        ?>
        <input type="checkbox" name="<?= esc_attr($args['field_name']) ?>" id="<?= esc_attr($args['field_name']) ?>" value="1" <?php checked( $options, "1", true ); ?> />
        <?php
    }

    function exxica_sharing_title_default_cb( $args ) {
        $options = get_option( 'exxica_sharing_title_default' );
        ?>
		<input type="text" class="widefat" name="<?= esc_attr($args['field_name']) ?>" id="<?= esc_attr($args['field_name']) ?>" value="<?= $options ?>" />
        <?php
    }

    function exxica_sharing_button_icon_type_default_cb( $args ) {
        $options = get_option( 'exxica_sharing_button_icon_type_default' );
        ?>
        <select class="widefat" name="<?= esc_attr($args['field_name']) ?>" id="<?= esc_attr($args['field_name']) ?>">
            <option value="1" <?php selected( $options, "1", true ); ?>><?= __('Original', $this->plugin_name) ?></option>
            <option value="0" <?php selected( $options, "0", true ); ?>><?= __('Simple', $this->plugin_name) ?></option>
        </select>
        <?php
    }

    function exxica_sharing_button_size_default_cb( $args ) {
        $options = get_option( 'exxica_sharing_button_size_default' );
        ?>
        <select class="widefat" name="<?= esc_attr($args['field_name']) ?>" id="<?= esc_attr($args['field_name']) ?>">
            <option value="" <?php selected( $options, "", true ); ?>><?= __('Normal', $this->plugin_name) ?></option>
            <option value="fa-lg" <?php selected( $options, "fa-lg", true ); ?>><?= __('XL', $this->plugin_name) ?></option>
            <option value="fa-2x" <?php selected( $options, "fa-2x", true ); ?>><?= __('2XL', $this->plugin_name) ?></option>
            <option value="fa-3x" <?php selected( $options, "fa-3x", true ); ?>><?= __('3XL', $this->plugin_name) ?></option>
            <option value="fa-4x" <?php selected( $options, "fa-4x", true ); ?>><?= __('4XL', $this->plugin_name) ?></option>
        </select>
        <?php
    }

    function exxica_sharing_button_has_text_default_cb( $args ) {
        $options = get_option( 'exxica_sharing_button_has_text_default' );
        ?>
        <select class="widefat" name="<?= esc_attr($args['field_name']) ?>" id="<?= esc_attr($args['field_name']) ?>">
            <option value="1" <?php selected( $options, "1", true ); ?>><?= __('Yes', $this->plugin_name) ?></option>
            <option value="0" <?php selected( $options, "0", true ); ?>><?= __('No', $this->plugin_name) ?></option>
        </select>
        <?php
    }

    function exxica_sharing_list_horizontal_default_cb( $args ) {
        $options = get_option( 'exxica_sharing_list_horizontal_default' );
        ?>
        <select class="widefat" name="<?= esc_attr($args['field_name']) ?>" id="<?= esc_attr($args['field_name']) ?>">
            <option value="1" <?php selected( $options, "1", true ); ?>><?= __('Horizontal', $this->plugin_name) ?></option>
            <option value="0" <?php selected( $options, "0", true ); ?>><?= __('Vertical', $this->plugin_name) ?></option>
        </select>
        <?php
    }

    function exxica_sharing_options_page() {
        add_menu_page(
            __('Sharing box options', $this->plugin_name),
            __('Exxica', $this->plugin_name),
            'manage_options',
            'exxica_settings',
            array($this, 'exxica_sharing_options_page_html'),
            'dashicons-admin-multisite'
        );
    }

    function exxica_sharing_options_page_html() {
        if ( ! current_user_can( 'manage_options' ) ) return;
        if ( isset( $_GET['settings-updated'] ) ) add_settings_error( 'exxica_sharing_messages', 'exxica_sharing_message', __( 'Settings Saved', $this->plugin_name ), 'updated' );
        settings_errors( 'exxica_sharing_messages' );
        ?>
        <div class="wrap">
            <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
            <form action="options.php" method="post">
                <?php
                settings_fields( 'exxica_sharing_settings' );
                do_settings_sections( 'exxica_settings' );
                submit_button( __( 'Save Settings', $this->plugin_name ) );
                ?>
            </form>
        </div>
    <?php
    }
}