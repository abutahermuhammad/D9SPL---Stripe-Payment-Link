<?php

/**
 * @package D9SPL
 */

namespace Inc\Base;

class Enqueue
{
    public function register()
    {
        add_action('admin_enqueue_scripts', [$this, 'enqueue']);
    }

    public static function enqueue()
    {
        // Enqueue CSS
        wp_enqueue_style('mypluginstyle', plugins_url('/assets/css/style.css', D9SPL_PLUGIN));

        // Enqueue JS
        wp_enqueue_script('mypluginscript', plugins_url('/assets/js/main.js', D9SPL_PLUGIN));
    }
}
