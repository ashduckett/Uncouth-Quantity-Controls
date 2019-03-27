<?php
/**
 * Plugin Name: Uncouth Quantity Controls
 * Description: Allows the addition of quantity controls to the minicart.
 * Version: 1.0
 * Author: Uncouth Studios 
 */

 // Exit if accessed directly
 if (!defined('ABSPATH')) {
    exit;
 }

 $uqc_options = get_option('uqc_settings');





require_once(plugin_dir_path(__FILE__) . '/includes/uncouth-quantity-controls-content.php');

if (is_admin()) {
    require_once(plugin_dir_path(__FILE__) . '/includes/uncouth-quantity-controls-settings.php');
}

 // Load scripts - this just loads in the css and the js
 require_once(plugin_dir_path(__FILE__) . '/includes/uncouth-quantity-controls-scripts.php');