<?php

/**
 * Get all rental
 *
 * @param $args array
 *
 * @return array
 */
function rr_get_all_rental($args = array()) {
    global $wpdb;

    $defaults = array(
        'number' => 20,
        'offset' => 0,
        'orderby' => 'Print_Key',
        'order' => 'ASC',
    );

    $args = wp_parse_args($args, $defaults);
    $cache_key = 'rental-all';
    $items = wp_cache_get($cache_key, '');

    if (false === $items) {
        $items = $wpdb->get_results('SELECT * FROM ' . $wpdb->prefix . 'rr_properties ORDER BY ' . $args['orderby'] . ' ' . $args['order'] . ' LIMIT ' . $args['offset'] . ', ' . $args['number']);

        wp_cache_set($cache_key, $items, '');
    }

    return $items;
}

/**
 * Fetch all rental from database
 *
 * @return array
 */
function rr_get_rental_count() {
    global $wpdb;

    return (int) $wpdb->get_var('SELECT COUNT(*) FROM ' . $wpdb->prefix . 'rr_properties');
}

/**
 * Fetch a single rental from database
 *
 * @param int   $registration_id
 *
 * @return array
 */
function rr_get_rental($registration_id) {
    global $wpdb;

    return $wpdb->get_row($wpdb->prepare('SELECT * FROM ' . $wpdb->prefix . 'rr_properties WHERE registration_id = %d', $registration_id));
}

function rr_insert_rental($args = array()) {
    global $wpdb;

    $defaults = array(
        'registration_id' => null,
        'Print_Key' => '',
        'Address' => '',
        'num_units' => '',
        'occupied_units' => '',
    );

    $args = wp_parse_args($args, $defaults);
    $table_name = $wpdb->prefix . 'rr_properties';

    // some basic validation
    if (empty($args['Print_Key'])) {
        return new WP_Error('no-Print_Key', __('No Parcel Id provided.', 'rr'));
    }
    if (empty($args['Address'])) {
        return new WP_Error('no-Address', __('No Address provided.', 'rr'));
    }
    if (empty($args['num_units'])) {
        return new WP_Error('no-num_units', __('No Number of Units provided.', 'rr'));
    }
    if (empty($args['occupied_units'])) {
        return new WP_Error('no-occupied_units', __('No Number Occupied provided.', 'rr'));
    }

    // remove row id to determine if new or update
    $row_id = (int) $args['registration_id'];
    unset($args['id']);

    if (!$row_id) {



        // insert a new
        if ($wpdb->insert($table_name, $args)) {
            return $wpdb->insert_id;
        }
    } else {

        // do update method here
        if ($wpdb->update($table_name, $args, array('id' => $row_id))) {
            return $row_id;
        }
    }

    return false;
}

function show_table() {
    $list_table = new Rentals_list_table();
    $list_table->prepare_items();
    return $list_table->display();
}

add_shortcode('rental', 'show_table');
