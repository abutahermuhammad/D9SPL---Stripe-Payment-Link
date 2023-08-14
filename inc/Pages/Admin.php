<?php

/**
 * @package D9spl
 */

namespace Inc\Pages;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class Admin
{
    public function register()
    {
        add_action('admin_menu', [$this, 'add_admin_pages']);
    }


    public function add_admin_pages()
    {
        add_menu_page(
            'Payment Links',
            'Payment Links',
            'manage_options',
            'd9spl-payment-links',
            [$this, 'link_index'],
            'dashicons-paperclip'
        );

        add_submenu_page(
            'd9spl-payment-links',
            'Add New',
            'Add New',
            'manage_options',
            'd9spl-add-new',
            [$this, 'link_add_new']
        );

        add_submenu_page(
            'd9spl-payment-links',
            'Settings',
            'Settings',
            'manage_options',
            'd9spl-settings',
            [$this, 'settings_index']
        );
    }

    public function link_index()
    {
        require_once D9SPL_PLUGIN_DIR . '/templates/links.php';
    }

    public function link_add_new()
    {
        require_once D9SPL_PLUGIN_DIR . '/templates/add-new.php';
    }

    public function settings_index()
    {
        require_once D9SPL_PLUGIN_DIR . '/templates/settings.php';
        settings_page_content();
    }
}
