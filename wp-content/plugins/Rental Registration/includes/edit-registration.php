<?php
//wp_enqueue_style('Rental_Registrations');
add_shortcode('edit-registration', 'edit_my_registration');
add_action('wp_head', 'declare_ajaxurl');
add_action('wp_ajax_update_field', 'update_field');

function update_field() {
    $post = $_POST;
    if (gettype($post['nval']) == 'string') {
        $post['nval'] = mysql_real_escape_string($post['nval']);
    }
    check_ajax_referer('rental_ajax');
    global $wpdb; // this is how you get access to the database
    $query = "UPDATE " . $wpdb->prefix . $post['table'] . " SET " . $post['field'] . " = " . $post['nVal'] . " WHERE idx = " . $post['idx'];
    $wpdb->query($query);
    echo $query;
    $output = '';
    wp_die();
}

function declare_ajaxurl() {
    ?>
    <script type="text/javascript">
        var ajax_url = '<?php echo admin_url('admin-ajax.php');
    ?>';
    </script>
    <?php
}

function edit_my_registration() {
    $reg = get_registration($_GET['rid']);
    if (count($reg) == 0) {
        echo 'This registration is not yours!!';
    } else {
        $tabs = '<div class="tab">'
                . create_tab('Rental', 1)
                . create_tab('Owners')
                . create_tab('Units')
                . '</div>';

        echo $tabs;
        echo rental_tab($reg[0]);
        echo owner_tab($reg[0]);
        echo unit_tab($reg[0]);
//echo tab_jscript();
    }
}

function create_tab($tab, $default = 0) {
    $s = '<button class="tablinks rr_tablinks" onclick="openTab(event, \'' . $tab . '\')"';
    if (($tab == $_GET['tab'])
            or ( (is_null($_GET['tab'])) and ( $default == 1))) {
        $s .= 'id="defaultOpen"';
    }
    $s .='>' . $tab . '</button>';

    return $s;
}

function unit_tab($d) {
    $table = 'rr_units';
    $datum = get_units($d["idx"]);
    $t = '<div id="Units" class="tabcontent">';
    foreach ($datum as $data) {
        $idx = $data["idx"];
        $t .= create_input($data, 'street_address', 'Street Address', $table, $idx)
                . create_input($data, 'unit_type', 'Unit Type', $table, $idx, 'text', '', 'Apartment,Suite,Building etc.')
                . create_input($data, 'unit_designation', 'Unit Designation', $table, $idx, 'text', '', 'A, B, 1, 2, 101, 102 etc.')
                . '<input type="checkbox" name="is_occupied" class="rr_input rr_input_is_occupied" '
                . 'data-table="rr_units" data-idx="' . $idx . '"  value="1"'
                . 'onchange="updateField(this,`' . get_nonce() . '`)"';
        if ($data["is_occupied"]) {
            $t .='checked';
        }
        $t .= ' > Currently Occupied<span></span>';
    }
    $t .= '</div>';
    return $t;
}

function get_nonce() {
    return wp_create_nonce('rental_ajax');
}

function owner_tab($d) {

    $datum = get_owners($d["idx"]);

    $t = '<div id="Owners" class="tabcontent">';
    $table = 'rr_owners';
    foreach ($datum as $data) {
        $idx = $data["idx"];
//        $t .='<div class="owner">';
        $t .='<form id ="addressform' . $data["idx"] . '" action="" method="post">'
                . create_input($data, 'Owner Name', 'Owner', $table, $idx, '', 'Enter Owner Name')
                . create_input($data, 'Address Line', 'Address', $table, $idx, '', 'Enter Owner Address')
                . create_input($data, 'City', 'City', $table, $idx, '')
                . create_input($data, 'State', 'State', $table, $idx)
                . create_input($data, 'Zip', 'Zip Code', $table, $idx)
                . '<label for="type" class= "rr_input_label">Owner Type</label>'
                . '<input type="radio" name="type" class="rr_input rr_input_type" value="Individual" class="" ';
        if ($data["type"] == 'Individual') {
            $t .= 'checked';
        }
        $t .='>Individual'
                . '<input type="radio" name="type" class="rr_input rr_input_type" value="Organization" class="" ';
        if ($data["type"] == 'Organization') {
            $t .= 'checked';
        }
        $t .='>Organization <span></span>'
                . create_input($data, 'e_mail_address', 'E-Mail', $table, $idx, 'email')
                . create_input($data, 'phone_number', 'Phone Number', $table, $idx, 'tel')
                . '</form>';
    }
    $t .= '</div>';
    return $t;
}

function create_input($record, $datafield, $label, $table, $idx, $type = 'text', $misc = '', $placeholder = '') {
    $nonce = get_nonce();
    if ($type == '') {
        $type = 'text';
    }
    $s = '<div class="rr_input_group ' . $datafield . '">';
    $s .= '<label for="' . $datafield . '" class= "rr_input_label">' . $label . '</label>'
            . '<input type="' . $type . ''
            . '" name="' . $datafield . '" class="rr_input rr_input_' . $datafield . '" '
            . 'data-table="' . $table . '" data-idx="' . $idx . '"'
            . ' onchange="updateField(this,\'' . $nonce . '\')"'
            . 'value="' . $record[$datafield] . '" placeholder="' . $placeholder . '" ' . $misc . '>'
            . '</div>';
    return $s;
}

function rental_tab($data) {
    $table = 'rr_properties';
    $idx = $data["idx"];
    $t = '<div id="Rental" class="tabcontent">'
            . '<form id ="addressform' . $data["idx"] . '" action="" method="post">'
            . create_input($data, 'Print_Key', 'Parcel Id', $table, $idx, '', 'readonly')
            . create_input($data, 'Address', 'Address', $table, $idx, 'text', 'readonly')
            . create_input($data, 'num_units', 'Total Number of Rental Units', $table, $idx, 'number', 'min="1" max="500"')
            . '</form>'
            . '</div>';
    return $t;
}

function get_registration($idx) {
    global $wpdb;
    $me = wp_get_current_user()->user_login;
    $query = 'SELECT * FROM ' . $wpdb->prefix . 'rr_properties '
            . 'Where user = "' . $me . '" '
            . 'and idx ="' . $idx . '" ';
    $registration = $wpdb->get_results($query, ARRAY_A);
    return $registration;
}

function get_owners($ridx) {
    global $wpdb;
    $query = 'SELECT * FROM ' . $wpdb->prefix . 'rr_owners '
            . 'Where Registration_ID ="' . $ridx . '" ';
    $owners = $wpdb->get_results($query, ARRAY_A);
    return $owners;
}

function get_units($ridx) {
    global $wpdb;
    $query = 'SELECT * FROM ' . $wpdb->prefix . 'rr_units '
            . 'Where Registration_ID ="' . $ridx . '" ';
    $units = $wpdb->get_results($query, ARRAY_A);
    return $units;
}
