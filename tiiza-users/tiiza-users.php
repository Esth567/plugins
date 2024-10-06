<?php
/*
Plugin Name: Tiiza Users
Plugin URI: https://tiiza.com.ng/about-us/
Description: A plugin for user registration, login, and profile management.
Version: 6.5.38
Author: Esther Bassey
Author URI: http://ma.tt/
License: GPLv3 or later
Text Domain: tiiza-users
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

class TiizaUsers {

    function __construct()
    {
        // Include required files
        include_once plugin_dir_path(__FILE__) . 'includes/register.php';
        include_once plugin_dir_path(__FILE__) . 'includes/login.php';
        include_once plugin_dir_path(__FILE__) . 'includes/kyc.php';
        include_once plugin_dir_path(__FILE__) . 'includes/profile.php';
        include_once plugin_dir_path(__FILE__) . 'includes/admin-page.php';
        include_once plugin_dir_path(__FILE__) . 'includes/forgot-password.php';
        include_once plugin_dir_path(__FILE__) . 'includes/reset-password.php';
        include_once plugin_dir_path(__FILE__) . 'includes/logout.php';
        //include_once plugin_dir_path(__FILE__) . 'includes/user-displayname.php';
       

        register_activation_hook(__FILE__, array($this, 'user_profile_tracker_activate'));


        add_action('wp_enqueue_scripts', array($this, 'user_profile_enqueue_scripts'));

        add_filter('wp_header', array($this, 'user_profile_enqueue_scripts'));


        //register_deactivation_hook(__FILE__, 'user_profile_tracker_deactivate');

    }

// Activation hook
function user_profile_tracker_activate() {
    global $wpdb;
  
    $table_name = $wpdb->prefix . 'user_registered';
    $kyc_table = $wpdb->prefix . 'user_kyc';
    $profile_details_table = $wpdb->prefix . 'profile_picture_upload';
    $charset_collate = $wpdb->get_charset_collate();

    $sql_registered = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        username varchar(60) NOT NULL,
        first_name varchar(255) NOT NULL,
        middle_name varchar(255) NOT NULL,
        last_name varchar(255) NOT NULL,
        email varchar(100) NOT NULL,
        phone varchar(100) NOT NULL,
        password varchar(255) NOT NULL,
        registered_at datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
        is_verified tinyint(1) DEFAULT 0 NOT NULL,
        verification_token varchar(255) NOT NULL,
        PRIMARY KEY  (id)
    ) $charset_collate;";


$sql_kyc = "CREATE TABLE $kyc_table (
     id mediumint(9) NOT NULL AUTO_INCREMENT,
     user_id bigint(20) NOT NULL,
     gender varchar(255) NOT NULL,
     address varchar(255) NOT NULL,
     country varchar(255) NOT NULL,
     identity_card_type varchar(255) NOT NULL,
     identity_card_url varchar(255) NOT NULL,
     face_capture_url varchar(255) NOT NULL,
     date datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
     status varchar(255) NOT NULL,
     PRIMARY KEY  (id),
     UNIQUE KEY user_id (user_id)
) $charset_collate;";

$sql_profile = "CREATE TABLE $profile_details_table (
    id mediumint(9) NOT NULL AUTO_INCREMENT,
    user_id BIGINT(20) NOT NULL,
    first_name varchar(255) NOT NULL,
    middle_name varchar(255) NOT NULL,
    last_name varchar(255) NOT NULL,
    profile_picture VARCHAR(255) DEFAULT '' NOT NULL,   
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY  (id),
    UNIQUE KEY `user_id` (`user_id`)
) $charset_collate;";


    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql_registered);
    dbDelta($sql_kyc);
    dbDelta($sql_profile);
    
}


function user_profile_enqueue_scripts() {

    wp_enqueue_style('fontawesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css');
  // Enqueue intl-tel-input CSS
  wp_enqueue_style('intl-tel-input-css', 'https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.12/css/intlTelInput.css', array(), '17.0.12');

  // Enqueue intl-tel-input JS
  wp_enqueue_script('intl-tel-input-js', 'https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.12/js/intlTelInput.min.js', array('jquery'), '17.0.12', true);

    // Enqueue custom CSS
    wp_enqueue_style('tiisa-users-styles', plugins_url('assets/tiiza-users.css', __FILE__), array(), '1.0.0', 'all');


    // Enqueue custom script
    wp_enqueue_script('tiisa-users-script', plugins_url('assets/users.js', __FILE__), array('jquery', 'intl-tel-input-js'), '1.0.0', true);

    $logout_nonce = wp_create_nonce('logout_nonce_action');

    
       // Localize the script with the REST URL
       wp_localize_script('tiisa-users-script', 'usersoftiizaAjax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'redirect_url' => home_url(), 
        'logout_nonce' => $logout_nonce,
       
    ));
}



// Deactivation hook
//function user_profile_tracker_deactivate() {
    // Add code for deactivation
//}



}

if ( class_exists( 'TiizaUsers' )) {
    $tiizaUsers = new TiizaUsers();
}