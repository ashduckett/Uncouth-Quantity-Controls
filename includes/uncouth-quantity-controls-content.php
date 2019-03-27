<?php

// This just starts a new div to get the price underneath the name by
// starting a div to encapsulate the two and then have a vertical flexbox div.

$uqc_options = get_option('uqc_settings_options');
$enabled = $uqc_options['enabled'] === '1';

$enabledStr = $enabled == true ? 'true' : 'false';

//  die($enabledStr);

function open_div($content, $cart_item_key) {
    //global $uqc_options;
    $uqc_options = get_option('uqc_settings_options');
    $enabled = $uqc_options['enabled'] === '1';
    if ($enabled) {
        return $content . '<div class="imageAndNameWithPrice">';
    } else {
        return $content;
    }
}
add_filter('woocommerce_cart_item_remove_link', 'open_div', 10, 2);

// Add the update cart button so user can see what's happening when the cart quantities are updated.
function update_cart_button() {
    //global $uqc_options;
    $uqc_options = get_option('uqc_settings_options');
    $enabled = $uqc_options['enabled'] === '1';
    if ($enabled) {
        echo '<a id="updateQuantitiesButton" href="#" class="button">Update Cart</a>';
    }
}
add_action('woocommerce_widget_shopping_cart_buttons', 'update_cart_button');

function contain_product_name($content, $cart_item, $cart_item_key) {
    //global $uqc_options;
    $uqc_options = get_option('uqc_settings_options');
    $enabled = $uqc_options['enabled'] === '1';
    if ($enabled) {
        $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
        $product_price = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
        return '<div class="nameAndPrice"><span class="productName">' . $content . '</span><span class="uncouthPrice">' . $product_price . '</span></div>';
    } else {
        return $content;
    }
} 
add_filter('woocommerce_cart_item_name', 'contain_product_name', 10, 3);

function remove_standard_quantity($content, $cart_item, $cart_item_key) {
        //global $uqc_options;
        $uqc_options = get_option('uqc_settings_options');
        $enabled = $uqc_options['enabled'] === '1';
        if ($enabled) {
            $output = '</div>';
            $output .= '<div style="float: left;" class="uncouthMiniCartQtyControls">';
            $output .= '<a class="uncouthQtyMinusButton" href="#"><i class="fas fa-minus"></i></a>';
            $output .= '<span data-cart_key=' . $cart_item_key . ' class="uncouthQty">' . WC()->cart->get_cart()[$cart_item_key]['quantity'] . '</span>';
            $output .= '<a class="uncouthQtyPlusButton" href="#"><i class="fas fa-plus"></i></a>';
            $output .= '</div>';
            return $output;
        } else {
            return $content;
        }
}
add_filter('woocommerce_widget_cart_item_quantity', 'remove_standard_quantity', 10, 3);