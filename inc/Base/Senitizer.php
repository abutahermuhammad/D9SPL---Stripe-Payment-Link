<?php

/**
 * @package D9SPL
 */

namespace Inc\Base;

class Senitizer
{
    public static function sanitizeText($input)
    {
        $output = sanitize_text_field($input);
        return $output;
    }

    public static function sanitizeEmail($input)
    {
        $output = sanitize_email($input);
        return $output;
    }

    public static function sanitizeNumber($input)
    {
        $output = sanitize_text_field($input);
        return $output;
    }

    public static function sanitizePrice($input)
    {
        $output = sanitize_text_field($input);
        return $output;
    }
}
