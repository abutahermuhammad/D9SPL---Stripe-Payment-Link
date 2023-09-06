<?php

/**
 * @package D9SPL
 */

namespace Inc\Pages;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class Settings
{
    public $settings = [];
    public $sections = [];
    public $fields = [];

    public function register()
    {
        $this->setSettings();
        $this->setSections();
        $this->setFields();

        add_action('admin_init', [$this, 'register_custom_settings']);
    }

    /**
     * Registering custom settings options. like: settings, section, fileds.
     */
    public function register_custom_settings()
    {
        // Register settings
        foreach ($this->settings as $setting) {
            register_setting($setting["option_group"], $setting["option_name"], (isset($setting["callback"]) ? $setting["callback"] : ''));
        }

        // Add settings section
        foreach ($this->sections as $section) {
            add_settings_section($section["id"], $section["title"], (isset($section["callback"]) ? $section["callback"] : ''), $section["page"]);
        }

        // Add settings field
        foreach ($this->fields as $field) {
            add_settings_field($field["id"], $field["title"], (isset($field["callback"]) ? $field["callback"] : ''), $field["page"], $field["section"], (isset($field["args"]) ? $field["args"] : ''));
        }
    }

    /**
     * Adding settins options to the `settings` array.
     */
    public function setSettings()
    {
        $this->settings = [
            [
                "option_group" => "d9spl-settings",
                "option_name" => "d9_settings_key",
                "callback" => [$this, "sanitizeStripeKey"]
            ],
            [
                "option_group" => "d9spl-settings",
                "option_name" => "d9_settings_currency",
                "callback" => [$this, "sanitizeCurrency"]
            ]
        ];
    }

    /**
     * Adding an icon for the `settings` page
     */
    public function setSections()
    {
        $this->sections = [
            [
                "id" => "d9spl_settings_general_section",
                "title" => __("Settings"),
                "callback" => [$this, "d9spl_settings_general_section_cb"],
                "page" => "d9spl-settings"
            ]
        ];
    }

    /**
     * Adding settings fields
     */
    public function setFields()
    {
        $this->fields = [
            [
                "id" => "d9_settings_key",
                "title" => "Stripe Secret Key",
                "callback" => [$this, "d9spl_settings_key_render_view"],
                "page" => "d9spl-settings",
                "section" => "d9spl_settings_general_section",
                "args" => [
                    "label_for" => "d9_settings_key",
                    "description" => esc_html("Enter your stripe account secret key. To find the secret key follow this official documentation at https://stripe.com/docs/keys", "my-plugin-textdomain")
                ]
            ],
            [
                "id" => "d9_settings_currency",
                "title" => "Default Currency",
                "callback" => [$this, "d9spl_settings_currency_render_view"],
                "page" => "d9spl-settings",
                "section" => "d9spl_settings_general_section",
                "args" => [
                    "label_for" => "d9_settings_currency",
                    "description" => __("Select the default currency.", "my-plugin-textdomain")
                ]
            ]
        ];
    }

    // Senitzing `Sripe key`
    public function sanitizeStripeKey($input)
    {
        $output = sanitize_text_field($input);
        return $output;
    }

    /**
     * Senitizing `currenc`.
     */
    public function sanitizeCurrency($input)
    {
        $output = sanitize_text_field($input);
        return $output;
    }

    public function d9spl_settings_general_section_cb()
    {
    }

    public function d9spl_settings_key_render_view($args)
    {
        $value = get_option('d9_settings_key');
        echo '<input class="regular-text" type="password" name="d9_settings_key" id="d9_settings_key" value="' . esc_attr($value) . '" ><p class="description">' . esc_html($args['description']) . '</p>';
    }

    public function d9spl_settings_currency_render_view($args)
    {
        $value = get_option('d9_settings_currency');
        echo '<select name="d9_settings_currency" id="d9_settings_currency">
        <option value="usd"' . selected($value, 'usd', false) . '>USD</option>
        <option value="gbp"' . selected($value, 'gbp', false) . '>GBP</option>
        </select><p class="description">' . esc_html($args['description']) . '</p>';
    }

    public function render_view()
    {
        require_once D9SPL_PLUGIN_DIR . '/templates/settings.php';
    }
}
