<?php
/**
 * Plugin Name:       Core Functionality
 * Description:       This contains all your site's core functionality so that it is theme independent. <strong>It should always be activated</strong>.
 * Version:           1.1.0
 * Author:            Uwe Jacobs
 * Requires at least: 5.6
 * Tested up to:      5.9.1
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
