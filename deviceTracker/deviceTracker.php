<?php
/*
Plugin Name: Device Tracker
Plugin URI: https://tiiza.com.ng/about-us/
Description: A plugin for user registration, login, and profile management.
Version: 6.5.33
Author: Esther Bassey
Author URI: http://ma.tt/
License: GPLv3 or later
Text Domain: device-tracker
Domain Path: /languages
*/
/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

Copyright 2005-2024 Automattic, Inc.
*/


if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class DeviceTracker {
 
    public static function init()
    {

        include_once plugin_dir_path(__FILE__) . 'includes/admin-page.php';
        // Load text domain for translations.
        load_plugin_textdomain('device-tracker', false, dirname(plugin_basename(__FILE__)) . '/languages');
        register_activation_hook(__FILE__, 'device_tracker_create_table');
        // Hook into WordPress to track devices.
        add_action('wp_footer', [__CLASS__, 'track_device']);


    }


function device_tracker_create_table() {
    global $wpdb;
    
    $table_name = $wpdb->prefix . 'device_tracker'; // Table name
    $charset_collate = $wpdb->get_charset_collate(); // Charset and collation
    
    // SQL statement to create the table
    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
        id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
        user_id BIGINT(20) UNSIGNED NOT NULL,
        device_type VARCHAR(50) NOT NULL,
        ip_address VARCHAR(100) NOT NULL,
        browser VARCHAR(100) NOT NULL,
        os VARCHAR(100) NOT NULL,
        last_login DATETIME NOT NULL,
        PRIMARY KEY (id),
        INDEX user_id_index (user_id)
    ) $charset_collate;";
    
    // Include the necessary WordPress file for dbDelta function
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql); // Create or update the table
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
 

//register_deactivation_hook(__FILE__, 'device_tracker_drop_table');

//function device_tracker_drop_table() {
   // global $wpdb;
    //$table_name = $wpdb->prefix . 'device_tracker';

    // Drop the table on deactivation
    //$wpdb->query("DROP TABLE IF EXISTS $table_name");
//}

}
if ( class_exists( 'DeviceTracker' )) {
    $deviceTracker = new DeviceTracker();
}