<?php

/**
 * @package D9SPL
 */

namespace Inc\Base;

class Activate
{
    public static function activate()
    {
        flush_rewrite_rules();
    }

    funciton d9spl_activate_plugin() {
        if (version_compare(get_bloginfo('version'), '5.0', '<')) {
            wp_die(__('You must update WordPress to use this plugin.', 'd9-spl'));
        }
    
        $installed_version = get_option('d9spl_version');
    
        if (!$installed_version) {
            update_option('d9spl_version', D9SPL_VERSION);
        }
    
        update_option('d9spl_version', D9SPL_VERSION);
    }
}
