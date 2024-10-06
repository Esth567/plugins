<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; 
}

function forget_password_form() {

    ob_start();
    ?>
    <div id="forgotPasswordContainer" class="form-container">
        <form id="forgot_password_form" action="<?php echo admin_url('admin-ajax.php'); ?>" method="post">
            <!-- Nonce field for security -->
            <input type="hidden" name="action" value="handle_forgot_password">
            <?php wp_nonce_field('forget_pass_action', 'forget_pass_nonce'); ?>
            <div class="icon-cont">
            <i class="fas fa-lock icon lock-icon"></i>
            </div>
            <h4 style="margin-bottom: 5px; font-weight: 600; color: #344989">Reset Password</h4>
            <div id="form-row">
            <div class="input-container">
                <input type="email" id="email" name="email" placeholder="etc@mail.com" required>
                <i class="fas fa-envelope icon"></i>
            </div>
        </div>

            <div id="btn">
                <button type="submit">Reset Password</button>
            </div>
        </form>
        <div class="spinner" id="spinner"></div>
        <div id="regisLog">
            <h3 style="font-size: 15px;">Remember password?</h3>
            <button type="button" id='login_button'>Login</button>
        </div>        
    </div>
    <?php
    return ob_get_clean();
}

// Register shortcode for the form
add_shortcode('forget_form2028', 'forget_password_form');


function handle_forgot_password_ajax() {
    // Verify nonce for security
    if (!isset($_POST['forget_pass_nonce']) || !wp_verify_nonce($_POST['forget_pass_nonce'], 'forget_pass_action')) {
        wp_send_json_error('failed.');
        return;
    }

    // Validate email
    if (empty($_POST['email']) || !is_email($_POST['email'])) {
        wp_send_json_error('Invalid email address.');
        return;
    }



    $email = sanitize_email($_POST['email']);
    
    // Check if the user exists
    $user = get_user_by('email', $email);
    if (!$user) {
        wp_send_json_error('No user found with that email address.');
        return;
    }

    // Rate-limiting to prevent abuse (basic example)
    if (get_transient('password_reset_attempt_' . $user->ID)) {
        wp_send_json_error('Too many reset attempts. Please try again later.');
        return;
    }

    // Generate a password reset key
$reset_key = get_password_reset_key($user);
if (is_wp_error($reset_key)) {
    wp_send_json_error('Failed to generate reset key.');
    return;
}

set_transient('password_reset_token_' . $user->ID, $reset_key, 20 * MINUTE_IN_SECONDS);

    $reset_url = network_site_url("reset-password");

    $subject = 'Password Reset';
    $message = "Please click the link to reset password: <a href='$reset_url'>Reset Password</a>";
    $headers = array('Content-Type: text/html; charset=UTF-8');

    if (wp_mail($email, $subject, $message, $headers)) {
        wp_send_json_success('Please check your email for the reset link.');
    } else {
        wp_send_json_error('Failed to send email.');
    }
}

add_action('wp_ajax_nopriv_handle_forgot_password', 'handle_forgot_password_ajax');
add_action('wp_ajax_handle_forgot_password', 'handle_forgot_password_ajax');


