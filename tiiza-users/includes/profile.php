<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}


function user_profile_tracker_profile_page() {
    if (!is_user_logged_in()) {
        wp_redirect(home_url('/login')); // Redirect to login page if not logged in
        exit;
    }

    global $wpdb;

    $profile_details_table = $wpdb->prefix . 'profile_details';
    $activated_details_table = $wpdb->prefix . 'activated_details';
    $found_report_table = $wpdb->prefix . 'found_report';
    $lost_report_table = $wpdb->prefix . 'lost_report';
    $device_registered_table = $wpdb->prefix . 'device_registered';
    $table_name = $wpdb->prefix . 'user_registered';
    $kyc_table = $wpdb->prefix . 'user_kyc';

    $user_id = get_current_user_id();
    $user_info = get_userdata($user_id);

    $kyc_data = $wpdb->get_row($wpdb->prepare("SELECT * FROM $kyc_table WHERE user_id = %d", $user_id));

    // Fetch the face capture image URL from the user_kyc table
    $face_capture = esc_url($wpdb->get_var($wpdb->prepare(
        "SELECT face_capture_url FROM $kyc_table WHERE user_id = %d",
        $user_id
    )));

    // Fetch the count of activated items
    $activated_details = $wpdb->get_row($wpdb->prepare(
        "SELECT COUNT(*) as activated_count FROM $activated_details_table WHERE user_id = %d",
        $user_id
    ));

    // Fetch the count of found items
    $found_report = $wpdb->get_row($wpdb->prepare(
        "SELECT COUNT(*) as item_found FROM $found_report_table WHERE user_id = %d",
        $user_id
    ));

    // Fetch the count of lost devices
    $lost_report = $wpdb->get_row($wpdb->prepare(
        "SELECT COUNT(*) as lost_item FROM $lost_report_table WHERE user_id = %d",
        $user_id
    ));

    // Fetch the count of registered devices
    $device_registered = $wpdb->get_row($wpdb->prepare(
        "SELECT COUNT(*) as device_count FROM $device_registered_table WHERE user_id = %d",
        $user_id
    ));

    $kyc_page_id = get_page_by_path('kyc')->ID;

    // Fetch the saved profile picture URL from user meta
    $profile_picture_url = get_user_meta($user_id, 'profile_picture', true);

    // default image
   if (!$profile_picture_url) {
       $profile_picture_url = 'https://qph.cf2.quoracdn.net/main-qimg-f32f85d21d59a5540948c3bfbce52e68'; 
    }
   
    $phone = get_user_meta($user_info->ID, 'user_phone', true);


    $activated_details_nonce = wp_create_nonce('activated_details_action_nonce');
    $found_report_nonce = wp_create_nonce('found_report_action_nonce');
    $lost_report_nonce = wp_create_nonce('lost_report_action_nonce');
    $device_registration_nonce = wp_create_nonce('device_registration_action_nonce');

    ob_start();
    ?>
    <div>
       <div class="profile-header">
       <div class="profile-info" style="background-image: url('<?php echo esc_url($profile_picture_url); ?>');">
       <h1 class="upload-icon">
        <i class="fa fa-plus fa-2x" aria-hidden="true"></i>
      </h1>    
      <input
        class="file-uploader"
        type="file"
        accept="image/*"
      />
      <input type="hidden" id="profile_nonce" value="<?php echo wp_create_nonce('profile_picture_upload_nonce'); ?>" />
    </div class="name-field">
    <h2><?php echo esc_html($user_info->display_name); ?></h2>
</div>
</div>

       <div>
        <div class="profile-data">
            <p class="profile-detail">
                <span class="label"><i class="fas fa-user-circle"></i><?php esc_html_e('Username:', 'tiiza-users'); ?></span>
                <span class="value"><?php echo esc_html($user_info->user_login); ?></span>
            </p>
            <p class="profile-detail">
                <span class="label"><i class="fas fa-envelope"></i><?php esc_html_e('Email:', 'tiiza-users'); ?></span>
                <span class="value"><?php echo esc_html($user_info->user_email); ?></span>
            </p>
            <p class="profile-detail">
                <span class="label"><i class="fas fa-phone"></i><?php esc_html_e('Phone Number:', 'tiiza-users'); ?></span>
                <span class="value"><?php echo esc_html($phone); ?></span>
            </p>

            <?php if ($kyc_data): ?>
                <p class="profile-detail">
                    <span class="label"><i class="fas fa-venus-mars"></i><?php esc_html_e('Gender:', 'tiiza-users'); ?></span>
                    <span class="value"><?php echo esc_html($kyc_data->gender); ?></span>
                </p>
                <p class="profile-detail">
                    <span class="label"><i class="fas fa-map-marker-alt"></i><?php esc_html_e('Address:', 'tiiza-users'); ?></span>
                    <span class="value"><?php echo esc_html($kyc_data->address); ?></span>
                </p>
                <p class="profile-detail">
                    <span class="label"><i class="fas fa-globe"></i><?php esc_html_e('Country:', 'tiiza-users'); ?></span>
                    <span class="value"><?php echo esc_html($kyc_data->country); ?></span>
                </p>
            <?php else: ?>
                <p style="color: red; font-size: 13px; margin-bottom: 3px;">
                    <?php esc_html_e('You have not submitted KYC details yet.', 'tiiza-users'); ?>
                </p>
                <a href="<?php echo esc_url(get_permalink($kyc_page_id)); ?>" style="color: blue; text-decoration: underline; margin-bottom: 10px;"><?php esc_html_e('Complete your KYC here.', 'tiiza-users'); ?></a>
            <?php endif; ?>
            <div class="profile-detail">
                <span class="label"><i class="fas fa-sign-out-alt"></i></span>
                <a href="<?php echo wp_logout_url(home_url('/')); ?>" id="logout_button" style=" margin-right: 35px; font-weight: 500;">Logout</a>
            </div>
        </div>
    </div>
    

    <div>
    <div class="activities-view">
        <div class="activities">
            <button id="activated_details_count" class="clickable"><?php esc_html_e('Items Activated:', 'tiiza-users'); ?> <?php echo esc_html($activated_details->activated_count); ?></button>
            <input type="hidden" name="activated_details_nonce" value="<?php echo esc_attr($activated_details_nonce); ?>">

            <button id="found_report_count" class="clickable"><?php esc_html_e('Items Found:', 'tiiza-users'); ?> <?php echo esc_html($found_report->item_found); ?></button>
            <input type="hidden" name="found_report_nonce" value="<?php echo esc_attr($found_report_nonce); ?>">

            <button id="lost_report_count" class="clickable"><?php esc_html_e('Lost Items:', 'tiiza-users'); ?> <?php echo esc_html($lost_report->lost_item); ?></button>
            <input type="hidden" name="lost_report_nonce" value="<?php echo esc_attr($lost_report_nonce); ?>">

            <button id="device_registration_count" class="clickable"><?php esc_html_e('Devices Registered:', 'tiiza-users'); ?> <?php echo esc_html($device_registered->device_count); ?></button>
            <input type="hidden" name="device_registration_nonce" value="<?php echo esc_attr($device_registration_nonce); ?>">

            <div id="activated_details_details_display" class="details-display"></div>
            <div id="found_report_details_display" class="details-display"></div>
            <div id="lost_report_details_display" class="details-display"></div>
            <div id="device_registration_details_display" class="details-display"></div>
        </div>
    </div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('user_profile456', 'user_profile_tracker_profile_page');


function get_activated_details_details() {
    if (!is_user_logged_in()) {
        wp_send_json_error(['message' => 'You need to be logged in to view this data.']);
        return;
    }

      // Verify nonce
      if (!isset($_POST['activated_details_nonce']) || !wp_verify_nonce($_POST['activated_details_nonce'], 'activated_details_action_nonce')) {
        wp_send_json_error(['message' => 'failed.']);
        return;
    } 

    $user_id = get_current_user_id();
    global $wpdb;
    $activated_details_table = $wpdb->prefix . 'activated_details';

    $details = $wpdb->get_results($wpdb->prepare(
        "SELECT tracker_id, item_name, color, image_url FROM $activated_details_table WHERE user_id = %d",
        $user_id
    ));

    if ($wpdb->last_error) {
        wp_send_json_error(['message' => 'Database error: ' . $wpdb->last_error]);
        return;
    }

    if (empty($details)) {
        wp_send_json_error(['message' => 'No data found.']);
    } else {
        wp_send_json_success(['details' => $details]);
    }
}
add_action('wp_ajax_get_activated_details_details', 'get_activated_details_details');

function get_found_report_details() {
    if (!is_user_logged_in()) {
        wp_send_json_error(['message' => 'You need to be logged in to view this data.']);
        return;
    }
   
      // Verify nonce
      if (!isset($_POST['found_report_nonce']) || !wp_verify_nonce($_POST['found_report_nonce'], 'found_report_action_nonce')) {
        wp_send_json_error(['message' => 'failed.']);
        return;
    } 

    $user_id = get_current_user_id();
    global $wpdb;
    $found_report_table = $wpdb->prefix . 'found_report';

    $details = $wpdb->get_results($wpdb->prepare(
        "SELECT tracker_id, image_url FROM $found_report_table WHERE user_id = %d",
        $user_id
    ));

    if ($wpdb->last_error) {
        wp_send_json_error(['message' => 'Database error: ' . $wpdb->last_error]);
        return;
    }

    if (empty($details)) {
        wp_send_json_error(['message' => 'No data found.']);
    } else {
        wp_send_json_success(['details' => $details]);
    }
}
add_action('wp_ajax_get_found_report_details', 'get_found_report_details');

function get_lost_report_details() {
    if (!is_user_logged_in()) {
        wp_send_json_error(['message' => 'You need to be logged in to view this data.']);
        return;
    }

      // Verify nonce
      if (!isset($_POST['lost_report_nonce']) || !wp_verify_nonce($_POST['lost_report_nonce'], 'lost_report_action_nonce')) {
        wp_send_json_error(['message' => 'failed.']);
        return;
    } 

    $user_id = get_current_user_id();
    global $wpdb;
    $lost_report_table = $wpdb->prefix . 'lost_report';

    $details = $wpdb->get_results($wpdb->prepare(
        "SELECT item_name, tracker_id, image_url, reporter FROM $lost_report_table WHERE user_id = %d",
        $user_id
    ));

    if ($wpdb->last_error) {
        wp_send_json_error(['message' => 'Database error: ' . $wpdb->last_error]);
        return;
    }

    if (empty($details)) {
        wp_send_json_error(['message' => 'No data found.']);
    } else {
        wp_send_json_success(['details' => $details]);
    }
}

add_action('wp_ajax_get_lost_report_details', 'get_lost_report_details');


function get_device_registration_details() {
    if (!is_user_logged_in()) {
        wp_send_json_error(['message' => 'You need to be logged in to view this data.']);
        return;
    }

      // Verify nonce
      if (!isset($_POST['device_registration_nonce']) || !wp_verify_nonce($_POST['device_registration_nonce'], 'device_registration_action_nonce')) {
        wp_send_json_error(['message' => 'failed.']);
        return;
    } 

    $user_id = get_current_user_id();
    global $wpdb;
    $device_registered_table = $wpdb->prefix . 'device_registered';

    $details = $wpdb->get_results($wpdb->prepare(
        "SELECT device_name, imei, serial_number, purchase_receipt_url FROM $device_registered_table WHERE user_id = %d",
        $user_id
    ));

    if ($wpdb->last_error) {
        wp_send_json_error(['message' => 'Database error: ' . $wpdb->last_error]);
        return;
    }

    if (empty($details)) {
        wp_send_json_error(['message' => 'No details available']);
    } else {
        wp_send_json_success(['details' => $details]);
    }
}
add_action('wp_ajax_get_device_registration_details', 'get_device_registration_details');


add_action('wp_ajax_handle_picture_upload', 'handle_picture_upload');

function handle_picture_upload() {
    // Check if user is logged in
    if (!is_user_logged_in()) {
        return;
    }


    // Verify nonce (optional but recommended)
    if (!isset($_POST['profile_nonce']) || !wp_verify_nonce($_POST['profile_nonce'], 'profile_picture_upload_nonce')) {
        wp_send_json_error('Nonce verification failed.');
    }

    if (!empty($_FILES['profile_picture'])) {
        $file = $_FILES['profile_picture'];

        // Use WordPress function to handle the file upload
        $uploaded_file = wp_handle_upload($file, array('test_form' => false));

        if (!isset($uploaded_file['error'])) {
            $image_url = $uploaded_file['url']; // Get the uploaded image URL

            // Save the image URL to the user's meta data
            $user_id = get_current_user_id();
            update_user_meta($user_id, 'profile_picture', $image_url);

            // Return a success response with the image URL
            wp_send_json_success(array('image_url' => $image_url));
        } else {
            // Handle upload errors
            wp_send_json_error('Upload failed. Please try again.');
        }
    } else {
        wp_send_json_error('No file uploaded.');
    }
}
