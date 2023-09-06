<?php

/**
 * @package D9SPL
 */

namespace Inc\Base;

use \Inc\Base\Database;

class Deactivate
{
    public static function deactivate()
    {
        flush_rewrite_rules();

        self::drop_payment_table();
    }

    private static function drop_payment_table()
    {
        // Instantiate the Database class to access its methods
        $database = new Database();

        // Call the create_db_table method to create the payment table
        $database->remove_db_table();
    }
}
