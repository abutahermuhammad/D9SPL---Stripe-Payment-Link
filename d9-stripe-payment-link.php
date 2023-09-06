<?php

/**
 * D9 Stripe Payment Link
 *
 * This plugin will add a new menu item under the "Tools" menu called "Stripe Payment Link". This will allow you to create a payment link for a specific amount and currency. You can then copy the link and send it to your customer. The customer will be able to pay the amount you specified using their credit card.
 *
 * @link              https://github.com/abutahermuhammad/d9-stripe-payment-link
 * @since             1.0.0
 * @package           D9SPL
 *
 * @wordpress-plugin
 * Plugin Name:       D9 Stripe Payment Link
 * Plugin URI:        https://github.com/abutahermuhammad/d9-stripe-payment-link
 * Description:       This plugin will add a new menu item under the "Tools" menu called "Stripe Payment Link". This will allow you to create a payment link for a specific amount and currency. You can then copy the link and send it to your customer. The customer will be able to pay the amount you specified using their credit card.
 * Version:           1.0.0
 * Author:            Abu Taher Muhammad <muhammad@dot9.dev>
 * Author URI:        https://github.com/abutahermuhammad
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

if (!defined('ABSPATH')) exit; // Exit if accessed directly

if (file_exists(dirname(__FILE__) . '/vendor/autoload.php')) {
    require_once dirname(__FILE__) . '/vendor/autoload.php';
}

// Define constants for the plugin
define('D9SPL_VERSION', '1.0');
define('D9SPL_REQUIRED_WP_VERSION', '6.0');
define('D9SPL_TEXT_DOMAIN', 'd9spl');
define('D9SPL_PLUGIN', __FILE__);
define('D9SPL_PLUGIN_BASENAME', plugin_basename(D9SPL_PLUGIN));
define('D9SPL_PLUGIN_NAME', trim(dirname(D9SPL_PLUGIN_BASENAME), '/'));
define('D9SPL_PLUGIN_DIR', untrailingslashit(dirname(D9SPL_PLUGIN)));


/* **************************************** */
/* Plugin activation and deactivation hooks */
/* **************************************** */

use Inc\Base\Activate;
use Inc\Base\Deactivate;

/**
 * The code that runs during plugin activation
 * @return void
 * @since 1.0.0
 */
function activate_d9spl_plugin()
{
    Activate::activate();
}
register_activation_hook(D9SPL_PLUGIN, "activate_d9spl_plugin");


/**
 * The code that runs during plugin deactivation
 * @return void
 * @since 1.0.0
 */
function deactivate_d9spl_plugin()
{
    Deactivate::deactivate();
}
register_deactivation_hook(D9SPL_PLUGIN, "deactivate_d9spl_plugin");


// Check if the Inc\Init class exists and register services
if (class_exists('Inc\\Init')) {
    Inc\Init::register_services();
}
