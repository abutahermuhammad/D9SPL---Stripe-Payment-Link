<?php

/**
 * @package D9SPL
 */

?>
<div class="wrap">
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
