<?php

/**
 * @package D9SPL
 */

namespace Inc\Base;

use Inc\Base\Database;

class Activate
{
    public static function activate()
    {
        flush_rewrite_rules();

        // Call the activation function to check WordPress version and set the plugin version
        self::d9spl_activate_plugin();


        // Create the payment table when the plugin is activated
        self::create_payment_table();
    }


    private static function d9spl_activate_plugin()
    {
        if (version_compare(get_bloginfo('version'), '5.0', '<')) {
            wp_die(__('You must update WordPress to use this plugin.', 'd9-spl'));
        }

        $installed_version = get_option('d9spl_version');

        if (!$installed_version) {
            update_option('d9spl_version', D9SPL_VERSION);
        }
    }

    private static function create_payment_table()
    {
        // Instantiate the Database class to access its methods
        $database = new Database();

        // Call the create_db_table method to create the payment table
        $database->create_db_table();
    }
}
