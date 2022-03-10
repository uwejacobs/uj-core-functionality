<?php
/**
 * Plugin Name:       Core Functionality
 * Description:       This contains all your site's core functionality so that it is theme independent. <strong>It should always be activated</strong>.
 * Version:           1.0.3
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

if (!function_exists('ujcf_includePageShortcode')) {
	function ujcf_includePageShortcode($atts) {
		global $post;
		if (is_numeric($atts['id'])) {
			$_page = get_page($atts['id']);
		} elseif( is_string($atts['id']) && function_exists('get_page_by_path')) {
			$_page = get_page_by_path($atts['id']);
		} else {
			$page = false;
		}

		if (!$_page) {
			return '<div class="alert alert-danger">Page or Post "' . $atts['id'] . '" not found!</div>';
		}
		
		return do_shortcode($_page->post_content);
	}

	// USAGE:
	// In the post content, you can use [include_page id="1235"] where
	// "1234" would be the WordPress ID of the Page you are trying to include
	add_shortcode("include_page", "ujcf_includePageShortcode");
}

// Shortcode [site_url]
add_action( 'init', function() {
	add_shortcode( 'site_url', function( $atts = null, $content = null ) {
		return site_url();
	} );
} );

// Shortcode [domain_name]
add_action( 'init', function() {
	add_shortcode( 'domain_name', function( $atts = null, $content = null ) {
		$urlparts = parse_url(home_url());
		return $urlparts['host'];
	} );
} );

// Shortcode [admin_url]
add_action( 'init', function() {
	add_shortcode( 'admin_url', function( $atts = null, $content = null ) {
		return get_admin_url();
	} );
} );

// Shortcode [activeplugins]
add_shortcode( 'activeplugins', function(){

	$active_plugins = get_option( 'active_plugins' );
	$plugins = "";
	if( count( $active_plugins ) > 0 ){
		$plugins = "<ul>";
		foreach ( $active_plugins as $plugin ) {
			$plugins .= "<li>" . $plugin . "</li>";
		}
		$plugins .= "</ul>";
	}
	return $plugins;
});

// disable wpautop for posts and pages
remove_filter( 'the_content', 'wpautop' );
remove_filter( 'the_excerpt', 'wpautop' );
