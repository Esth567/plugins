<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

function user_profile_tracker_admin_menu() {
    add_menu_page(
        'Tiiza User',
        'Tiiza User',
        'manage_options',
        'user-profile-tracker',
        'user_profile_tracker_admin_page',
        'dashicons-admin-users',
        20
    );
}

add_action('admin_menu', 'user_profile_tracker_admin_menu');

function user_profile_tracker_admin_page() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'user_registered';
    $users = $wpdb->get_results("SELECT * FROM $table_name");

     // Handle the search query
     $search_term = isset($_POST['s']) ? sanitize_text_field($_POST['s']) : '';
    
     // query to include a WHERE clause if a search term is provided
     if ($search_term) {
         $results = $wpdb->get_results(
             $wpdb->prepare("SELECT * FROM $table_name WHERE first_name LIKE %s OR last_name LIKE %s OR email LIKE %s OR phone LIKE %s OR tracker_id LIKE %s",
                 '%' . $wpdb->esc_like($search_term) . '%',
                 '%' . $wpdb->esc_like($search_term) . '%',
                 '%' . $wpdb->esc_like($search_term) . '%',
                 '%' . $wpdb->esc_like($search_term) . '%',
                 '%' . $wpdb->esc_like($search_term) . '%'
             )
         );
     } else {
         $results = $wpdb->get_results("SELECT * FROM $table_name");
     }

    ?>
    <div class="wrap">
        <h1 class="wp-heading-inline">User Registered</h1>

         <!-- Search Form -->
         <form method="post">
                <p class="search-box">
                    <label class="screen-reader-text" for="search_id-search-input">Search:</label>
                    <input type="search" id="search_id-search-input" name="s" value="<?php echo esc_attr($search_term); ?>" />
                    <input type="submit" id="search-submit" class="button" value="Search" />
                </p>
            </form>
        <table class="wp-list-table widefat fixed striped">
        <thead>
                    <tr>
                        <th id="columnname" class="manage-column column-columnname" scope="col">ID</th>
                        <th id="columnname" class="manage-column column-columnname" scope="col">Username</th>
                        <th id="columnname" class="manage-column column-columnname" scope="col">First Name</th>
                        <th id="columnname" class="manage-column column-columnname" scope="col">Middle Name</th>
                        <th id="columnname" class="manage-column column-columnname" scope="col">Last Name</th>
                        <th id="columnname" class="manage-column column-columnname" scope="col">Email</th>
                        <th id="columnname" class="manage-column column-columnname" scope="col">Phone</th>
                        <th id="columnname" class="manage-column column-columnname" scope="col">Registered At</th>
                    </tr>
                </thead>
            <tbody>
            <?php if ($results) : ?>
                        <?php foreach ($results as $row) : ?>
                            <tr>
                                <td><?php echo esc_html($row->id); ?></td>
                                <td><?php echo esc_html($row->username); ?></td>
                                <td><?php echo esc_html($row->first_name); ?></td>
                                <td><?php echo esc_html($row->middle_name); ?></td>
                                <td><?php echo esc_html($row->last_name); ?></td>
                                <td><?php echo esc_html($row->email); ?></td>
                                <td><?php echo esc_html($row->phone); ?></td>
                                <td><?php echo esc_html($row->registered_at); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="12">No records found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
        </table>
    </div>
    <?php
}