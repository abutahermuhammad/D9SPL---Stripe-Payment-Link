<?php

/**
 * @package D9SPL
 */

namespace Inc\Base;

class Database
{
    private $table_name;

    public function __construct()
    {
        global $wpdb;
        $this->table_name = $wpdb->prefix . 'd9spl_payment_links';
    }

    /**
     * This function will create our plugin table in the database.
     * Which will contain all the custom generated payment link within
     * their respective information.
     */
    public function create_db_table()
    {
        global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE IF NOT EXISTS $this->table_name (
                id mediumint(9) NOT NULL AUTO_INCREMENT,
                product_id varchar(255) NULL,
                price_id varchar(255) NULL,
                link_id varchar(255) NULL,
                created_at datetime NULL,
                product_created_at datetime NULL,
                product_name varchar(255) NULL,
                currency varchar(3) NULL,
                amount decimal(10, 2) NULL,
                created_by varchar(52) NULL,
                email varchar(52) NULL,
                link varchar(52) NULL,
                PRIMARY KEY (id)
                ) $charset_collate;";

        if (!function_exists('dbDelta')) {
            require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        }

        dbDelta($sql);
    }

    /**
     * This method will add record in the table.
     */
    public function create_record($args = [])
    {
        global $wpdb;

        $defaults = [
            'product_id' => '',
            'price_id' => '',
            'link_id' => '',
            'created_at' => current_time('mysql'),
            'product_created_at' => '',
            'product_name' => '',
            'currency' => '',
            'amount' => '',
            'created_by' => get_current_user_id(),
            'email' => '',
            'link' => '',
        ];

        $data = wp_parse_args($args, $defaults);

        $wpdb->insert(
            $this->table_name,
            $data,
            [
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%d',
                '%s',
                '%s',
                '%s',
            ]
        );
    }

    /**
     * This method will retrive all the records in the table.
     */
    public function get_records($limit = 20, $offset = 0)
    {
        global $wpdb;

        $sql = $wpdb->prepare("SELECT * FROM $this->table_name ORDER BY id DESC LIMIT %d OFFSET %d", $limit, $offset);
        return $wpdb->get_results($sql, ARRAY_A);
    }

    /**
     * This metod will remove the table with all it's records.
     */
    public function remove_db_table()
    {
        global $wpdb;
        $wpdb->query("DROP TABLE IF EXISTS $this->table_name");
    }
}
