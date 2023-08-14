<?php

/**
 * @package D9SPL
 */

namespace Inc\Base;


if (!defined('ABSPATH')) exit; // Exit if accessed directly

class SettingsLinks
{
    protected $plugin;

    public function __construct()
    {
        $this->plugin = D9SPL_PLUGIN_NAME;
    }

    public function register()
    {
        add_filter("plugin_action_links_$this->plugin", array($this, "settings_link"));
    }

    public function settings_link($links)
    {
        $settings_link = '<a href="admin.php?page=d9spl-settings">Settings</a>';
        array_push($links, $settings_link);

        return $links;
    }
}
