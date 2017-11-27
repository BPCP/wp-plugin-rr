<div class="wrap">
    <h1><?php _e('Add Property', 'rr'); ?></h1>

    <form action="" method="post">

        <table class="form-table">
            <tbody>
                <tr class="row-Print-Key">
                    <th scope="row">
                        <label for="Print_Key"><?php _e('Parcel Id', 'rr'); ?></label>
                    </th>
                    <td>
                        <input type="text" name="Print_Key" id="Print_Key" class="regular-text" placeholder="<?php echo esc_attr('', 'rr'); ?>" value="" required="required" />
                    </td>
                </tr>
                <tr class="row-Address">
                    <th scope="row">
                        <label for="Address"><?php _e('Address', 'rr'); ?></label>
                    </th>
                    <td>
                        <input type="text" name="Address" id="Address" class="regular-text" placeholder="<?php echo esc_attr('', 'rr'); ?>" value="" required="required" />
                    </td>
                </tr>
                <tr class="row-num-units">
                    <th scope="row">
                        <label for="num_units"><?php _e('Number of Units', 'rr'); ?></label>
                    </th>
                    <td>
                        <input type="number" name="num_units" id="num_units" class="regular-text" placeholder="<?php echo esc_attr('', 'rr'); ?>" value="" required="required" />
                    </td>
                </tr>
                <tr class="row-occupied-units">
                    <th scope="row">
                        <label for="occupied_units"><?php _e('Number Occupied', 'rr'); ?></label>
                    </th>
                    <td>
                        <input type="number" name="occupied_units" id="occupied_units" class="regular-text" placeholder="<?php echo esc_attr('', 'rr'); ?>" value="" required="required" />
                    </td>
                </tr>
            </tbody>
        </table>

        <input type="hidden" name="field_id" value="0">

        <?php wp_nonce_field('rental-new'); ?>
        <?php submit_button(__('Add Rental', 'rr'), 'primary', 'submit_rental'); ?>

    </form>
</div>
