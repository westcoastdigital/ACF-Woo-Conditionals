<?php
/**
 * Plugin Name: ACF Woo Conditionals
 * Plugin URI: https://example.com/
 * Description: This plugin adds conditional logic for Advanced Custom Fields and WooCommerce.
 * Version: 1.0.0
 * Author: Jon Mather
 * Author URI: https://jonmather.au/
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: translate
 */

// if accessed directly, then exit
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('ACF_WOO_CONDITIONALS_VERSION', '1.0.0');
define('ACF_WOO_CONDITIONALS_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('ACF_WOO_CONDITIONALS_PLUGIN_URL', plugin_dir_url(__FILE__));
define('ACF_WOO_CONDITIONALS_PLUGIN_BASENAME', plugin_basename(__FILE__));
define('ACF_WOO_CONDITIONALS_PLUGIN_FILE', __FILE__);

// Include the main plugin class
require_once ACF_WOO_CONDITIONALS_PLUGIN_DIR . 'inc/class-setup.php';
