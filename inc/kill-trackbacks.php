<?php
/**
 * Kill Trackbacks
 *
 * @package      CoreFunctionality
 * @author       Uwe Jacobs
 * @since        1.0.0
 * @license      GPL-2.0+
**/

if (!defined('ABSPATH')) exit; // Exit if accessed directly

/*
Plugin Name: Kill Trackbacks
Plugin URI: http://pmg.co/category/wordpress
Description: Kill all trackbacks on WordPress
Version: 1.0
Author: Christopher Davis
Author URI: http://pmg.co/people/chris
*/

if (!function_exists('ujcf_kt_filter_headers')) {
	function ujcf_kt_filter_headers( $headers )
	{
		if( isset( $headers['X-Pingback'] ) )
		{
			unset( $headers['X-Pingback'] );
		}
		return $headers;
	}

	add_filter( 'wp_headers', 'ujcf_kt_filter_headers', 10, 1 );
}

// Kill the rewrite rule
if (!function_exists('ujcf_kt_filter_rewrites')) {
	function ujcf_kt_filter_rewrites( $rules )
	{
		foreach( $rules as $rule => $rewrite )
		{
			if( preg_match( '/trackback\/\?\$$/i', $rule ) )
			{
				unset( $rules[$rule] );
			}
		}
		return $rules;
	}

	add_filter( 'rewrite_rules_array', 'ujcf_kt_filter_rewrites' );
}

// Kill bloginfo( 'pingback_url' )
if (!function_exists('ujcf_kt_kill_pingback_url')) {
	function ujcf_kt_kill_pingback_url( $output, $show )
	{
		if( $show == 'pingback_url' )
		{
			$output = '';
		}
		return $output;
	}

	add_filter( 'bloginfo_url', 'ujcf_kt_kill_pingback_url', 10, 2 );
}

// remove RSD link
remove_action( 'wp_head', 'rsd_link' );

// hijack options updating for XMLRPC
add_filter( 'pre_update_option_enable_xmlrpc', '__return_false' );
add_filter( 'pre_option_enable_xmlrpc', '__return_zero' );

// Disable XMLRPC call
if (!function_exists('ujcf_kt_kill_xmlrpc')) {
	function ujcf_kt_kill_xmlrpc( $action )
	{
		if( 'pingback.ping' === $action )
		{
			wp_die(
				'Pingbacks are not supported',
				'Not Allowed!',
				array( 'response' => 403 )
			);
		}
	}

	add_action( 'xmlrpc_call', 'ujcf_kt_kill_xmlrpc' );
}
