<?php

/**
 * The dashboard-specific functionality of the plugin.
 *
 * @link       http://exxica.com
 * @since      1.0.0
 *
 * @package    Exxica_Simple_Sharing
 * @subpackage Exxica_Simple_Sharing/includes
 */

/**
 * The dashboard-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the dashboard-specific stylesheet and JavaScript.
 *
 * @package    Exxica_Simple_Sharing
 * @subpackage Exxica_Simple_Sharing/admin
 * @author     Gaute Rønningen <gaute@exxica.com>
 */
class Exxica_Simple_Sharing_Admin 
{

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $name    The ID of this plugin.
	 */
	private $name;

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
	 * @var      string    $name       The name of this plugin.
	 * @var      string    $version    The version of this plugin.
	 */
	public function __construct( $name, $version ) 
	{
		$this->name = $name;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the Dashboard.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() 
	{
		wp_enqueue_style( $this->name, plugin_dir_url( __FILE__ ) . 'css/exxica-simple-sharing-admin.css', array(), $this->version );
	}

	/**
	 * Register the JavaScript for the dashboard.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts($hook) 
	{
		wp_enqueue_script( $this->name, plugin_dir_url( __FILE__ ) . 'js/exxica-simple-sharing-admin.js', array( 'jquery' ), $this->version, FALSE );
	}

	public function exxica_simple_sharing_content_box() {
		$screens = array( 'post', 'page' );

		foreach ( $screens as $screen ) {
			
			add_meta_box(
				'exxica_simple_sharing_metabox',
				__( 'Sharing Box', $this->name ),
				function( $post ) {
					wp_nonce_field( basename( __FILE__ ), 'exxica_simple_sharing_metabox_nonce' );

					$sharing_enabled = esc_attr( get_post_meta( $post->ID, 'exxica_simple_sharing_enabled', true ));
					$sharing_title_enabled = esc_attr( get_post_meta( $post->ID, 'exxica_simple_sharing_title_enabled', true ));
					$sharing_title = esc_attr( get_post_meta( $post->ID, 'exxica_simple_sharing_title', true ));
					$button_size = esc_attr( get_post_meta( $post->ID, 'exxica_simple_sharing_button_size', true));
					$button_icon_type = esc_attr( get_post_meta( $post->ID, 'exxica_simple_sharing_button_icon_type', true));
					$button_has_text = esc_attr( get_post_meta( $post->ID, 'exxica_simple_sharing_button_has_text', true));
					$list_horizontal = esc_attr( get_post_meta( $post->ID, 'exxica_simple_sharing_list_horizontal', true));
					?>
					<p>
						<input type="checkbox" name="exxica_simple_sharing_enabled" id="exxica_simple_sharing_enabled" value="1" <?php checked( $sharing_enabled, "1", true ); ?> /><label for="exxica_simple_sharing_enabled"><?php _e( "Sharing box enabled?", $this->name ); ?></label>
						<br/>
						<input type="checkbox" name="exxica_simple_sharing_title_enabled" id="exxica_simple_sharing_title_enabled" value="1" <?php checked( $sharing_title_enabled, "1", true ); ?> /><label for="exxica_simple_sharing_title_enabled"><?php _e( "Sharing title enabled?", $this->name ); ?></label>
						<br/>
						<label for="exxica_simple_sharing_title"><?php _e( "Title", $this->name ); ?></label><input type="text" name="exxica_simple_sharing_title" id="exxica_simple_sharing_title" value="<?= $sharing_title ?>" />
						<br/>
						<label for="exxica_simple_sharing_button_icon_type"><?= __('Button icon type:', $this->name) ?></label>
						<select name="exxica_simple_sharing_button_icon_type" id="exxica_simple_sharing_button_icon_type">
							<option value="1" <?php selected( $button_icon_type, "1", true ); ?>><?= __('Original', $this->name) ?></option>
							<option value="0" <?php selected( $button_icon_type, "0", true ); ?>><?= __('Simple', $this->name) ?></option>
						</select>
						<br/>
						<label for="exxica_simple_sharing_button_size"><?= __('Button size:', $this->name) ?></label>
						<select name="exxica_simple_sharing_button_size" id="exxica_simple_sharing_button_size">
							<option value="" <?php selected( $button_size, "", true ); ?>><?= __('Normal', $this->name) ?></option>
							<option value="fa-lg" <?php selected( $button_size, "fa-lg", true ); ?>><?= __('XL', $this->name) ?></option>
							<option value="fa-2x" <?php selected( $button_size, "fa-2x", true ); ?>><?= __('2XL', $this->name) ?></option>
							<option value="fa-3x" <?php selected( $button_size, "fa-3x", true ); ?>><?= __('3XL', $this->name) ?></option>
							<option value="fa-4x" <?php selected( $button_size, "fa-4x", true ); ?>><?= __('4XL', $this->name) ?></option>
						</select>
						<br/>
						<label for="exxica_simple_sharing_button_has_text"><?= __('Button text enabled:', $this->name) ?></label>
						<select name="exxica_simple_sharing_button_has_text" id="exxica_simple_sharing_button_has_text">
							<option value="1" <?php selected( $button_has_text, "1", true ); ?>><?= __('Yes', $this->name) ?></option>
							<option value="0" <?php selected( $button_has_text, "0", true ); ?>><?= __('No', $this->name) ?></option>
						</select>
						<br/>
						<label for="exxica_simple_sharing_list_horizontal"><?= __('List direction:', $this->name) ?></label>
						<select name="exxica_simple_sharing_list_horizontal" id="exxica_simple_sharing_list_horizontal">
							<option value="1" <?php selected( $list_horizontal, "1", true ); ?>><?= __('Horizontal', $this->name) ?></option>
							<option value="0" <?php selected( $list_horizontal, "0", true ); ?>><?= __('Vertical', $this->name) ?></option>
						</select>
					</p>
					<?php
				},
				$screen,
				'side',
				'high'
			);
		}
	}

	public function exxica_simple_sharing_save_meta_box( $post_id ) {
		if(isset($_POST['exxica_simple_sharing_metabox_nonce']) && !wp_verify_nonce( basename( __FILE__ ), $_POST['exxica_simple_sharing_metabox_nonce'] ) ) {
			update_post_meta( $post_id, 'exxica_simple_sharing_enabled', (isset($_POST['exxica_simple_sharing_enabled']) ? true : false ));
			update_post_meta( $post_id, 'exxica_simple_sharing_title_enabled', (isset($_POST['exxica_simple_sharing_title_enabled']) ? true : false ));
			update_post_meta( $post_id, 'exxica_simple_sharing_title', $_POST['exxica_simple_sharing_title']);
			update_post_meta( $post_id, 'exxica_simple_sharing_button_size', $_POST['exxica_simple_sharing_button_size']);
			update_post_meta( $post_id, 'exxica_simple_sharing_button_icon_type',  $_POST['exxica_simple_sharing_button_icon_type']);
			update_post_meta( $post_id, 'exxica_simple_sharing_button_has_text',  $_POST['exxica_simple_sharing_button_has_text']);
			update_post_meta( $post_id, 'exxica_simple_sharing_list_horizontal', $_POST['exxica_simple_sharing_list_horizontal']);
		}
		return $post_id;
	}
}