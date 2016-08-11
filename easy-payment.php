<?php

/**
 *
 * @wordpress-plugin
 * Plugin Name:       Easy Payment
 * Plugin URI:        http://mbjtechnolabs.com
 * Description:       Easy to use add a PayPal Payment button as a Page, Post and Widget with a shortcode
 * Version:           1.1.6
 * Author:            mbj-webdevelopment
 * Author URI:        http://www.mbjtechnolabs.com
 * License:           GNU General Public License v3.0
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain:       easy-payment
 * Domain Path:       /languages
 */
// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

if (!defined('PPW_PLUGIN_URL'))
    define('PPW_PLUGIN_URL', plugin_dir_url(__FILE__));

if (!defined('PPW_PLUGIN_DIR'))
    define('PPW_PLUGIN_DIR', dirname(__FILE__));

/**
 * define plugin basename
 */
if (!defined('PPW_PLUGIN_BASENAME')) {
    define('PPW_PLUGIN_BASENAME', plugin_basename(__FILE__));
}

if (!defined('EP_WORDPRESS_LOG_DIR')) {
    $upload_dir = wp_upload_dir();
    define('EP_WORDPRESS_LOG_DIR', $upload_dir['basedir'] . '/easy-payment-logs/');
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-easy-payment-activator.php
 */
function activate_easy_payment() {
    require_once plugin_dir_path(__FILE__) . 'includes/class-easy-payment-activator.php';
    GMEX_Easy_Payment_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-easy-payment-deactivator.php
 */
function deactivate_easy_payment() {
    require_once plugin_dir_path(__FILE__) . 'includes/class-easy-payment-deactivator.php';
    GMEX_Easy_Payment_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_easy_payment');
register_deactivation_hook(__FILE__, 'deactivate_easy_payment');

/**
 * The core plugin class that is used to define internationalization,
 * dashboard-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-easy-payment.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_easy_payment() {

    $plugin = new GMEX_Easy_Payment();
    $plugin->run();
}

run_easy_payment();