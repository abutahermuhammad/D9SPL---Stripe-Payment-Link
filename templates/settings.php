<?php

/**
 * @package D9SPL
 */

function settings_page_content()
{
?>
    <div class="wrap">
        <h1><?php esc_html_e('Plugin Settings', 'my-plugin-textdomain'); ?></h1>

        <!-- Page Messages -->
        <?php settings_errors(); ?>

        <form method="POST" action="options.php">
            <table class="form-table" role="presentation">
                <tbody>
                    <?php
                    settings_fields('d9spl-settings');
                    do_settings_sections('d9spl-settings');
                    ?>
                </tbody>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
<?php
}
