<?php

if (!class_exists('WP_List_Table')) {
    require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

/**
 * List table class
 */
class Rentals_list_table extends \WP_List_Table {

    function __construct() {
        parent::__construct(array(
            'singular' => 'rental',
            'plural' => 'rentals',
            'ajax' => false
        ));
    }

    function get_table_classes() {
        return array('widefat', 'fixed', 'striped', $this->_args['plural']);
    }

    /**
     * Message to show if no designation found
     *
     * @return void
     */
    function no_items() {
        _e('no rentals found', '');
    }

    /**
     * Default column values if no callback found
     *
     * @param  object  $item
     * @param  string  $column_name
     *
     * @return string
     */
    function column_default($item, $column_name) {

        switch ($column_name) {
            case 'Print_Key':
                return $item->Print_Key;

            default:
                return isset($item->$column_name) ? $item->$column_name : '';
        }
    }

    /**
     * Get the column names
     *
     * @return array
     */
    function get_columns() {
        $columns = array(
            'cb' => '<input type="checkbox" />',
            'Print_Key' => __('Print Key', ''),
            'Address' => __('Address', ''),
            'num_units' => __('Number of units', ''),
            'occupied_units' => __('Number Occupied', ''),
        );

        return $columns;
    }

    function get_hidden() {
        $hidden = array(
            'status' => __('status', '')
        );

        return $hidden;
    }

    /**
     * Render the designation name column
     *
     * @param  object  $item
     *
     * @return string
     */
    function column_Print_Key($item) {

        $actions = array();
        $actions['edit'] = sprintf('<a href="%s" data-id="%d" title="%s">%s</a>', admin_url('admin.php?page=rentals&action=edit&registration_id=' . $item->registration_id), $item->registration_id, __('Edit this item', ''), __('Edit', ''));
        $actions['delete'] = sprintf('<a href="%s" class="submitdelete" data-id="%d" title="%s">%s</a>', admin_url('admin.php?page=rentals&action=delete&id=' . $item->registration_id), $item->registration_id, __('Delete this item', ''), __('Delete', ''));

        return sprintf('<a href="%1$s"><strong>%2$s</strong></a> %3$s', admin_url('admin.php?page=rentals&action=view&id=' . $item->registration_id), $item->Print_Key, $this->row_actions($actions));
    }

    /**
     * Get sortable columns
     *
     * @return array
     */
    function get_sortable_columns() {
        $sortable_columns = array(
            'name' => array('name', true),
        );

        return $sortable_columns;
    }

    /**
     * Set the bulk actions
     *
     * @return array
     */
    function get_bulk_actions() {
        $actions = array(
            'trash' => __('Move to Trash', ''),
        );
        return $actions;
    }

    /**
     * Render the checkbox column
     *
     * @param  object  $item
     *
     * @return string
     */
    function column_cb($item) {
        return sprintf(
                '<input type="checkbox" name="rental_id[]" value="%d" />', $item->registration_id
        );
    }

    /**
     * Set the views
     *
     * @return array
     */
    public function get_views_() {
        $status_links = array();
        $base_link = admin_url('admin.php?page=sample-page');

        foreach ($this->counts as $key => $value) {
            $class = ( $key == $this->page_status ) ? 'current' : 'status-' . $key;
            $status_links[$key] = sprintf('<a href="%s" class="%s">%s <span class="count">(%s)</span></a>', add_query_arg(array('status' => $key), $base_link), $class, $value['label'], $value['count']);
        }

        return $status_links;
    }

    /**
     * Prepare the class items
     *
     * @return void
     */
    function prepare_items() {

        $columns = $this->get_columns();
        $hidden = $this->get_hidden();
        $sortable = $this->get_sortable_columns();
        $this->_column_headers = array($columns, $hidden, $sortable);

        $per_page = 20;
        $current_page = $this->get_pagenum();
        $offset = ( $current_page - 1 ) * $per_page;
        $this->page_status = isset($_GET['status']) ? sanitize_text_field($_GET['status']) : '2';

        // only ncessary because we have sample data
        $args = array(
            'offset' => $offset,
            'number' => $per_page,
        );

        if (isset($_REQUEST['orderby']) && isset($_REQUEST['order'])) {
            $args['orderby'] = $_REQUEST['orderby'];
            $args['order'] = $_REQUEST['order'];
        }

        $this->items = rr_get_all_rental($args);

        $this->set_pagination_args(array(
            'total_items' => rr_get_rental_count(),
            'per_page' => $per_page
        ));
    }

}
