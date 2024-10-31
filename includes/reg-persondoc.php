<?php


function wc_ninja_remove_password_strength()
{
    if (wp_script_is('wc-password-strength-meter', 'enqueued')) {
        wp_dequeue_script('wc-password-strength-meter');
    }
}

add_action('wp_print_scripts', 'wc_ninja_remove_password_strength', 100);

function wooc_persondoc_fileds()
{
    $handle = 'wc-country-select';
    wp_enqueue_script($handle, get_site_url() . '/wp-content/plugins/woocommerce/assets/js/frontend/country-select.min.js', array('jquery'), true);

    $field = [
        'type' => 'country',
        'label' => 'Country',
        'id' => 'regcountry',
        'required' => 0,
        'class' => ['address-field']
    ];
    woocommerce_form_field('billing_country', $field, '');

    $field = [
        'type' => 'state',
        'label' => 'State',
        'id' => 'regstate',
        'required' => 0,
        'class' => ['address-field'],
        'validate' => ['state']
    ];
    woocommerce_form_field('billing_state', $field, '');
    ?>


          <input type="hidden" class="input-text" name="billing_phone" id="reg_billing_phone"
                 value="<?php esc_attr_e($_POST['billing_phone']); ?>"/>

          <input type="hidden" class="input-text" name="billing_first_name" id="reg_billing_first_name"
                 value="<?php if (!empty($_POST['billing_first_name'])) {
                     esc_attr_e($_POST['billing_first_name']);
                 } ?>"/>
          <input type="hidden" class="input-text" name="billing_last_name" id="reg_billing_last_name"
                 value="<?php if (!empty($_POST['billing_last_name'])) {
                     esc_attr_e($_POST['billing_last_name']);
                 } ?>"/>
    <input type="hidden" class="input-text" name="billing_address_1" id="reg_billing_address_1"
           value="<?php if (!empty($_POST['billing_address_1'])) {
               esc_attr_e($_POST['billing_address_1']);
           } ?>"/>
    <input type="hidden" class="input-text" name="billing_address_2" id="reg_billing_address_2"
           value="<?php if (!empty($_POST['billing_address_2'])) {
               esc_attr_e($_POST['billing_address_2']);
           } ?>"/>

    <input type="hidden" class="input-text" name="billing_postcode" id="reg_billing_postcode"
           value="<?php if (!empty($_POST['billing_postcode'])) {
               esc_attr_e($_POST['billing_postcode']);
           } ?>"/>

    <input type="hidden" class="input-text" name="billing_city" id="reg_billing_city"
           value="<?php if (!empty($_POST['billing_city'])) {
               esc_attr_e($_POST['billing_city']);
           } ?>"/>


          <?php
}

add_action('woocommerce_register_form_start', 'wooc_persondoc_fileds');


add_action('woocommerce_login_form_start', 'persondoc_login_field');
function persondoc_login_field()
{
    $handle = 'wc-country-select';
    wp_enqueue_script($handle, get_site_url() . '/wp-content/plugins/woocommerce/assets/js/frontend/country-select.min.js', array('jquery'), true);

    $field = [
        'type' => 'country',
        'label' => 'Country',
        'required' => 0,
        'class' => ['address-field']
    ];
    woocommerce_form_field('billing_country', $field, '');

    $field = [
        'type' => 'state',
        'label' => 'State',
        'required' => 0,
        'class' => ['address-field'],
        'validate' => ['state']
    ];
    woocommerce_form_field('billing_state', $field, '');

    ?>
          <input type="hidden" class="input-text" name="billing_phone" id="billing_phone"
                 value="<?php esc_attr_e($_POST['billing_phone']); ?>"/>

              <input type="hidden" class="input-text" name="billing_first_name" id="billing_first_name"
                     value="<?php if (!empty($_POST['billing_first_name'])) {
                         esc_attr_e($_POST['billing_first_name']);
                     } ?>"/>

              <input type="hidden" class="input-text" name="billing_last_name" id="billing_last_name"
                     value="<?php if (!empty($_POST['billing_last_name'])) {
                         esc_attr_e($_POST['billing_last_name']);
                     } ?>"/>

    <input type="hidden" class="input-text" name="billing_address_1" id="billing_address_1"
           value="<?php if (!empty($_POST['billing_address_1'])) {
               esc_attr_e($_POST['billing_address_1']);
           } ?>"/>

    <input type="hidden" class="input-text" name="billing_address_2" id="billing_address_2"
           value="<?php if (!empty($_POST['billing_address_2'])) {
               esc_attr_e($_POST['billing_address_2']);
           } ?>"/>

    <input type="hidden" class="input-text" name="billing_postcode" id="billing_postcode"
           value="<?php if (!empty($_POST['billing_postcode'])) {
               esc_attr_e($_POST['billing_postcode']);
           } ?>"/>

    <input type="hidden" class="input-text" name="billing_city" id="billing_city"
           value="<?php if (!empty($_POST['billing_city'])) {
               esc_attr_e($_POST['billing_city']);
           } ?>"/>

          <?php
}

function persondoc_save_fileds($customer_id)
{

    if (isset($_POST['billing_first_name'])) {
        // WordPress default first name field.
        update_user_meta($customer_id, 'first_name', sanitize_text_field($_POST['billing_first_name']));

        // WooCommerce billing first name.
        update_user_meta($customer_id, 'billing_first_name', sanitize_text_field($_POST['billing_first_name']));
    }

    if (isset($_POST['billing_last_name'])) {
        // WordPress default last name field.
        update_user_meta($customer_id, 'last_name', sanitize_text_field($_POST['billing_last_name']));

        // WooCommerce billing last name.
        update_user_meta($customer_id, 'billing_last_name', sanitize_text_field($_POST['billing_last_name']));
    }

    if (isset($_POST['billing_phone'])) {
        // WooCommerce billing phone
        update_user_meta($customer_id, 'billing_phone', sanitize_text_field($_POST['billing_phone']));
    }

    if (isset($_POST['billing_address_1'])) {
        // WooCommerce billing address
        update_user_meta($customer_id, 'billing_address_1', sanitize_text_field($_POST['billing_address_1']));
    }

    if (isset($_POST['billing_address_2'])) {
        // WooCommerce billing address
        update_user_meta($customer_id, 'billing_address_2', sanitize_text_field($_POST['billing_address_2']));
    }

    if (isset($_POST['billing_postcode'])) {
        // WooCommerce billing postcode
        update_user_meta($customer_id, 'billing_postcode', sanitize_text_field($_POST['billing_postcode']));
    }

    if (isset($_POST['billing_city'])) {
        // WooCommerce billing city
        update_user_meta($customer_id, 'billing_city', sanitize_text_field($_POST['billing_city']));
    }
    if (isset($_POST['billing_country'])) {
        // WooCommerce billing city
        update_user_meta($customer_id, 'billing_country', sanitize_text_field($_POST['billing_country']));
    }
    if (isset($_POST['billing_state'])) {
        // WooCommerce billing city
        update_user_meta($customer_id, 'billing_state', sanitize_text_field($_POST['billing_state']));
    }

}

add_action('woocommerce_created_customer', 'persondoc_save_fileds');


function persondoc_log_field($customer_id)
{

    if (!function_exists('get_user_by')) {
        require_once ABSPATH . WPINC . '/pluggable.php';
    }
    $user = get_user_by('login', $customer_id);// here is the failure. If I directly put username instead of variable $u, I can echo the ID.

    if ($user) {
        $customer_id = $user->ID;
    }

    if (isset($_POST['billing_first_name'])) {
        // WordPress default first name field.
        update_user_meta($customer_id, 'first_name', sanitize_text_field($_POST['billing_first_name']));

        // WooCommerce billing first name.
        update_user_meta($customer_id, 'billing_first_name', sanitize_text_field($_POST['billing_first_name']));
    }

    if (isset($_POST['billing_last_name'])) {
        // WordPress default last name field.
        update_user_meta($customer_id, 'last_name', sanitize_text_field($_POST['billing_last_name']));

        // WooCommerce billing last name.
        update_user_meta($customer_id, 'billing_last_name', sanitize_text_field($_POST['billing_last_name']));
    }

    if (isset($_POST['billing_phone'])) {
        // WooCommerce billing phone
        update_user_meta($customer_id, 'billing_phone', sanitize_text_field($_POST['billing_phone']));
    }

    if (isset($_POST['billing_address_1'])) {
        // WooCommerce billing address
        update_user_meta($customer_id, 'billing_address_1', sanitize_text_field($_POST['billing_address_1']));
    }

    if (isset($_POST['billing_address_2'])) {
        // WooCommerce billing address
        update_user_meta($customer_id, 'billing_address_2', sanitize_text_field($_POST['billing_address_2']));
    }

    if (isset($_POST['billing_postcode'])) {
        // WooCommerce billing postcode
        update_user_meta($customer_id, 'billing_postcode', sanitize_text_field($_POST['billing_postcode']));
    }

    if (isset($_POST['billing_city'])) {
        // WooCommerce billing city
        update_user_meta($customer_id, 'billing_city', sanitize_text_field($_POST['billing_city']));
    }
    if (isset($_POST['billing_country'])) {
        // WooCommerce billing city
        update_user_meta($customer_id, 'billing_country', sanitize_text_field($_POST['billing_country']));
    }
    if (isset($_POST['billing_state'])) {
        // WooCommerce billing city
        update_user_meta($customer_id, 'billing_state', sanitize_text_field($_POST['billing_state']));
    }

}

add_action('wp_login', 'persondoc_log_field');