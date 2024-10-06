<?php


add_action('wp_ajax_handle_logout', 'handle_logout');

function handle_logout() {
    if (!isset($_POST['logout_nonce']) || !wp_verify_nonce($_POST['logout_nonce'], 'logout_nonce_action')) {
        wp_send_json_error('Nonce verification failed.');
    }

    wp_logout();

    wp_send_json_success();
}


