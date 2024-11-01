<?php

/**
 * @link              http://exxica.com
 * @since             1.0.0
 * @package           Exxica_Simple_Sharing
 *
 * @wordpress-plugin
 * Plugin Name:       Exxica Simple Sharing
 * Description:       Adds a simple sharing tool wherever you want.
 * Version:           2.0.2
 * Author:            Gaute Rønningen
 * Author URI:        http://exxica.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       exxica-simple-sharing
 * Domain Path:       /languages
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}

require_once plugin_dir_path( __FILE__ ) . 'includes/class-exxica-simple-sharing-activator.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/class-exxica-simple-sharing-deactivator.php';
register_activation_hook( __FILE__, array( 'Exxica_Simple_Sharing_Activator', 'activate' ) );
register_activation_hook( __FILE__, array( 'Exxica_Simple_Sharing_Deactivator', 'deactivate' ) );

require_once plugin_dir_path( __FILE__ ) . 'includes/class-exxica-simple-sharing.php';

/**
 * Begins execution of the plugin.
 *
 * @since    1.0.0
 */
function run_Exxica_Simple_Sharing() {

	$plugin = new Exxica_Simple_Sharing();
	$plugin->run();

}
run_Exxica_Simple_Sharing();
