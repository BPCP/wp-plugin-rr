<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include dirname(__FILE__) . '/property_search_popup.php';
add_shortcode('list_registrations', 'display_my_registrations');

function display_my_registrations() {

    echo property_search_popup(); // creates the popup /includes/property_search_popup.php
    $myRentals = rr_get_my_rentals();
    foreach ($myRentals as $rental) {
        echo '<div class ="rr_', $rental["status"], ' rr_registration_list" >';
        echo '<span > <a href="edit-registration">', $rental["Address"], ' </a></span>';
        echo '<span > ', $rental["status"], ' </span>';
        echo '<span > Expires:', $rental["expiration_date"], ' </span>';
        echo "</div>";
    }
}

function rr_get_my_rentals() {
    global $wpdb;
    $me = wp_get_current_user()->user_login;
    return $wpdb->get_results('SELECT * FROM ' . $wpdb->prefix . 'rr_properties Where user = "' . $me . '" ORDER BY Address', ARRAY_A);
}
