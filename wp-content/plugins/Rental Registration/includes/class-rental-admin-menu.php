<?php

/**
 * Admin Menu
 */
class Rental_admin_menu {

    /**
     * Kick-in the class
     */
    public function __construct() {
        add_action('admin_menu', array($this, 'admin_menu'));
    }

    /**
     * Add menu items
     *
     * @return void
     */
    public function admin_menu() {

        /** Top Menu * */
        add_menu_page(__('Rental Properties', 'rr'), __('Rental Properties', 'rr'), 'manage_options', 'rentals', array($this, 'plugin_page'), 'dashicons-groups', null);

        add_submenu_page('rentals', __('Rental Properties', 'rr'), __('Rental Properties', 'rr'), 'manage_options', 'rentals', array($this, 'plugin_page'));
    }

    /**
     * Handles the plugin page
     *
     * @return void
     */
    public function plugin_page() {
        $action = isset($_GET['action']) ? $_GET['action'] : 'list';
        $registration_id = isset($_GET['registration_id']) ? intval($_GET['registration_id']) : 0;

        switch ($action) {
            case 'view':

                $template = dirname(__FILE__) . '/views/rental-single.php';
                break;

            case 'edit':
                $template = dirname(__FILE__) . '/views/rental-edit.php';
                break;

            case 'new':
                $template = dirname(__FILE__) . '/views/rental-new.php';
                break;

            default:
                $template = dirname(__FILE__) . '/views/rental-list.php';
                break;
        }

        if (file_exists($template)) {
            include $template;
        }
    }

}
