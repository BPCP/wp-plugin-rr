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

// Activation Callback
function rental_Registration_activation() {
    // Get access to global database access class
    global $wpdb;


    // Create table on main blog in network mode or single blog
    create_rental_table($wpdb->get_blog_prefix());
}

function create_rental_table($prefix) {
    // Prepare SQL query to create database table
    // using received table prefix
    $creation_query = 'CREATE TABLE IF NOT EXISTS ' . $prefix . 'rr_properties(
			`registration_id` int(20) NOT NULL AUTO_INCREMENT,
                        `parcel_id` INT NOT NULL ,
			`Print_Key` VARCHAR(30) ,
			`Address` VARCHAR (40),
                        `num_units` int,
                        `occupied_units` int,
                        `status` VARCHAR(10),
			PRIMARY KEY (`registration_id`) ,
                        INDEX `Address` (`Address`)
			);';

    global $wpdb;
    $wpdb->query($creation_query);
}

add_action('init', function() {
    include dirname(__FILE__) . '/includes/class-rental-admin-menu.php';
    include dirname(__FILE__) . '/includes/class-rental-list-table.php';
    include dirname(__FILE__) . '/includes/class-form-handler.php';
    include dirname(__FILE__) . '/includes/rental-functions.php';

    new Rental_admin_menu();
});
?>
