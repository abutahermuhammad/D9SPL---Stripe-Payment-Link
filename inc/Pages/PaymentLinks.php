<?php

/**
 * Settings class for D9SPL plugin.
 *
 * @package D9SPL
 */

namespace Inc\Pages;

class PaymentLinks
{
    private $db_table;

    public function __construct()
    {
        global $wpdb;
        // Initialize the database table name
        // $this->db_table = Inc\Init::get_instance(\Inc\Base\Database::class)->table_name;
        $this->db_table = $wpdb->prefix . 'd9spl_payment_links';
    }

    public function register()
    {
        // Add any necessary registration logic here
    }


    /**
     * Fetches Addresses
     * 
     * @param array $args
     * 
     * @return array
     * 
     * @since 1.0.0
     */
    public function get_links($args = [])
    {
        global $wpdb;

        // Define default filter values
        $defaults = [
            'limit' => 20,
            'offset' => 0,
            'orderby' => 'id',
            'order' => 'ASC',
        ];

        // Merge provided args with defaults
        $filter = wp_parse_args($args, $defaults);

        // Query the database to retrieve items
        $items = $wpdb->get_results(
            $wpdb->prepare(
                "SELECT * FROM {$this->db_table} ORDER BY {$filter['orderby']} {$filter['order']} LIMIT %d, %d",
                $filter['offset'],
                $filter['limit']
            )
        );

        return $items;
    }


    /**
     * Getting Total Number of Links
     * 
     * @return int
     * 
     * @since 1.0.0
     */
    public function get_total_items_count()
    {
        global $wpdb;

        // Query the database to get the total count
        return (int) $wpdb->get_var("SELECT COUNT(id) FROM {$this->db_table}");
    }


    public function render_view()
    {
        require_once D9SPL_PLUGIN_DIR . '/templates/links.php';
    }
}
