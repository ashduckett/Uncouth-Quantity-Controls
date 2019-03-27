<?php


function uqc_add_scripts() {
    $uqc_options = get_option('uqc_settings_options');
    // Load in any CSS
    wp_enqueue_style('uqc-main-style', plugins_url() . '/uncouth-quantity-controls/css/style.css');
    
    // Load in the main JS file - not currently used    
    wp_enqueue_script('uqc-main-script', plugins_url() . '/uncouth-quantity-controls/js/main.js', array('jquery'), '1.0.0', true);


    
    $showSubtotal = $uqc_options['show_subtotal'] === '1';
    wp_register_script( 'updateQuantities.js', plugins_url() . '/uncouth-quantity-controls/js/updateQuantities.js');
    wp_localize_script('updateQuantities.js', 'myAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ), 'showSubtotal' => $showSubtotal));
    wp_enqueue_script('updateQuantities.js', plugins_url() . '/uncouth-quantity-controls/js/updateQuantities.js', array('jquery'), '1.0.0', true);
}

add_action('wp_enqueue_scripts', 'uqc_add_scripts');




// function updateQuantities() {
//     $result = 'Here is the response of updateQuantities';
//     echo json_encode($result);
    
//     exit();
// }
// add_action('wp_ajax_updateQuantities', 'updateQuantities', 1);