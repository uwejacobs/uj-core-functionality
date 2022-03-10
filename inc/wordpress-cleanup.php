<?php
/**
 * WordPress Cleanup
 *
 * @package      CoreFunctionality
 * @author       Uwe Jacobs
 * @since        1.0.0
 * @license      GPL-2.0+
**/

if (!defined('ABSPATH')) exit; // Exit if accessed directly

/**
 * Attachment ID on Images
 *
 * @since  1.1.0
 */
if (!function_exists('ujcf_attachment_id_on_images')) {
	function ujcf_attachment_id_on_images( $attr, $attachment ) {
		if( !strpos( $attr['class'], 'wp-image-' . $attachment->ID ) ) {
			$attr['class'] .= ' wp-image-' . $attachment->ID;
		}
		return $attr;
	}

	add_filter( 'wp_get_attachment_image_attributes', 'ujcf_attachment_id_on_images', 10, 2 );
}

/**
 * Default Image Link is None
 *
 * @since 1.2.0
 */
if (!function_exists('ujcf_default_image_link')) {
	function ujcf_default_image_link() {
		$link = get_option( 'image_default_link_type' );
		if( 'none' !== $link )
			update_option( 'image_default_link_type', 'none' );
	}

	add_action( 'init', 'ujcf_default_image_link' );
}
