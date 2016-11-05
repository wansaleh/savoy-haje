<div class="followup-checkout">
    <p class="form-row form-row-wide">
        <input class="input-checkbox nm-custom-checkbox" type="checkbox" id="fue_subscribe" name="fue_subscribe" value="yes" <?php checked( 'checked', get_option('fue_checkout_subscription_default', 'unchecked') ); ?>>
        <label for="fue_subscribe" class="checkbox nm-custom-checkbox-label">
            <?php echo get_option( 'fue_checkout_subscription_field_label', 'Send me promos and product updates.' ); ?>
        </label>
    </p>
</div>
