<?php

/*
Plugin Name: Rothco
Plugin URI: https://facebook.com/ultimatemahbub
Description: This plugin can sync product from Rothco to woocommerce.
Version: 1.1
Author: Mahbubur Rahman
Author URI: http://facebook.com/ultimatemahbub
License: GPL2
*/



if (! defined('ABSPATH')) {
    exit;
}

//require_once($_SERVER['DOCUMENT_ROOT'] .'/wp-config.php');
//require_once($_SERVER['DOCUMENT_ROOT'] .'/wp-load.php');
include_once( plugin_dir_path( __FILE__ ) . 'get_categories.php' );
include_once( plugin_dir_path( __FILE__ ) . 'rothco_sync.php' );
include_once( plugin_dir_path( __FILE__ ) . 'homepage.php' );







add_action( 'admin_menu', 'rothco_menu' );
function rothco_menu() {
    // add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );
    add_menu_page( 'Rothco Sync', 'Rothco Sync', 'manage_options', 'Rothco', 'homepage', 'dashicons-screenoptions', 90 );
}

function rothco_admin_enqueue_scripts(){
    global $pagenow;
    if ($pagenow=='admin.php') {


        // register AngularJS
        wp_register_script('angular-core', '//ajax.googleapis.com/ajax/libs/angularjs/1.2.14/angular.js', array(), null, false);
        wp_enqueue_script('angular-core');

        // JS
        wp_register_script('prefix_bootstrap', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js');
        wp_enqueue_script('prefix_bootstrap');

        // CSS
        wp_register_style('prefix_bootstrap', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css');
        wp_enqueue_style('prefix_bootstrap');


        wp_enqueue_script('jquery');
        wp_enqueue_script( 'jquery-ui-datepicker', array( 'jquery' ) );

        wp_register_style('jquery-ui', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css');
        wp_enqueue_style( 'jquery-ui' );

    }
}

add_action('admin_enqueue_scripts','rothco_admin_enqueue_scripts');

