<?php
/**
 * Plugin Name:       My Plugin Name
 * Description:       My Plugins description
 * Version:           1.0.0
 * Author:            My Name <myname@site.com>
 * Author URI:        https://site.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// MPN = MyPluginName
define( 'MPN_PLUGIN_DIR', __DIR__ );
define( 'MPN_PLUGIN_BASE', plugin_basename( __FILE__ ) );
define( 'MPN_PLUGIN_URL', plugins_url( null, __FILE__ ) );
define( 'MPN_PLUGIN_PREFIX', 'mpn' );

require_once MPN_PLUGIN_DIR . "/includes/class.plugin.php";

try {
	new \MPN\Plugin();
} catch ( Exception $e ) {
	$mpn_plugin_error_func = function () use ( $e ) {
		$error = sprintf( "The %s plugin has stopped. <b>Error:</b> %s Code: %s", 'My Plugin Name', $e->getMessage(), $e->getCode() );
		echo '<div class="notice notice-error"><p>' . $error . '</p></div>';
	};

	add_action( 'admin_notices', $mpn_plugin_error_func );
	add_action( 'network_admin_notices', $mpn_plugin_error_func );
}
