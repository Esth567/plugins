<?php 

if (!defined('ABSPATH')) {
    exit; 
}


function user_profile_tracker_login_form() {

    if (is_user_logged_in()) {
        return ''; 
    }

    ob_start();
    ?>
        <div id="loginFormContainer" class="form-container">
            <form id="login_form" action="#" method="post">
                <?php wp_nonce_field('login_action', 'login_nonce'); ?>
                <h3>Welcome Back</h3>
                <h5>Please fill in your details and proceed</h5>
                <div id="form-row">
                    <div class="input-container">
                        <input type="text" id="username" name="username" placeholder="Username" required>
                        <i class="fas fa-user icon"></i>
                    </div>
                </div>

                <div id="form-row">
                    <div class="input-container">
                        <input type="password" id="password" name="password" placeholder="Password" required>
                        <i class="fas fa-lock icon lock-icon"></i>
                        <i class="fas fa-eye icon eye-icon" id="togglePassword"></i>
                    </div>
                </div>

                <div class="login-btn">
                    <button type="submit">Login</button>
                </div>
                <div id="regis">
                    <h4>Don't have an account?</h4>
                    <button type="button" id='register_button'>Register</button>
                </div>

                <div id="forgot-password">
                    <a href="#" id="forgot_password_link">Forgot Password?</a>
                </div>
                <input type="hidden" name="redirect_to_admin" value="<?php echo is_admin() ? 'true' : 'false'; ?>">
            </form>
            <div class="spinner" id="spinner"></div>
        </div>
        <div id="login-message"></div>
    <?php
    return ob_get_clean();
}

add_shortcode('user_login_form', 'user_profile_tracker_login_form');


function handle_login() {

    if (!isset($_POST['login_nonce']) || !wp_verify_nonce($_POST['login_nonce'], 'login_action')) {
        wp_send_json_error('failed.');
        return;
    }
    
    global $wpdb;

    if (!isset($_POST['username']) || !isset($_POST['password'])) {
        wp_send_json_error('Missing required fields.');
    }

    $username = sanitize_text_field($_POST['username']);
    $password = sanitize_text_field($_POST['password']);

    $table_name = $wpdb->prefix . 'user_registered'; 
    $user = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE username = %s", $username));

    if ($user) {
        if (!$user->is_verified) {
            wp_send_json_error('Your email address has not been verified. Please check your email for the verification link.');
            return;
        }

        // Authenticate user with WordPress
        $creds = array(
            'user_login'    => $username,
            'user_password' => $password,
            'remember'      => true,
        );

        $user = wp_signon($creds, false);

        if (is_wp_error($user)) {
            wp_send_json_error('Invalid username or password.');
        } else {
            wp_set_current_user($user->ID);
            wp_set_auth_cookie($user->ID, true);
            do_action('wp_login', $user->user_login, $user);

            $kyc_table = $wpdb->prefix . 'user_kyc';
            $kyc_details = $wpdb->get_row($wpdb->prepare("SELECT * FROM $kyc_table WHERE user_id = %d", $user->ID));

            if ($kyc_details) {
                wp_send_json_success(site_url('/'));
            } else {
                wp_send_json_success(site_url('/kyc'));
            }
        }
    } else {
        wp_send_json_error('Invalid username or password.');
    }
}

add_action('wp_ajax_nopriv_handle_login', 'handle_login');
add_action('wp_ajax_handle_login', 'handle_login');



// Replace the "Login" menu item with "Logout" and user info if the user is logged in
function replace_login_in_menu($items, $args) {
    global $wpdb;

    if (is_user_logged_in()) {
        $current_user = wp_get_current_user();
        
        // Fetch the face capture image URL from the user_kyc table
        $face_capture_url = $wpdb->get_var($wpdb->prepare(
            "SELECT face_capture_url FROM {$wpdb->prefix}user_kyc WHERE user_id = %d",
            $current_user->ID
        ));

        // If the face capture URL exists, use it as the profile picture
        if ($face_capture_url) {
            $profile_picture = $face_capture_url;
        } else {
            $profile_picture = ('https://qph.cf2.quoracdn.net/main-qimg-f32f85d21d59a5540948c3bfbce52e68'); 
        }

        $profile_page_url = home_url('/profile');

        $user_info_html = '
        <div class="user-info">
            <span onclick="window.location.href=\''.esc_url($profile_page_url).'\'" style="cursor: pointer;">
                '.esc_html($current_user->first_name . ' ' . $current_user->last_name).'
            </span>
            <img src="'.esc_url($profile_picture).'" class="profile-picture">
        </div>';        

        foreach ($items as $key => $item) {
            if (strcasecmp(trim($item->title), 'Login') === 0) {
                // Remove the "Login" menu item
                unset($items[$key]);

                // Add the user info HTML before the Logout menu item
                $logout_url = wp_logout_url(home_url());
                $items[] = (object) array(
                    'title' => 'Logout',
                    'menu_item_parent' => 0,
                    'ID' => 1000000, // ID should be unique, use a large number to avoid conflicts
                    'url' => $logout_url,
                    'classes' => '',
                    'target' => '',
                    'attr_title' => '',
                    'xfn' => '',
                    'current' => false,
                );

                // Add the user info HTML as a menu item
                $items[] = (object) array(
                    'title' => $user_info_html,
                    'menu_item_parent' => 0,
                    'ID' => 1000001, // ID should be unique, use a large number to avoid conflicts
                    'url' => '#', // No URL for the user-info item
                    'classes' => '',
                    'target' => '',
                    'attr_title' => '',
                    'xfn' => '',
                    'current' => false,
                );

                break;
            }
        }
    }
    return $items;
}
add_filter('wp_nav_menu_objects', 'replace_login_in_menu', 10, 2);




