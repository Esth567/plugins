<?php

function add_user_info_to_menu($items, $args) {
    global $wpdb;

    // Check if the current menu is the 'main_menu'
    if ($args->theme_location === 'menu_items') {
        if (is_user_logged_in()) {
            $current_user = wp_get_current_user();
            if (in_array('subscriber', $current_user->roles)) {
                // Fetch the face capture image URL from the user_kyc table
                $face_capture_url = $wpdb->get_var($wpdb->prepare(
                    "SELECT face_capture_url FROM {$wpdb->prefix}user_kyc WHERE user_id = %d",
                    $current_user->ID
                ));

                // If the face capture URL exists, use it as the profile picture
                if ($face_capture_url) {
                    $profile_picture = $face_capture_url;
                } else {
                    $profile_picture = plugin_dir_url(__FILE__) . 'assets/images/avatar.png'; 
                }

                $profile_page_url = home_url('/profile'); 

                $user_info_html = '
                <div class="user-info">
                    <span onclick="window.location.href=\''.esc_url($profile_page_url).'\'" style="cursor: pointer; margin-right: 10px;">
                        '.esc_html($current_user->first_name . ' ' . $current_user->last_name).'
                    </span>
                    <img src="'.esc_url($profile_picture).'" class="profile-picture" style="border-radius: 50%; width: 30px; height: 30px;">
                </div>';

                // Append the user info HTML to the menu items
                $items .= $user_info_html;
            }
        }
    }

    return $items;
}

add_filter('wp_nav_menu_items', 'add_user_info_to_menu');





