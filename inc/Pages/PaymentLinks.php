<?php

namespace Inc\Pages;

class PaymentLinks
{

    public function register()
    {
    }

    public function render_view()
    {
        require_once D9SPL_PLUGIN_DIR . '/templates/links.php';
    }
}
