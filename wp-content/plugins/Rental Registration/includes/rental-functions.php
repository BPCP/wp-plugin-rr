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

function add_new_registration($add) {
    echo 'New registration added';
    global $wpdb;
    $me = wp_get_current_user()->user_login;
    $new_add_parcel = $wpdb->get_row('SELECT * FROM ' . $wpdb->prefix . 'rr_parcels_ref Where Property_Address="' . $add . '"', ARRAY_A);
    $wpdb->insert(
            $wpdb->prefix . 'rr_properties', array(
        'parcel_id' => $new_add_parcel['Parcel_Id'],
        'Print_Key' => $new_add_parcel['Print_Key'],
        'user' => $me,
        'Address' => $new_add_parcel['Property_Address'],
        'status' => 'Incomplete',
            )
    );
    $new_reg_id = $wpdb->get_var('select LAST_INSERT_ID()');
    $new_owners = $wpdb->get_results('SELECT * FROM ' . $wpdb->prefix . 'rr_owners_ref Where Parcel_Id="' . $new_add_parcel['Parcel_Id'] . '"', ARRAY_A);
    foreach ($new_owners as $new_owner) {
        $wpdb->insert(
                $wpdb->prefix . 'rr_owners', array(
            'Owner Name' => $new_owner['Owner Name'],
            'Address Line' => $new_owner['Address Line'],
            'City' => $new_owner['City'],
            'State' => $new_owner['State'],
            'Zip' => $new_owner['Zip'],
            'Registration_ID' => $new_reg_id,
                )
        );
    };
}

function display_property() {
    if ($_GET['new_address'] > '') {
        add_new_registration($_GET['new_address']);
    }
    $property_fields = [
        // ["name" => "Address", "class" => "rr_address"],
        ["name" => "Print_Key", "class" => "rr_printkey", "label" => "Parcel Id"],
        ["name" => "num_units", "class" => "rr_num_Unitsp", "label" => "# Units"],
        ["name" => "occupied_units", "class" => "rr_occupied_units", "label" => " # Occupied"],
        ["name" => "status", "class" => "rr_status"]
    ];
    $owner_fields = [
        // ["name" => "Address", "class" => "rr_address"],
        ["name" => "Owner Name", "class" => "rr_owner_name", "label" => "Name"],
        ["name" => "Address Line", "class" => "rr_address", "label" => "Address"],
        ["name" => "City", "class" => "rr_add_City", "label" => "City"],
        ["name" => "title", "class" => "rr_status"]
    ];
    add_thickbox();
    echo property_search_popup();
    $myRentals = rr_get_myrentals();
    foreach ($myRentals as $rental) {

        echo '<div><table class ="rr_', $rental["status"], ' rr_property_table" >';
        echo '<tr> <th>', $rental["Address"], ' </th></tr>';
        echo '<tr><td> Parcel ID </td><td> Units </td><td> Occupied </td><td> Status </td></tr>';
        echo "<tr>";
        foreach ($property_fields as $field) {
            td($rental[$field["name"]], $field["class"]);
        }
        echo "</tr>";
        echo "</table></div>";
        $rental_owners = rr_get_rental_owners($rental["registration_id"]);
        echo '<div><table class ="rr_owner_table" >';
        echo '<tr> <th> Property Owners </th></tr>';
        echo '<tr><td> Name </td><td> Address </td><td> City State Zip </td><td> Status </td></tr>';
        foreach ($rental_owners as $owner) {
            echo "<tr>";
            foreach ($owner_fields as $field) {
                td($owner[$field["name"]], $field["class"]);
            }
            echo "</tr>";
        }
        echo "</table></div>";
    }
}

add_shortcode('rental', 'display_property');

function rr_get_rental_owners($reg_id) {
    global $wpdb;
    return $wpdb->get_results('SELECT * FROM ' . $wpdb->prefix . 'rr_owners Where Registration_ID = "' . $reg_id . '" ', ARRAY_A);
}

function rr_get_myrentals() {
    global $wpdb;
    $me = wp_get_current_user()->user_login;
    return $wpdb->get_results('SELECT * FROM ' . $wpdb->prefix . 'rr_properties Where user = "' . $me . '" ORDER BY Address', ARRAY_A);
}

function td($param, $class) {
    echo "<td class =" . $class . ">";
    echo $param;
    echo "</td>";
}

function rr_get_all_addresses() {
    global $wpdb;

    $addesses = $wpdb->get_results('SELECT Property_Address FROM ' . $wpdb->prefix . 'rr_parcels_ref ORDER BY Address_Num, Property_Address', ARRAY_A);
    $t = '';
    foreach ($addesses as $address) {
        $t .= '<option>' . $address["Property_Address"] . '</option>';
    }
    return $t;
}
