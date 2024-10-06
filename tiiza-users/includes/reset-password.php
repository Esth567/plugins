<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; 
}

function custom_reset_password_form() {
    if (!isset($_GET['key']) || !isset($_GET['login'])) {
        return 'Invalid password reset link.';
    }

    ob_start();
    ?>
    <div id="passwordResetContainer" class="form-container">
    <form id="reset_password_form">
    <?php wp_nonce_field('reset_password_nonce_action', 'reset_password_nonce'); ?>
        <input type="hidden" id="rp_key" name="rp_key" value="<?php echo esc_attr($_GET['key']); ?>">
        <input type="hidden" id="rp_login" name="rp_login" value="<?php echo esc_attr($_GET['login']); ?>">
        <h3 style="color: #344989; font-weight: 600;">Password Reset</h3>
        
            <label for="new_password" style="font-weight: 600; font-size: 14px;">New Password</label>
            <div class="resetPassword-container">
            <input type="password" id="new_password" name="new_password" required>
            <i class="fas fa-lock icon lock-icon"></i>
                <i class="fas fa-eye icon eye-icon" id="togglePassword"></i>
        </div>
        
            <label for="confirm_password" style="font-weight: 600; font-size: 14px;  margin-top: -5px;">Confirm Password</label>
            <div class="resetPassword-container">
            <input type="password" id="confirm_password" name="confirm_password" required>
            <i class="fas fa-lock icon lock-icon"></i>
                <i class="fas fa-eye icon eye-icon" id="toggleConfirmPassword"></i>
        </div>
        <div id="btn">
            <button type="submit" style="margin-bottom: 20px;">Reset Password</button>
        </div>
    </form>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('reset_password678', 'custom_reset_password_form');



// Updated reset password handler
function handle_reset_password_ajax() {
    // Verify nonce
    if (!isset($_POST['reset_password_nonce']) || !wp_verify_nonce($_POST['reset_password_nonce'], 'reset_password_nonce_action')) {
        wp_send_json_error('Invalid request.');
        return;
    }

    // Validate the reset key from the cookie
    if (!isset($_COOKIE['reset_key'])) {
        wp_send_json_error('Reset token not found or expired.');
        return;
    }

 // Debug: Check if the user is valid or not
 if (is_wp_error($user)) {
    error_log('Invalid reset key or expired.');
    wp_send_json_error('Invalid or expired reset token.');
    return;
}
    
    $reset_key = sanitize_text_field($_COOKIE['reset_key']);

    // Validate inputs
    if (empty($_POST['new_password']) || empty($_POST['confirm_password'])) {
        wp_send_json_error('Please fill in all required fields.');
        return;
    }

    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Enforce password strength requirements
    if (strlen($new_password) < 8 || !preg_match('/\d/', $new_password) || !preg_match('/[A-Z]/', $new_password) || !preg_match('/[!@#$%^&*]/', $new_password)) {
        wp_send_json_error('Password must be at least 8 characters long and contain at least one number, one uppercase letter, and one special character.');
        return;
    }

    // Check if passwords match
    if ($new_password !== $confirm_password) {
        wp_send_json_error('Passwords do not match.');
        return;
    }

    // Retrieve the user based on the reset key
    $user = check_password_reset_key($reset_key, '');

    if (is_wp_error($user)) {
        wp_send_json_error('Invalid or expired reset token.');
        return;
    }

    // Set the new password
    wp_set_password($new_password, $user->ID);

    // Clear the reset key cookie
    setcookie('reset_key', '', time() - 3600, '/', '', true, true);

    // Notify the user via email
    $user_email = $user->user_email;
    $subject = 'Password Reset Confirmation';
    $message = 'Hello, your password has been successfully reset. If you did not perform this action, please contact support immediately.';
    $headers = array('Content-Type: text/html; charset=UTF-8');

    wp_mail($user_email, $subject, $message, $headers);

    wp_send_json_success('Password reset successfully. You can now log in with your new password.');
}


add_action('wp_ajax_nopriv_handle_reset_password', 'handle_reset_password_ajax');
add_action('wp_ajax_handle_reset_password', 'handle_reset_password_ajax');


