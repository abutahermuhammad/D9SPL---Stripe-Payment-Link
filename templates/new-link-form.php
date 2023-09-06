<?php

/**
 * @package D9SPL
 */

// $message = '';


?>
<div class="wrap">
    <h1><?php _e('Generate Stripe Payment Link', 'my-plugin-textdomain'); ?></h1>

    <?php
    var_dump($message);
    // Check if there's a success message to display
    if (!empty($message)) {
        echo '<div class="notice success"><p>' . esc_html($message) . '</p></div>';
    }
    ?>

    <form method="POST" action="options.php">
        <table class="form-table" role="presentation">
            <tbody>
                <tr>
                    <th scope="row"><label for="d9_settings_key">User Email:</label></th>
                    <td>
                        <input class="regular-text" type="email" name="d9_form_email" id="d9_form_email" required>
                        <p class="description"></p>
                    </td>
                </tr>

                <tr>
                    <th scope="row"><label for="d9_settings_key">Product Name:</label></th>
                    <td>
                        <input class="regular-text" type="text" name="d9_form_product_name" id="d9_form_product_name" required>
                        <p class="description"></p>
                    </td>
                </tr>

                <tr>
                    <th scope="row"><label for="d9_settings_key">Price:</label></th>
                    <td>
                        <input class="regular-text" type="number" name="d9_form_price" id="d9_form_price" step="0.01" required>
                        <p class="description"></p>
                    </td>
                </tr>
            </tbody>
        </table>

        <?php wp_nonce_field('new-stripe-payment-link-with-custom-product'); ?>
        <?php submit_button('Generate payment link', 'primary', 'generate_payment_link'); ?>
    </form>
</div>