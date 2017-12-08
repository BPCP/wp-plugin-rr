<?php

function property_search_popup() {
    add_thickbox(); //wordpress function
    $popup_button = '<div style="text-align: center; padding: 20px 0;">'
            . '<input class="thickbox" title="Register Rental Property" '
            . 'alt="#TB_inline?height=300&amp;width=400&amp;inlineId=examplePopup1" '
            . 'type="button" value="+ Add a Rental Property" /></div>';

    $popup = '<div id="examplePopup1" style="display:none"><h2>Select Property to Register</h2>'
            . '<form action="edit-registration/"><select name="new_address">' . rr_get_all_addresses() . '</select> '
            . '<input type="submit"></form></div>';
    return $popup_button . $popup;
}
