<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

function user_profile_tracker_kyc_form() {
    if (!is_user_logged_in()) {
        return __('Please login');
    }

    ob_start();
    ?>
    <form id="kyc_form" enctype="multipart/form-data">
    <?php wp_nonce_field('kyc_form_action', 'kyc_nonce'); ?>
    <div id="kyc-progress">
         <div class="stage-container">
           <div class="stage active" id="stage-1">1</div>
          <div class="line"></div>
       </div>
      <div class="stage-container">
         <div class="stage" id="stage-2">2</div>
         <div class="line"></div>
      </div>
      <div class="stage-container">
        <div class="stage" id="stage-3">3</div>
      </div>
   </div>

        <div id="kyc_form-container">
        <div class="form-radio">
          <div id="form-gender">
            <label for="gender">Gender:</label>
            </div>
            <input type="radio" name="gender" value="male" required> Male
            <input type="radio" name="gender" value="female" required> Female<br>
        </div>
       
        
        <div id="form-kyc">
            <label for="address">Address:</label>
            <input type="text" id="address" name="address" placeholder='22, Johnbu Street, Lagos' required><br>
        </div>

        <div id="form-kyc">
            <label for="country">Country:</label>
            <input type="text" id="country" name="country" placeholder='US' required><br>
        </div>

        <div class="form-radio">
          <div id="kyc-label">
          <label for="identity_card_type">Identity Card Type:</label>
            </div>
            <input type="radio" name="identity_card_type" value="passport" required> Passport
            <input type="radio" name="identity_card_type" value="national_id" required> National ID
            <input type="radio" name="identity_card_type" value="voters_card" required> Voters Card<br>
        </div>
        
        <div id="form-identity">
            <label for="identity_card">Identity Card:</label>
            <input type="file" id="identity_card" name="identity_card" accept="image/*" required><br>
        </div>

        <div id="next-btn">
        <button type="button" id="next_to_face_capture">Next</button>
        </div>
    </form>
    <div class="spinner" id="spinner"></div>
    </div>
    <form id="face_capture_form" style="display: none; text-align: center;">
      <video id="video" class="circular-frame" style="position: relative;"></video>   
            <canvas id="canvas" style="display:none;"></canvas> 
            <input type="hidden" id="face_capture" name="face_capture"><br>
            <img id="face_image" class="circular-frame" src="" alt="Captured Face" style="display: none;">
            <div id="countdown-timer"></div>
             <div class="selfie">
            <button type="submit" id="submit-selfie" style="display: none;">Submit Selfie</button>
            </div>
    </form>
    <div id="submission-message" style="margin-top: 40px;">
    <i class="fas fa-check-circle icon" style="width: 50px; height: 50px; color: green"></i>
        <p>KYC information submitted successfully.</p>
        <button id="go-to-home" style="background-color: 344989;">Back to Home</button>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('user_kyc_form', 'user_profile_tracker_kyc_form');

function user_profile_tracker_handle_kyc() {

    if (!isset($_POST['kyc_nonce']) || !wp_verify_nonce($_POST['kyc_nonce'], 'kyc_form_action')) {
        wp_send_json_error(['message' => 'failed']);
    }
    

    if (!is_user_logged_in()) {
        wp_send_json_error('You need to be logged in to submit KYC.');
        exit;
    }

    global $wpdb;
    $kyc_table = $wpdb->prefix . 'user_kyc';

    $user_id = get_current_user_id();
    $gender = sanitize_text_field($_POST['gender']);
    $address = sanitize_text_field($_POST['address']);
    $country = sanitize_text_field($_POST['country']);
    $identity_card_type = sanitize_text_field($_POST['identity_card_type']);
    $identity_card = $_FILES['identity_card'];
    $face_capture = $_POST['face_capture'];

    // Handle identity card upload
    if (!empty($identity_card) && !empty($identity_card['tmp_name'])) {
        if ($identity_card['size'] > 5000000) {
            wp_send_json_error('Identity card file size too large.');
            exit;
        }

        $file_type = wp_check_filetype_and_ext($identity_card['tmp_name'], $identity_card['name']);
        $mime_type = mime_content_type($identity_card['tmp_name']);
        if (!in_array($file_type['ext'], ['jpg', 'jpeg', 'png']) || !in_array($mime_type, ['image/jpeg', 'image/png'])) {
            wp_send_json_error('Invalid file type for identity card.');
            exit;
        }

        $upload = wp_handle_upload($identity_card, array('test_form' => false));
        if (isset($upload['error'])) {
            wp_send_json_error($upload['error']);
            exit;
        }
        $identity_card_url = $upload['url'];
    } else {
        wp_send_json_error('Identity card upload failed.');
        exit;
    }

        // Handle face capture image
        if (!empty($face_capture)) {
            $face_capture_data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $face_capture));
            if ($face_capture_data === false) {
                wp_send_json_error('Invalid face capture data.');
                exit;
            }
        
            $upload_dir = wp_upload_dir();
            $file_path = $upload_dir['path'] . '/face_capture_' . $user_id . '.png';
            
            if (file_put_contents($file_path, $face_capture_data) === false) {
                wp_send_json_error('Failed to save face capture.');
                exit;
            }
        
            $face_capture_url = $upload_dir['url'] . '/face_capture_' . $user_id . '.png';
        } else {
            wp_send_json_error('Face capture failed.');
            exit;
        }        

    // Check if the user already has a KYC record
    $existing_record = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $kyc_table WHERE user_id = %d", $user_id));

    if ($existing_record) {
        // Update existing record
        $result = $wpdb->update(
            $kyc_table,
            array(
                'gender' => $gender,
                'address' => $address,
                'country' => $country,
                'identity_card_type' => $identity_card_type,
                'identity_card_url' => $identity_card_url,
                'face_capture_url' => $face_capture_url
            ),
            array('user_id' => $user_id),
            array('%s', '%s', '%s', '%s', '%s', '%s'),
            array('%d')
        );
    } else {
        // Insert new record
        $result = $wpdb->insert(
            $kyc_table,
            array(
                'user_id' => $user_id,
                'gender' => $gender,
                'address' => $address,
                'country' => $country,
                'identity_card_type' => $identity_card_type,
                'identity_card_url' => $identity_card_url,
                'face_capture_url' => $face_capture_url
            ),
            array('%d', '%s', '%s', '%s', '%s', '%s', '%s')
        );
    }

    if ($result === false) {
        error_log('Database Insert Error: ' . $wpdb->last_error);
        wp_send_json_error('An unexpected error occurred. Please try again.');
        exit;
    } else {
        wp_send_json_success('KYC information submitted successfully.');
        exit;
    }
}


add_action('wp_ajax_user_profile_tracker_handle_kyc', 'user_profile_tracker_handle_kyc');
add_action('wp_ajax_nopriv_user_profile_tracker_handle_kyc', 'user_profile_tracker_handle_kyc');



function register_kyc_admin_page() {
    add_menu_page(
        'KYC Submissions', // Page title
        'KYC Submissions', // Menu title
        'manage_options', // Capability
        'kyc-submissions', // Menu slug
        'kyc_admin_page_template', // Function to display the page content
        'dashicons-id', // Icon
        6 // Position
    );
}
add_action('admin_menu', 'register_kyc_admin_page');

function kyc_admin_page_template() {
    global $wpdb;
    $kyc_table = $wpdb->prefix . 'user_kyc';
    $kyc_data = $wpdb->get_results("SELECT * FROM $kyc_table");

    echo '<div class="wrap">';
    echo '<h1>KYC Submissions</h1>';

    echo '<table class="wp-list-table widefat fixed striped">';
    echo '<thead>';
    echo '<tr>';
    echo '<th>ID</th>';
    echo '<th>User ID</th>';
    echo '<th>Gender</th>';
    echo '<th>Address</th>';
    echo '<th>Country</th>';
    echo '<th>Identity Card Type</th>';
    echo '<th>Identity Card URL</th>';
    echo '<th>Face Capture URL</th>';
    echo '<th>Date</th>';
    echo '<th>Status</th>';
    echo '<th>Actions</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';

    if ($kyc_data) {
        foreach ($kyc_data as $data) {

            // Status field
            $status = esc_html($data->status);
            $status_text = ($status == 'pending_review') ? 'Pending Review' : 'Verified';
            $status_color = ($status == 'pending_review') ? 'red' : 'green';

            echo '<tr>';
            echo '<td>' . esc_html($data->id) . '</td>';
            echo '<td>' . esc_html($data->user_id) . '</td>';
            echo '<td>' . esc_html($data->gender) . '</td>';
            echo '<td>' . esc_html($data->address) . '</td>';
            echo '<td>' . esc_html($data->country) . '</td>';
            echo '<td>' . esc_html($data->identity_card_type) . '</td>';
            echo '<td><a href="' . esc_url($data->identity_card_url) . '" target="_blank">View Identity Card</a></td>';
            echo '<td><a href="' . esc_url($data->face_capture_url) . '" target="_blank">View Face Capture</a></td>';
            echo '<td>' . esc_html($data->date) . '</td>';
            echo '<td style="color:' . $status_color . ';">' . $status_text . '</td>';

            // Action buttons for admin to verify KYC
            if ($status == 'pending_review') {
                echo '<td><button class="verify-kyc" data-id="' . esc_attr($data->id) . '">Verify</button></td>';
            } else {
                echo '<td>Verified</td>';
            }

            echo '</tr>';
        }
    } else {
        echo '<tr><td colspan="11">No KYC submissions found.</td></tr>';
    }

    echo '</tbody>';
    echo '</table>';
    echo '</div>';
}

function verify_kyc_submission() {
    global $wpdb;
    $kyc_table = $wpdb->prefix . 'user_kyc';
    $kyc_id = intval($_POST['kyc_id']);

    if (current_user_can('manage_options') && $kyc_id) {
        // Update the status to "Verified"
        $wpdb->update(
            $kyc_table,
            array('status' => 'verified'),
            array('id' => $kyc_id),
            array('%s'),
            array('%d')
        );

        wp_send_json_success();
    } else {
        wp_send_json_error();
    }
}
add_action('wp_ajax_verify_kyc_submission', 'verify_kyc_submission');

