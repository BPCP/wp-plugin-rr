<?php

/**
 * Handle the form submissions
 *
 * @package Package
 * @subpackage Sub Package
 */
class Form_Handler {

    /**
     * Hook 'em all
     */
    public function __construct() {
        add_action('admin_init', array($this, 'handle_form'));
    }

    /**
     * Handle the rental new and edit form
     *
     * @return void
     */
    public function handle_form() {
        if (!isset($_POST['submit_rental'])) {
            return;
        }

        if (!wp_verify_nonce($_POST['_wpnonce'], 'rental-new')) {
            die(__('Are you cheating?', 'rr'));
        }

        if (!current_user_can('read')) {
            wp_die(__('Permission Denied!', 'rr'));
        }

        $errors = array();
        $page_url = admin_url('admin.php?page=rentals');
        $field_id = isset($_POST['field_id']) ? intval($_POST['field_id']) : 0;

        $Print_Key = isset($_POST['Print_Key']) ? sanitize_text_field($_POST['Print_Key']) : '';
        $Address = isset($_POST['Address']) ? sanitize_text_field($_POST['Address']) : '';
        $num_units = isset($_POST['num_units']) ? intval($_POST['num_units']) : 0;
        $occupied_units = isset($_POST['occupied_units']) ? intval($_POST['occupied_units']) : 0;

        // some basic validation
        if (!$Print_Key) {
            $errors[] = __('Error: Parcel Id is required', 'rr');
        }

        if (!$Address) {
            $errors[] = __('Error: Address is required', 'rr');
        }

        if (!$num_units) {
            $errors[] = __('Error: Number of Units is required', 'rr');
        }

        if (!$occupied_units) {
            $errors[] = __('Error: Number Occupied is required', 'rr');
        }

        // bail out if error found
        if ($errors) {
            $first_error = reset($errors);
            $redirect_to = add_query_arg(array('error' => $first_error), $page_url);
            wp_safe_redirect($redirect_to);
            exit;
        }

        $fields = array(
            'Print_Key' => $Print_Key,
            'Address' => $Address,
            'num_units' => $num_units,
            'occupied_units' => $occupied_units,
        );

        // New or edit?
        if (!$field_id) {

            $insert_id = rr_insert_rental($fields);
        } else {

            $fields['registration_id'] = $field_id;

            $insert_id = rr_insert_rental($fields);
        }

        if (is_wp_error($insert_id)) {
            $redirect_to = add_query_arg(array('message' => 'error'), $page_url);
        } else {
            $redirect_to = add_query_arg(array('message' => 'success'), $page_url);
        }

        wp_safe_redirect($redirect_to);
        exit;
    }

}

new Form_Handler();
