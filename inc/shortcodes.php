<?php
/**
 * Shortcodes
 *
 * @package      CoreFunctionality
 * @author       Uwe Jacobs
 * @since        1.0.0
 * @license      GPL-2.0+
 **/

if (!defined('ABSPATH')) exit; // Exit if accessed directly

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
	
// Shortcode [activeshortcodes]
add_shortcode( 'activeshortcodes', function(){
	global $shortcode_tags;
	
	$shortcodes = $shortcode_tags;
	
	// sort the shortcodes with alphabetical order
	ksort($shortcodes);
	
	$shortcode_output = "<ul>";
	
	foreach ($shortcodes as $shortcode => $value) {
		$shortcode_output = $shortcode_output.'<li>['.$shortcode.']</li>';
	}
	
	$shortcode_output = $shortcode_output. "</ul>";
	
	return $shortcode_output;
});
	
// Shortcode [link url=""]TEXT[/link]
add_shortcode( 'link', function($atts, $content){
	extract( shortcode_atts(
		array(
			'url' => "",
			'class' => "",
			'newwindow' => "0",
			'rel' => "nofollow noopener",
		), $atts )
	);
	
	$url = ( !empty( $url ) ? $url : '#' );
	$newwindow = ( $newwindow == 1 ? ' target="_blank"' : '' );
	$class = ( !empty( $class ) ? ' class="' . $class . '"' : '' );
	$rel = ( !empty( $rel ) ? ' rel="' . $rel . '"' : '' );

	return '<a' . esc_attr($newwindow) . esc_attr($class) . esc_attr($rel) . ' href="' . esc_url($url) . '">' . esc_html($content) . '</a>';
});
