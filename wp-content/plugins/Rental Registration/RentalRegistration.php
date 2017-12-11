<?php

/*
  Plugin Name: RentalRegistration
  Plugin URI:
  Description: Implements rental registration data tables
  Version: 1.0.0
  Author: brian phelps
  Author URI:
  License: GPLv2
 */

/*
  Copyright (C) 2017 brian phelps

  This program is free software; you can redistribute it and/or
  modify it under the terms of the GNU General Public License
  as published by the Free Software Foundation; either version 2
  of the License, or (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */
// Register function to be called when plugin is activated
register_activation_hook(__FILE__, 'rental_Registration_activation');
add_action('wp_enqueue_scripts', 'register_plugin_styles');


add_action('init', function() {
    include dirname(__FILE__) . '/includes/class-rental-admin-menu.php';
    include dirname(__FILE__) . '/includes/class-rental-list-table.php';
    include dirname(__FILE__) . '/includes/class-form-handler.php';
    include dirname(__FILE__) . '/includes/rental-functions.php';
    include dirname(__FILE__) . '/includes/my-registrations.php';
    include dirname(__FILE__) . '/includes/edit-registration.php';
    new Rental_admin_menu();
});

function register_plugin_styles() {
    wp_enqueue_style('rentalregistrations', plugins_url('includes/css/plugin.css', __FILE__));
    wp_enqueue_script('jquery');
    wp_enqueue_script('rentalregistrations', plugins_url('includes/js/rental_registration.js', __FILE__));
}

// Activation Callback
function rental_Registration_activation() {
    // Get access to global database access class
    global $wpdb;
    $db_prefix = $wpdb->get_blog_prefix();
    create_owners_table($db_prefix);
    create_parcel_ref_table($db_prefix);
    create_properties_table($db_prefix);
    create_owners_ref_table($db_prefix);
    create_page('Edit Registration');
    create_page('My Registrations');
}

function create_page($pagename) {
    global $wpdb;
    if (null === $wpdb->get_row("SELECT post_name FROM {$wpdb->prefix}posts WHERE post_name = '{$pagename}'", 'ARRAY_A')) {
        $current_user = wp_get_current_user();

        // create post object
        $page = array(
            'post_title' => __($pagename),
            'post_status' => 'publish',
            'post_author' => $current_user->ID,
            'post_type' => 'page',
            'post_content' => '[' . sanitize_title($pagename) . ']',
        );

        // insert the post into the database
        wp_insert_post($page);
    }
}

function create_properties_table($prefix) {
    // Prepare SQL query to create database table
    // using received table prefix
    $creation_query = 'CREATE TABLE IF NOT EXISTS ' . $prefix . 'rr_properties(
			`registration_id` int(20) NOT NULL AUTO_INCREMENT,
                        `user` VARCHAR (50) NOT NULL,
                        `parcel_id` INT NOT NULL ,
			`Print_Key` VARCHAR(30) ,
			`Address` VARCHAR (40),
                        `num_units` int,
                        `occupied_units` int,
                        `status` VARCHAR(10),
                        `expiration_date` datetime DEFAULT NULL,
			PRIMARY KEY (`registration_id`) ,
                        INDEX `Address` (`Address`),
                        INDEX `user` (`user`)
			);';

    global $wpdb;
    $wpdb->query($creation_query);
}

function create_parcel_ref_table($prefix) {
    // Prepare SQL query to create database table
    // using received table prefix
    $creation_query = 'CREATE TABLE IF NOT EXISTS ' . $prefix . 'rr_parcels_ref(
			`Parcel_Id` int(11) NOT NULL,
                        `Print_Key` char(30) NOT NULL,
                        `Property_Address` char(50) DEFAULT NULL,
                        `Prop_Class` varchar(3) DEFAULT NULL,
                        `sbl` char(50) NOT NULL,
                        `Address_Num` int(11) DEFAULT NULL,
			PRIMARY KEY (`Parcel_Id`) ,
                        INDEX `Property_Address` (`Property_Address`),
                        INDEX `Address_num` (`Address_num`)
			);';

    global $wpdb;
    $wpdb->query($creation_query);
}

function create_owners_ref_table($prefix) {
    // Prepare SQL query to create database table
    // using received table prefix
    $creation_query = 'CREATE TABLE IF NOT EXISTS ' . $prefix . 'rr_owners_ref(
                        `parcel_id` int(11) NOT NULL,
                        `Owner Name` varchar(100) NOT NULL,
                        `Address Line` varchar(100) NOT NULL,
                        `City` varchar(30) NOT NULL,
                        `State` varchar(2) NOT NULL,
                        `Zip` varchar(12) NOT NULL
			);';

    global $wpdb;
    $wpdb->query($creation_query);
}

function create_owners_table($prefix) {
    // Prepare SQL query to create database table
    // using received table prefix
    $creation_query = 'CREATE TABLE IF NOT EXISTS ' . $prefix . 'rr_owners(
                        `owner_idx` int(20) NOT NULL AUTO_INCREMENT,
                        `Owner Name` varchar(100) NOT NULL,
                        `Address Line` varchar(100) NOT NULL,
                        `City` varchar(30) NOT NULL,
                        `State` varchar(2) NOT NULL,
                        `Zip` varchar(12) NOT NULL,
                        `Registration_ID` int(11) NOT NULL,
                        `Signature` char(40) DEFAULT NULL,
                        `signature_timestamp` datetime DEFAULT NULL,
                        `is_applicant` bit(1) ,
                        `title` char(20) DEFAULT NULL,
                        PRIMARY KEY (`owner_idx`),
                        INDEX `Registration_ID` (`Registration_ID`)
			);';

    global $wpdb;
    $wpdb->query($creation_query);
}

function deploy_registration_pages() {
    $dir = plugin_dir_path(__FILE__) . 'includes/pages/';
    if (is_page('auto-created')) {
        echo 'something';
        include($dir . "test.php");
        //die();
    }
}
