<?php

class DeviceTracker
{
    public static function init()
    {
        // Load text domain for translations.
        load_plugin_textdomain('device-tracker', false, dirname(plugin_basename(__FILE__)) . '/languages');
        
        // Hook into WordPress to track devices.
        add_action('wp_footer', [__CLASS__, 'track_device']);
        
        // Register admin menu for viewing tracked data.
        add_action('admin_menu', [__CLASS__, 'register_admin_menu']);

        add_action('init', [__CLASS__, 'register_shortcodes']);

    }

    public static function track_device()
    {
        // Ensure the user is logged in to track the device.
        if (!is_user_logged_in()) {
            return;
        }

        // Collect device information.
        $user_id = get_current_user_id();
        $ip_address = self::get_ip_address();
        $browser = self::get_browser();
        $os = self::get_os();
        $device_type = wp_is_mobile() ? 'Mobile' : 'Desktop';

        // Store or update device information.
        update_user_meta($user_id, '_device_tracker', [
            'ip_address' => $ip_address,
            'browser' => $browser,
            'os' => $os,
            'device_type' => $device_type,
            'last_login' => current_time('mysql'),
        ]);
    }

    private static function get_ip_address()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            return $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            return $_SERVER['REMOTE_ADDR'];
        }
    }

    private static function get_browser()
    {
        $user_agent = $_SERVER['HTTP_USER_AGENT'];

        if (strpos($user_agent, 'Firefox') !== false) {
            return 'Firefox';
        } elseif (strpos($user_agent, 'MSIE') !== false || strpos($user_agent, 'Trident/7') !== false) {
            return 'Internet Explorer';
        } elseif (strpos($user_agent, 'Edge') !== false) {
            return 'Microsoft Edge';
        } elseif (strpos($user_agent, 'Chrome') !== false) {
            return 'Chrome';
        } elseif (strpos($user_agent, 'Safari') !== false) {
            return 'Safari';
        } elseif (strpos($user_agent, 'Opera') !== false || strpos($user_agent, 'OPR/') !== false) {
            return 'Opera';
        }

        return 'Unknown';
    }

    private static function get_os()
    {
        $user_agent = $_SERVER['HTTP_USER_AGENT'];

        if (strpos($user_agent, 'Windows NT 10.0') !== false) {
            return 'Windows 10';
        } elseif (strpos($user_agent, 'Windows NT 6.3') !== false) {
            return 'Windows 8.1';
        } elseif (strpos($user_agent, 'Windows NT 6.2') !== false) {
            return 'Windows 8';
        } elseif (strpos($user_agent, 'Windows NT 6.1') !== false) {
            return 'Windows 7';
        } elseif (strpos($user_agent, 'Mac OS X') !== false) {
            return 'Mac OS X';
        } elseif (strpos($user_agent, 'Linux') !== false) {
            return 'Linux';
        } elseif (strpos($user_agent, 'iPhone') !== false || strpos($user_agent, 'iPad') !== false) {
            return 'iOS';
        } elseif (strpos($user_agent, 'Android') !== false) {
            return 'Android';
        }

        return 'Unknown';
    }

    public static function track_device(){
    if (!is_user_logged_in()) {
        return;
    }

    global $wpdb;

    $user_id = get_current_user_id();
    $ip_address = self::get_ip_address();
    $browser = self::get_browser();
    $os = self::get_os();
    $device_type = wp_is_mobile() ? 'Mobile' : 'Desktop';
    $last_login = current_time('mysql');
    
    $table_name = $wpdb->prefix . 'device_tracker';

    // Check if a record already exists for the user
    $existing_record = $wpdb->get_var($wpdb->prepare(
        "SELECT id FROM $table_name WHERE user_id = %d",
        $user_id
    ));

    if ($existing_record) {
        // Update the existing record
        $wpdb->update(
            $table_name,
            [
                'device_type' => $device_type,
                'ip_address'  => $ip_address,
                'browser'     => $browser,
                'os'          => $os,
                'last_login'  => $last_login,
            ],
            ['user_id' => $user_id]
        );
    } else {
        // Insert a new record
        $wpdb->insert(
            $table_name,
            [
                'user_id'     => $user_id,
                'device_type' => $device_type,
                'ip_address'  => $ip_address,
                'browser'     => $browser,
                'os'          => $os,
                'last_login'  => $last_login,
            ]
        );
    }
}
public static function register_shortcodes() {
    error_log('Shortcode registered!');
    add_shortcode('device_tracker_search', [__CLASS__, 'display_search_form']);
}

public static function display_search_form() {
    error_log('Shortcode function called!');
    ob_start(); 
    ?>
    <form method="post" action="">
            <label for="search-term"><?php _e('Search by IP Address or Browser:', 'device-tracker'); ?></label>
            <input type="text" id="search-term" name="search_term" placeholder="Enter IP Address or Browser" required>
            <input type="submit" name="search_device" value="<?php _e('Search', 'device-tracker'); ?>">
        </form>
    <?php
    return ob_get_clean();
}

}
if ( class_exists( 'DeviceTracker' )) {
    $deviceTracker = new DeviceTracker();
}
