<?php 
 /**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://jacobrossdev.com
 * @since             1.0.0
 * @package           woo-product-table
 *
 * @wordpress-plugin
 * Plugin Name:       WooCommerce Product table
 * Plugin URI:        https://jacobrossdev.com
 * Description:       This is a plugin that creates a table of products. Customers can quickly update their shopping cart from the WooCommerce Product Table. To place your table in a page, use the <code>[woo_product_table]</code> shortcode.
 * Version:           1.0.0
 * Author:            Jacob Ross Web & App Development
 * Author URI:        https://jacobrossdev.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       woo-product-table
 * Domain Path:       /languages
 */
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 */
function activate_woo_product_table() {

}
/**
 * The code that runs during plugin deactivation.
 */
function deactivate_woo_product_table() {

}
register_activation_hook( __FILE__, 'activate_woo_product_table' );
register_deactivation_hook( __FILE__, 'deactivate_woo_product_table' );


/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_woo_product_table() {
}

add_action( 'plugins_loaded', 'run_woo_product_table', 10, 0 );
include 'include/actions.php';