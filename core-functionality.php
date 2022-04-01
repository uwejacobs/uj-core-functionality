<?php
/**
 * Plugin Name:       Core Functionality
 * Description:       This contains all your site's core functionality so that it is theme independent. <strong>It should always be activated</strong>.
 * Version:           1.1.2
 * Author:            Uwe Jacobs
 * Requires at least: 5.6
 * Tested up to:      5.9.2
 * Requires PHP:      7.0
 * Text Domain:       uj-core-functionality
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License version 2, as published by the
 * Free Software Foundation.  You may NOT assume that you can use any other
 * version of the GPL.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.
 *
 * @package    CoreFunctionality
 * @since      1.0.0
 * @copyright  Copyright (c) 2021, Uwe Jacobs
 * @license    GPL-2.0+
 */

if (!defined('ABSPATH')) exit; // Exit if accessed directly

// Plugin directory
define( 'UJ_DIR' , plugin_dir_path( __FILE__ ) );

require_once( UJ_DIR . 'inc/general.php' );
require_once( UJ_DIR . 'inc/wordpress-cleanup.php' );
require_once( UJ_DIR . 'inc/kill-trackbacks.php' );
require_once( UJ_DIR . 'inc/template.php' );
require_once( UJ_DIR . 'inc/display-posts.php' );
require_once( UJ_DIR . 'inc/shortcodes.php' );

// enqueue css and js
add_action( 'admin_enqueue_scripts', 'ujcf_add_admin_option_scripts', 10, 1 );
function ujcf_add_admin_option_scripts() {
	wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_script( 'uj-core-functionality-tabs-js', plugins_url( 'js/tabs.js', __FILE__ ) );
}
add_action( 'admin_enqueue_scripts', 'ujcf_add_option_styles' );
function ujcf_add_option_styles() {
	wp_register_style( 'uj-core-functionality-style-css', plugins_url('css/style.css', __FILE__));
	wp_enqueue_style( 'uj-core-functionality-style-css' );
}

// Image size for sliders
add_action( 'after_setup_theme', 'ujcf_theme_setup' );
function ujcf_theme_setup() {
    add_image_size( 'slider', 0, 600, false ); // 600 pixels high (and unlimited height)
}

// Flamingo for Manager role
add_filter('flamingo_map_meta_cap', 'ujcf_flamingo_map_meta_cap');
function ujcf_flamingo_map_meta_cap( $meta_caps ) {
	$meta_caps = array_merge($meta_caps, array(
		'flamingo_edit_contacts' => 'edit_pages',
		'flamingo_edit_inbound_messages' => 'edit_pages',
		'flamingo_edit_inbound_message' => 'edit_pages',
	));
	return $meta_caps;
}

if (!function_exists('ujcf_customizer_css')) {
    function ujcf_customizer_css()
    {
		echo '<style id="ujcf_customizer_css" type="text/css">';
		echo ujcf_printBoookingBackgroundColors();
		echo '.calendar-legend { font-weight: bold; font-size: 16px; padding:10px; margin-right:20px; }';
		echo '.calendar-table h4 { padding-bottom: 20px; }';
		echo '.calendar-table td { font-weight: bold; font-size: 24px; padding: 10px}';
		echo '.calendar-table th { font-weight: bold; font-size: 20px; background-color: lightgrey }';
		echo '</style>';
	}
	
	add_action( 'wp_head', 'ujcf_customizer_css');
}

