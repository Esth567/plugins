<?php
  function register_admin_menu(){
       add_menu_page(
           'Device Tracker', 
           'Device Tracker', 
           'manage_options',
           'device_tracker',
           'device_tracker_admin_page',
           'dashicons-admin-network',
           23
       );
   }

   add_action('admin_menu', 'register_admin_menu');

   function device_tracker_admin_page()
{
    global $wpdb;

    $table_name = $wpdb->prefix . 'device_tracker';
    $results = $wpdb->get_results("SELECT * FROM $table_name");

    echo '<div class="wrap"><h1>' . __('Tracked Devices', 'device-tracker') . '</h1>';
    echo '<table class="widefat"><thead><tr><th>' . __('User', 'device-tracker') . '</th><th>' . __('Device Type', 'device-tracker') . '</th><th>' . __('IP Address', 'device-tracker') . '</th><th>' . __('Browser', 'device-tracker') . '</th><th>' . __('OS', 'device-tracker') . '</th><th>' . __('Last Login', 'device-tracker') . '</th></tr></thead><tbody>';

    foreach ($results as $row) {
        $user = get_user_by('id', $row->user_id);
        if ($user) {
            echo '<tr><td>' . esc_html($user->user_login) . '</td><td>' . esc_html($row->device_type) . '</td><td>' . esc_html($row->ip_address) . '</td><td>' . esc_html($row->browser) . '</td><td>' . esc_html($row->os) . '</td><td>' . esc_html($row->last_login) . '</td></tr>';
        }
    }

    echo '</tbody></table></div>';
}
