<?php
/*
Plugin Name: All Sports
Plugin URI: https://www.sportyfanz.com/
Description: This is for sports for all matches
Version: 1:1:0
Author: Esther Bassey
Author URI: http://ma.tt/
License: GPLv3 or later
Text Domain: all-sports
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

if ( ! defined( 'ABSPATH' )) {
    die;
};


class AllSports {
    function __construct() 
    {
        include_once plugin_dir_path(__FILE__) . 'includes/all-football.php';
        include_once plugin_dir_path(__FILE__) . 'includes/standing.php';
        include_once plugin_dir_path(__FILE__) . 'includes/game.php';

        add_action('wp_enqueue_scripts', array($this, 'football_games_scripts'));

    }

    function football_games_scripts() {
  
        wp_enqueue_style('all-sport-styles', plugins_url('assets/api-football.css', __FILE__));

       // wp_enqueue_script('football-api-js', plugin_dir_url(__FILE__) . 'assets/football-api.js', array('jquery'), '1.0', true);
    
     }

    
}
if ( class_exists( 'AllSports' )) {
    $allSports = new AllSports();
}