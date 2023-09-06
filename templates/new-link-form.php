<?php

/**
 * @package D9SPL
 */
?>

<div class="wrap">
    <h1><?php _e('Generate Stripe Payment Link', D9SPL_TEXT_DOMAIN); ?></h1>

    <?php settings_errors(); ?>

    <?php
    if (!empty($this->message)) {
        if (!empty($this->message['success'])) {
            echo '<div class="notice success"><p>' . esc_html($this->message['success']) . '</p></div>';
        }

        if (!empty($this->message['error'])) {
            echo '<div class="notice error"><p>' . esc_html($this->message['error']) . '</p></div>';
        }
    }
    ?>

    <form method="POST" action="options.php">
        <table class="form-table" role="presentation">
            <tbody>
                <tr>
                    <th scope="row"><label for="d9_form_email"><?php _e('Customer email:', D9SPL_TEXT_DOMAIN); ?></label></th>
                    <td>
                        <input class="regular-text" type="email" name="d9_form_email" id="d9_form_email" required>
                        <p class="description"></p>
                    </td>
                </tr>

                <tr>
                    <th scope="row"><label for="d9_form_product_name"><?php _e('Product Name:', D9SPL_TEXT_DOMAIN); ?></label></th>
                    <td>
                        <input class="regular-text" type="text" name="d9_form_product_name" id="d9_form_product_name" required>
                        <p class="description"></p>
                    </td>
                </tr>

                <tr>
                    <th scope="row"><label for="d9_form_price"><?php _e('Amount:', D9SPL_TEXT_DOMAIN); ?></label></th>
                    <td>
                        <input class="regular-text" type="number" name="d9_form_price" id="d9_form_price" min="1" step="0.01" required>
                        <p class="description"></p>
                    </td>
                </tr>
            </tbody>
        </table>

        <?php wp_nonce_field('new-stripe-payment-link-with-custom-product'); ?>
        <?php submit_button('Generate payment link', 'primary', 'generate_payment_link'); ?>
    </form>
</div>