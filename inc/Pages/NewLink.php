<?php

/**
 * @package D9SPL
 */

namespace Inc\Pages;

use \Inc\Base\Senitizer;
use \Inc\Base\Database;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class NewLink
{
    public $message = [];
    private $email;
    private $product_name;
    private $price;

    public function __construct()
    {
        $this->email = isset($_POST['d9_form_email']) ? $_POST['d9_form_email'] : '';
        $this->product_name = isset($_POST['d9_form_product_name']) ? $_POST['d9_form_product_name'] : '';
        $this->price = isset($_POST['d9_form_price']) ? $_POST['d9_form_price'] * 100 : 0;
    }

    public function register()
    {
        add_action('admin_init', [$this, 'd9spl_new_link_form_handler']);
    }

    /**
     * This handles form submission. When new submission 
     * occurs, it calls the validation function.
     */
    public function d9spl_new_link_form_handler()
    {
        if (!isset($_POST['generate_payment_link'])) {
            return;
        }

        if (!wp_verify_nonce($_POST['_wpnonce'], 'new-stripe-payment-link-with-custom-product')) {
            wp_die('Are you cheating?');
        }

        // if (!current_user_can('manage-options')) {
        //     wp_die('You are not authorized to perform this opperation!');
        // }

        $validation_result = $this->d9spl_new_link_form_validation();

        if (is_wp_error($validation_result)) {
            // Handle validation errors
            $error_messages = $validation_result->get_error_messages();
            foreach ($error_messages as $error_message) {
                $this->message['error'][] = $error_message;
            }
        } else {
            // Validation passed, proceed to success action
            $this->d9spl_new_link_form_success();
        }
    }

    /**
     * This will handle form validation. If anything unexpected is found,
     * it will return a WP_Error object with error messages.
     */
    public function d9spl_new_link_form_validation()
    {
        $errors = new \WP_Error();

        if (empty($this->email)) {
            $errors->add('no-email', __('You must provide a valid email!', D9SPL_TEXT_DOMAIN));
        }

        if (empty($this->product_name)) {
            $errors->add('no-name', __('You must provide a name!', D9SPL_TEXT_DOMAIN));
        }

        if (empty($this->price)) {
            $errors->add('no-price', __('You must provide a product price!', D9SPL_TEXT_DOMAIN));
        }

        return empty($errors->get_error_codes()) ? true : $errors;
    }

    /**
     * Whe form is validated. This function will run. It will 
     * create Stripe product and generate shortlink for the product.
     */
    public function d9spl_new_link_form_success()
    {
        // Create an instance of the Stripe class
        $stripe_instance = new \Inc\Base\Stripe();

        // Attempt to create a product and payment link in Stripe
        $product = $stripe_instance->create_product($this->product_name, $this->price);
        $payment_link = $stripe_instance->create_payment_link($product['default_price']['id']);

        // Check if Stripe data retrieval was successful
        if ($product && isset($product['id']) && $payment_link && isset($payment_link['id'])) {

            // Create an instance of the Database class
            $database = new Database();

            // Insert data into the database
            $database->create_record([
                'product_id' => $product['id'],
                'price_id' => $product['default_price']['id'],
                'link_id' => $payment_link['id'],
                'product_created_at' => $product['created'],
                'product_name' => $this->product_name,
                'currency' => $payment_link['currency'],
                'amount' => $this->price,
                'created_by' => get_current_user_id(),
                'email' => $this->email,
                'link' => $payment_link['url'],
            ]);

            // Display a success message to the user
            $this->message['success'][] = sprintf(
                '<p class="notice notice-success">Product created successfully. Here is your payment link: <a href="%s">%s</a></p>',
                esc_url($payment_link['url']),
                esc_url($payment_link['url'])
            );

            $redirect_to = admin_url('/admin.php?page=d9spl-add-new&inserted=true');
            wp_redirect($redirect_to);
        } else {
            // Data retrieval from Stripe was not successful, handle the error accordingly
            $this->message['error'][] = '<p class="notice notice-error">Error: Unable to create product and payment link.</p>';
        }

        // $this->message['success'][] = sprintf('<p class="notice notice-success">Product created successfully. Here is your payment link: <a href="%s">%s</a></p>', esc_url($payment_link), esc_url($payment_link));
    }

    /**
     * This function handles form view.
     */
    public function render_view()
    {
        // Check if there are success messages to display
        if (!empty($this->message['success'])) {
            echo '<div class="notice notice-success"><p>' . implode('<br>', $this->message['success']) . '</p></div>';
        }

        // Check if there are error messages to display
        if (!empty($this->message['error'])) {
            echo '<div class="notice notice-error"><p>' . implode('<br>', $this->message['error']) . '</p></div>';
        }

        // Include your form template
        include_once D9SPL_PLUGIN_DIR . '/templates/new-link-form.php';
    }
}
