<?php

if (! defined('ABSPATH')) {
    exit;
}

// Hook to add form to product page
add_action('woocommerce_before_add_to_cart_button', 'display_customizer_form');

// Hook to handle form data when adding to cart
add_filter('woocommerce_add_cart_item_data', 'add_form_data_to_cart', 10, 3);

// Hook to display form data in cart
add_filter('woocommerce_get_item_data', 'display_form_data_in_cart', 10, 2);

// Hook to save form data to order
add_action('woocommerce_checkout_create_order_line_item', 'save_form_data_to_order', 10, 4);

// Hook to calculate price
add_filter('woocommerce_before_calculate_totals', 'calculate_custom_price');

function is_shutter_product()
{
    if (!is_product()) {
        return false;
    }

    global $product;
    if (!$product) {
        return false;
    }

    // Replace 'shutters' with your actual category slug
    return has_term('shutters', 'product_cat', $product->get_id());
}

function display_customizer_form()
{
    // Only show form on shutter products
    if (!is_shutter_product()) {
        return;
    }

    // Load form template
    include plugin_dir_path(__FILE__) . '../templates/form.php';
}

function calculate_custom_price($cart)
{
    if (is_admin() && !defined('DOING_AJAX')) {
        return;
    }

    foreach ($cart->get_cart() as $cart_item) {
        if (isset($cart_item['shutter_customization'])) {
            $product = $cart_item['data'];
            $customization = $cart_item['shutter_customization'];

            // Get dimensions
            $width = floatval($customization['width']);
            $height = floatval($customization['height']);

            // Calculate area in square meters
            $area = ($width * $height) / 1000000; // Convert mm² to m²

            // Get price per square meter from product
            $price_per_sqm = $product->is_on_sale() ?
                floatval($product->get_sale_price()) :
                floatval($product->get_regular_price());

            // Get frame type
            $frame_type = $customization['frame_type'];
            $frame_price = $frame_type === 'premium' ? 50 : 0;

            // Calculate new price
            $new_price = $area * $price_per_sqm + $frame_price;

            // Set the new price
            $cart_item['data']->set_price($new_price);
        }
    }
}

function add_form_data_to_cart($cart_item_data, $product_id, $variation_id)
{
    if (isset($_POST['shutter_width']) && isset($_POST['shutter_height'])) {
        $cart_item_data['shutter_customization'] = array(
            'width' => sanitize_text_field($_POST['shutter_width']),
            'height' => sanitize_text_field($_POST['shutter_height']),
            'frame_type' => sanitize_text_field($_POST['frame_type']),
            'window_name' => sanitize_text_field($_POST['window_name']),
            'shutter_color' => sanitize_text_field($_POST['shutter_color']),
        );

        // Ensure unique cart item
        $cart_item_data['unique_key'] = md5(microtime() . rand());
    }
    return $cart_item_data;
}

function display_form_data_in_cart($item_data, $cart_item)
{
    if (isset($cart_item['shutter_customization'])) {
        $customization = $cart_item['shutter_customization'];

        $item_data[] = array(
            'key' => 'Window Name',
            'value' => ucfirst($customization['window_name']), // Display Window Name
        );

        $item_data[] = array(
            'key' => 'Width',
            'value' => $customization['width'] . ' mm'
        );

        $item_data[] = array(
            'key' => 'Height',
            'value' => $customization['height'] . ' mm'
        );

        $item_data[] = array(
            'key' => 'Frame Type',
            'value' => ucfirst($customization['frame_type'])
        );

        $item_data[] = array(
            'key' => 'Color',
            'value' => ucfirst($customization['shutter_color'])
        );

        // Add area information
        $area = (floatval($customization['width']) * floatval($customization['height'])) / 1000000;


        $item_data[] = array(
            'key' => 'Area',
            'value' => number_format($area, 2) . ' m²'
        );
    }
    return $item_data;
}

function save_form_data_to_order($item, $cart_item_key, $values, $order)
{
    if (isset($values['shutter_customization'])) {
        foreach ($values['shutter_customization'] as $key => $value) {
            $item->add_meta_data('Shutter ' . ucfirst($key), $value);
        }

        $width = floatval($values['shutter_customization']['width']);
        $height = floatval($values['shutter_customization']['height']);
        $area = ($width * $height) / 1000000;
        $item->add_meta_data('Shutter Area', number_format($area, 2) . ' m²');
    }
}
