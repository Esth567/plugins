<?php

if (!defined('ABSPATH')) {
    exit; 
}


function user_profile_tracker_registration_form() {
    if (is_user_logged_in()) {
        return ''; 
    }

    ob_start();
    ?>
    <!-- Example HTML -->
    <div id="registerFormContainer" class="form-container">
    <form id="registration_form">
        <?php wp_nonce_field('registration_action', 'registration_nonce'); ?>
        <h3>Sign Up to get started</h3>
        <h5>Please fill in your details and proceed</h5>
        <div id="form-row">
            <div class="input-container">
                <input type="text" id="username" name="username" placeholder="username" required>
                <i class="fas fa-user icon"></i>
            </div>
            <span class="error-message" id="username-error"></span>
        </div>

        <div id="form-row">
            <div class="input-container">
            <input type="text" id="first_name" name="first_name" placeholder="First Name" required>
                <i class="fas fa-user icon"></i>
            </div>
            <div class="error-message"></div>
        </div>

        <div id="form-row">
            <div class="input-container">
            <input type="text" id="middle_name" name="middle_name" placeholder="Middle Name">
                <i class="fas fa-user icon"></i>
            </div>
            <div class="error-message"></div>
        </div>

        <div id="form-row">
            <div class="input-container">
            <input type="text" id="last_name" name="last_name" placeholder="Last Name" required>
                <i class="fas fa-user icon"></i>
            </div>
            <div class="error-message"></div>
        </div>

        <div id="form-row">
            <div class="input-container">
                <input type="email" id="email" name="email" placeholder="etc@mail.com" required>
                <i class="fas fa-envelope icon"></i>
            </div>
        </div>

        <div id="form-row">
            <div class="input-container">
                <input type="tel" id="phone" name="phone" placeholder="+2347013412451" required>
            </div>
            <span id="phone-error"></span>
        </div>

        <div id="form-row">
            <div class="input-container">
                <input type="password" id="password" name="password" placeholder="Password" required>
                <i class="fas fa-lock icon lock-icon"></i>
                <i class="fas fa-eye icon eye-icon" id="togglePassword"></i>
            </div>
            <div id="password-error" class="error-message"></div>
        </div>
       
        <div id="form-row">
            <div class="input-container">
                <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm Password" required>
                <i class="fas fa-lock icon lock-icon"></i>
                <i class="fas fa-eye icon eye-icon" id="toggleConfirmPassword"></i>
            </div>
            <div id="confirm-password-error" class="error-message"></div>
        </div>

        <div id="btn">
            <button type="submit">Register</button>
        </div>

        <div id="regisLog">
            <h4>Already have an account?</h4>
            <button type="button" id='login_button'>Login</button>
        </div>
    </form>
    <div class="spinner" id="spinner"></div>
    </div>
    <div id="registration-message"></div>
    <?php
    return ob_get_clean();
}
add_shortcode('user_registration_form', 'user_profile_tracker_registration_form');

function handle_registration() {

    if (!isset($_POST['registration_nonce']) || !wp_verify_nonce($_POST['registration_nonce'], 'registration_action')) {
        wp_send_json_error('Invalid. Please refresh the page and try again.');
        return;
    }

    global $wpdb;

    // Check for empty required fields
    if (empty($_POST['username']) || empty($_POST['first_name']) || empty($_POST['last_name']) || empty($_POST['email']) || empty($_POST['password']) || empty($_POST['confirm_password'])) {
        wp_send_json_error('Please fill in all required fields.');
        return;
    }

    $username = sanitize_text_field($_POST['username']);
    $first_name = sanitize_text_field($_POST['first_name']);
    $middle_name = sanitize_text_field($_POST['middle_name']);
    $last_name = sanitize_text_field($_POST['last_name']);
    $email = sanitize_email($_POST['email']);
    $phone = sanitize_text_field($_POST['phone']);
    $password = sanitize_text_field($_POST['password']);
    $confirm_password = sanitize_text_field($_POST['confirm_password']);

    // Check if passwords match
    if ($password !== $confirm_password) {
        wp_send_json_error('Passwords do not match.');
        return;
    }

        // Validate password strength
     if (strlen($password) < 8 || !preg_match('/[A-Z]/', $password) || !preg_match('/[a-z]/', $password) || !preg_match('/\d/', $password) || !preg_match('/[@$!%*?&]/', $password)) {
       wp_send_json_error(__('Password must contain minimum of 8 characters long and contain uppercase letter, lowercase letter, numbers, and special character.'));
       return;
    }

    // Validate phone number
    if (empty($phone) || !preg_match('/^\+[1-9]\d{1,14}$/', $phone)) {
        wp_send_json_error(__('Please enter a valid phone number.'));
        return;
    }


    // Check if email is already registered
    $email_check = $wpdb->get_var($wpdb->prepare(
        "SELECT COUNT(*) FROM {$wpdb->prefix}user_registered WHERE email = %s",
        $email
    ));
    if ($email_check > 0) {
        wp_send_json_error('This email is already registered.');
        return;
    }

      // Check if username is already registered
      $username_check = $wpdb->get_var($wpdb->prepare(
        "SELECT COUNT(*) FROM {$wpdb->prefix}user_registered WHERE username = %s",
        $username
    ));
    if ($username_check > 0) {
        wp_send_json_error(__('This username is already registered.'));
        return;
    }

    // Check if phone number is already registered and verified
    $phone_check = $wpdb->get_var($wpdb->prepare(
        "SELECT COUNT(*) FROM {$wpdb->prefix}user_registered WHERE phone = %s AND is_verified = 1",
        $phone
    ));
    if ($phone_check > 0) {
        wp_send_json_error(__('This phone number is already registered.'));
        return;
    }


    // Hash the password and store user
    $password_hashed = wp_hash_password($password);
    $registered_at = current_time('mysql');
    $verification_token = wp_generate_password(20, false);

    $table_name = $wpdb->prefix . 'user_registered';
    $result = $wpdb->insert(
        $table_name,
        array(
            'username' => $username,
            'first_name' => $first_name,
            'middle_name' => $middle_name,
            'last_name' => $last_name,
            'email' => $email,
            'phone' => $phone,
            'password' => $password_hashed,
            'registered_at' => $registered_at,
            'verification_token' => $verification_token,
            'is_verified' => 0,
        )
    );

    if ($result) {
        $verification_link = site_url('/verify-email?action=verify_email&user_id=' . $wpdb->insert_id . '&token=' . urlencode($verification_token));
        $subject = 'Email Verification';
        $message = "Please click the following link to verify your email: <a href='$verification_link'>Verify Email</a>";
        $headers = array('Content-Type: text/html; charset=UTF-8');

        if (wp_mail($email, $subject, $message, $headers)) {
            wp_send_json_success('Registration successful. Please check your email for the verification link.');
        } else {
            wp_send_json_error('Failed to send verification email.');
        }
    } else {
        wp_send_json_error('Failed to register user.');
    }
}


add_action('wp_ajax_nopriv_handle_registration', 'handle_registration');
add_action('wp_ajax_handle_registration', 'handle_registration');

function user_profile_tracker_verify_email() {
    global $wpdb;

    if (!isset($_GET['user_id'], $_GET['token'])) {
        wp_die('Invalid request.');
    }

    $user_id = absint($_GET['user_id']);
    $token = sanitize_text_field($_GET['token']);

    $table_name = $wpdb->prefix . 'user_registered';
    $user = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id = %d AND verification_token = %s", $user_id, $token));

    if ($user) {
        $token_expiry = strtotime($user->token_generated_at . ' +1 hour'); 
        if (current_time('timestamp') > $token_expiry) {
            wp_redirect(site_url('/verification-error')); 
            exit;
        }

        if (!$user->is_verified) {
            $wpdb->update(
                $table_name,
                array('is_verified' => 1, 'verification_token' => ''), 
                array('id' => $user_id)
            );

            wp_redirect(site_url('/login'));
            exit;
        }
    }

    wp_redirect(site_url('/verification-error')); // Adjust this to your error page URL
    exit;
}



add_action('wp', function() {
    if (isset($_GET['action']) && $_GET['action'] == 'verify_email') {
        user_profile_tracker_verify_email();
    }
});

function hide_register_menu_conditional($items, $args) {
    if (is_user_logged_in()) {
        foreach ($items as $key => $item) {
            if (strcasecmp(trim($item->title), 'Register') === 0) {
                unset($items[$key]);
                break;
            }
        }
    }
    return $items;
}
add_filter('wp_nav_menu_objects', 'hide_register_menu_conditional', 10, 2);



