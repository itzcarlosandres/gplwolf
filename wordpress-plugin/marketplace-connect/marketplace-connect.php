<?php
/**
 * Plugin Name: Marketplace Connect
 * Plugin URI:  https://gplwolf.com
 * Description: Conecta tu sitio WordPress con nuestro Marketplace para instalar y actualizar recursos premium.
 * Version:     1.0.0
 * Author:      GPLWolf
 * Author URI:  https://gplwolf.com
 * License:     GPL-2.0+
 * Text Domain: marketplace-connect
 * Requires at least: 5.8
 * Requires PHP:      7.4
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Define Constants
define( 'MARKETPLACE_CONNECT_VERSION', '1.0.0' );
define( 'MARKETPLACE_CONNECT_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'MARKETPLACE_CONNECT_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'MARKETPLACE_API_URL', 'http://localhost:8000/api/v1' ); // Cambiar por URL real en producción

// Include Core Class
require_once MARKETPLACE_CONNECT_PLUGIN_DIR . 'includes/class-marketplace-connect.php';

// Initialize Plugin
function run_marketplace_connect() {
	$plugin = new Marketplace_Connect();
	$plugin->run();
}
run_marketplace_connect();
