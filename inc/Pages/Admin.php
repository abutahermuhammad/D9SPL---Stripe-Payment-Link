<?php

/**
 * @package D9spl
 */

namespace Inc\Pages;

use \Inc\Init;
use \Inc\Pages\Settings;
use \Inc\Pages\NewLink;
use \Inc\Pages\PaymentLinks;

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
            [$this, 'render_settings_view']
        );
    }

    public function link_index()
    {
        $new_link = Init::get_instance(PaymentLinks::class);

        $new_link->render_view();

        // require_once D9SPL_PLUGIN_DIR . '/templates/links.php';
    }

    public function link_add_new()
    {
        $new_link = Init::get_instance(NewLink::class);

        $new_link->render_view();
    }

    public function render_settings_view()
    {
        $settings = Init::get_instance(Settings::class);

        $settings->render_view();
    }
}
