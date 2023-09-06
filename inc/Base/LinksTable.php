<?php

namespace Inc\Base;

use Inc\Pages\PaymentLinks;

// Importing the class when not available.
if (!class_exists('WP_List_Table')) {
    require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

class LinksTable extends \WP_List_Table
{
    function __construct()
    {
        parent::__construct([
            'singuler' => 'links',
            'plural' => 'link',
            'ajax' => false
        ]);
    }

    public function get_columns()
    {
        return [
            'cb' => '<input type="checkbox" />',
            'product_name' => __('Product', D9SPL_TEXT_DOMAIN),
            'amount' => __('Amount', D9SPL_TEXT_DOMAIN),
            'email' => __('Email', D9SPL_TEXT_DOMAIN),
            'link' => __('Link', D9SPL_TEXT_DOMAIN),
            'created_by' => __('Author', D9SPL_TEXT_DOMAIN),
            'created_at' => __('Date', D9SPL_TEXT_DOMAIN),
        ];
    }

    /**
     * Get sortable columns
     *
     * @return array
     */
    function get_sortable_columns()
    {
        $sortable_columns = [
            'name'       => ['name', true],
            'amount'       => ['amount', true],
            'email'       => ['email', true],
            'created_by'       => ['created_by', true],
            'created_at' => ['created_at', true],
        ];

        return $sortable_columns;
    }

    protected function column_default($item, $column_name)
    {
        switch ($column_name) {
            case 'created_by':
                return isset($item->created_by) ? get_user_by('id', $item->created_by)->display_name : "";
            case 'amount':
                return isset($item->amount) ? $item->amount / 100 : 0;

            default:
                return isset($item->$column_name) ? $item->$column_name : "";
        }
    }

    /**
     * Render the "name" column
     *
     * @param  object $item
     *
     * @return string
     */
    public function column_link($item)
    {
        $actions = [];

        // $actions['edit']   = sprintf('<a href="%s" title="%s">%s</a>', admin_url('admin.php?page=wedevs-academy&action=edit&id=' . $item->id), $item->id, __('Edit', 'wedevs-academy'), __('Edit', 'wedevs-academy'));
        // $actions['delete'] = sprintf('<a href="%s" class="submitdelete" onclick="return confirm(\'Are you sure?\');" title="%s">%s</a>', wp_nonce_url(admin_url('admin-post.php?action=wd-ac-delete-address&id=' . $item->id), 'wd-ac-delete-address'), $item->id, __('Delete', 'wedevs-academy'), __('Delete', 'wedevs-academy'));

        return sprintf(
            '<a href="%1$s" target="_blank"><strong>%2$s</strong></a> %3$s',
            $item->link,
            $item->link,
            $this->row_actions($actions)
        );
    }

    /**
     * Render the "cb" column
     *
     * @param  object $item
     *
     * @return string
     */
    protected function column_cb($item)
    {
        return sprintf(
            '<input type="checkbox" name="address_id[]" value="%d" />',
            $item->id
        );
    }

    public function prepare_items()
    {
        $links = \Inc\Init::get_instance(\Inc\Pages\PaymentLinks::class);
        $columns = $this->get_columns();
        $hidden = [];
        $sortable = $this->get_sortable_columns();

        $this->_column_headers = [$columns, $hidden, $sortable];

        $per_page     = 5;
        $current_page = $this->get_pagenum();
        $offset       = ($current_page - 1) * $per_page;

        $args = [
            'limit' => $per_page,
            'offset' => $offset,
        ];

        if (isset($_REQUEST['orderby']) && isset($_REQUEST['order'])) {
            $args['orderby'] = $_REQUEST['orderby'];
            $args['order']   = $_REQUEST['order'];
        }


        $this->items = $links->get_links($args);

        $this->set_pegination_args([
            'total_items' => $links->get_total_items_count(),
            'per_page' => $per_page,
        ]);
    }
}
