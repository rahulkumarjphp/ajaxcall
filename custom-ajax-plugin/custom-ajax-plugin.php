<?php
/**
 * Plugin Name: Custom Ajax Plugin
 * Description: Registers a shortcode to fetch and display data using AJAX using [custom_ajax_shortcode] shortcode.
 * Version: 1.0
 * Author: Rahul Kumar
 */

// Register the shortcode
function custom_ajax_shortcode() {
    ob_start();
    ?>
    <button id="custom-ajax-button">Fetch Data</button>
    <div id="custom-ajax-table"></div>
    <?php
    return ob_get_clean();
}
add_shortcode('custom_ajax_shortcode', 'custom_ajax_shortcode');

// Enqueue the JavaScript file
function custom_ajax_enqueue_scripts() {
    wp_enqueue_script('custom-ajax', plugin_dir_url(__FILE__) . 'js/custom-ajax.js', array('jquery'), '1.0', true);
    wp_localize_script('custom-ajax', 'custom_ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));
}
add_action('wp_enqueue_scripts', 'custom_ajax_enqueue_scripts');

// AJAX callback function
function custom_ajax_get_data() {
    $response = wp_remote_get('https://6466e9a7ba7110b663ab51f2.mockapi.io/api/v1/pack1');
    if (!is_wp_error($response) && wp_remote_retrieve_response_code($response) === 200) {
        $data = wp_remote_retrieve_body($response);
        wp_send_json_success($data);
    } else {
        wp_send_json_error('Failed to fetch data.');
    }
}
add_action('wp_ajax_custom_ajax_get_data', 'custom_ajax_get_data');
add_action('wp_ajax_nopriv_custom_ajax_get_data', 'custom_ajax_get_data');
