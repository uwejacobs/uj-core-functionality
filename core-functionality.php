<?php
/**
 * Plugin Name: Core Functionality
 * Description: This contains all your site's core functionality so that it is theme independent. <strong>It should always be activated</strong>.
 * Version:     1.0.0
 * Author:      Uwe Jacobs
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

// Plugin directory
define( 'UJ_DIR' , plugin_dir_path( __FILE__ ) );

require_once( UJ_DIR . '/inc/general.php' );
require_once( UJ_DIR . '/inc/wordpress-cleanup.php' );
require_once( UJ_DIR . '/inc/kill-trackbacks.php' );
require_once( UJ_DIR . '/inc/template.php' );

/**
 * Display Posts, open
 *
 * @param string $output Output.
 * @param array  $atts Atttributes.
 */
function uj_dps_posts_open( $output, $atts ) {
	global $dps_listing;
	static $accordionCnt = 0;

	if ( ! empty( $atts['wrapper'] ) && 'carousel' === $atts['wrapper'] ) {
		$output = '<style>';
		$output .= '#dps_carousel .carousel-indicators {';
		$output .= '  position: absolute;';
		$output .= '  bottom: -50px;';
		$output .= '}';
		$output .= '#dps_carousel .carousel-inner {';
		$output .= '  width: 70%;';
		$output .= '}';
		$output .= '</style>';
		$output .= '<div id="dps_carousel" class="carousel slide display-posts-listing mb-5" data-ride="carousel">';
		$output .= '    <ol class="carousel-indicators">';

		for ($i = 0; $i < $dps_listing->post_count; $i++) {
            $output .= '        <li data-target="#dps_carousel" data-slide-to="' . $i . '"' .  (!$i ? ' class="active"' : '') . '></li>';
		}

		$output .= '    </ol>';
		$output .= '    <div class="carousel-inner m-auto">';
	} else if ( ! empty( $atts['wrapper'] ) && 'accordion' === $atts['wrapper'] ) {
		$output = '<div id="dps-accordion">';
	}

	return $output;
}
add_filter( 'display_posts_shortcode_wrapper_open', 'uj_dps_posts_open', 10, 2 );

/**
 * Display Posts, close
 *
 * @param string $output Output.
 * @param array  $atts Atttributes.
 */
function uj_dps_posts_close( $output, $atts ) {
	if ( ! empty( $atts['wrapper'] ) && 'carousel' === $atts['wrapper'] ) {
		$output = '    </div>';
		if (!isset($atts['left-arrow']) ||
		   (isset($atts['left-arrow']) && $atts['left-arrow'] === 'true')) {
    		$output .= '    <a class="carousel-control-prev" href="#dps_carousel" role="button" data-slide="prev">';
	    	$output .= '        <span class="carousel-control-prev-icon" aria-hidden="true"></span>';
		    $output .= '        <span class="sr-only">Previous</span>';
    		$output .= '    </a>';
        }
		if (!isset($atts['right-arrow']) ||
		   (isset($atts['right-arrow']) && $atts['right-arrow'] === 'true')) {
    		$output .= '    <a class="carousel-control-next" href="#dps_carousel" role="button" data-slide="next">';
	    	$output .= '        <span class="carousel-control-next-icon" aria-hidden="true"></span>';
		    $output .= '        <span class="sr-only">Next</span>';
    		$output .= '    </a>';
    	}
		$output .= '</div>';
		$output .= '<script>';
		$output .= '    jQuery(window).resize(function () {';
		$output .= '        setCarouselHeight("#dps_carousel");';
		$output .= '    });';
		$output .= '    setCarouselHeight("#dps_carousel");';
		$output .= '    function setCarouselHeight(id) {';
		$output .= '        var slideHeight = [];';
		$output .= '        jQuery(id + " .carousel-item").each(function() {';
		$output .= '            slideHeight.push(jQuery(this).height());';
		$output .= '        });';
		$output .= '        max = Math.max.apply(null, slideHeight);';
		$output .= '        jQuery(id + " .carousel-inner").each(function() {';
		$output .= '            jQuery(this).css("height", max + "px");';
		$output .= '        });';
		$output .= '    }';
		$output .= '</script>';
	} else if ( ! empty( $atts['wrapper'] ) && 'accordion' === $atts['wrapper'] ) {
        $output = '</div>';
	}

	return $output;
}
add_filter( 'display_posts_shortcode_wrapper_close', 'uj_dps_posts_close', 10, 2 );

/**
 * Display Posts, option output
 *
 * @param string $output Output.
 * @param array  $atts Atttributes.
 */
function uj_dps_option_output( $output, $atts ) {
	global $post;
	static $cnt = 0;

	if ( ! empty( $atts['wrapper'] ) && 'carousel' === $atts['wrapper'] ) {
		++$cnt;
		$posttags = get_the_tags($post->ID);
		$icon = get_icon($posttags);

	 	$output = ' <div class="carousel-item' . ($cnt == 1 ? ' active' : '') . '">';
	 	$output .= '   <p class="dps_title' . (!empty($atts['title-class']) ? " " . $atts['title-class'] : "") . '">' . $icon .  esc_html( get_the_title() ) . '</p>';
	 	$output .= '   <p class="dps_text' . (!empty($atts['text-class']) ? " " . $atts['text-class'] : "") . '">' . apply_filters('the_content', get_post_field('post_content', $post->ID)) .  '</p></div>';
	} else 	if ( ! empty( $atts['wrapper'] ) && 'accordion' === $atts['wrapper'] ) {
		++$cnt;
		$posttags = get_the_tags($post->ID);
		$icon = get_icon($posttags);

        $output = '  <div class="card">';
        $output .= '    <div class="card-header" id="dps-accordion-head' . $cnt . '">';
        $output .= '      <h5 class="mb-0">';
        $output .= '        <button class="btn btn-link btn-block text-left" data-toggle="collapse" data-target="#dps-accordion-collapse' . $cnt . '" aria-expanded="true" aria-controls="dps-accordion-collapse' . $cnt . '">';
        $output .= '          <i class="fas fa-plus float-right"></i>' . $icon .  esc_html(get_the_title());
        $output .= '        </button>';
        $output .= '      </h5>';
        $output .= '    </div>';
        $output .= '    <div id="dps-accordion-collapse' . $cnt . '" class="collapse" aria-labelledby="dps-accordion-head' . $cnt . '" data-parent="#dps-accordion">';
        $output .= '      <div class="card-body">';
        $output .= apply_filters('the_content', get_post_field('post_content', $post->ID));
        $output .= '      </div>';
        $output .= '    </div>';
        $output .= '  </div>';
    }

	return $output;
}
add_filter( 'display_posts_shortcode_output', 'uj_dps_option_output', 10, 2 );

function get_icon($tags) {
    $icons = '';

	if ($tags) {
		foreach($tags as $tag) {
			if ($tag->name == "Download") {
				$icons .= '<i class="fas fa-paperclip fa-2x mr-2" aria-hidden="true"></i>';
			}

			if ($tag->name == "Event") {
				$icons .= '<i class="far fa-calendar-alt fa-2x mr-2" aria-hidden="true"></i>';
			}

			if ($tag->name == "Info") {
				$icons .= '<i class="fa fa-info fa-2x mr-2" aria-hidden="true"></i>';
			}

			if ($tag->name == "Shoot") {
				$icons .= '<i class="fas fa-bullseye fa-2x mr-2" aria-hidden="true"></i>';
			}

			if ($tag->name == "Meeting") {
				$icons .= '<i class="fas fa-user-clock fa-2x mr-2" aria-hidden="true"></i>';
			}

			if ($tag->name == "Workparty") {
				$icons .= '<i class="fas fa-tools fa-2x mr-2" aria-hidden="true"></i>';
			}
		}
	}

	return $icons;
}

function includePageShortcode($atts) {
	global $post;

        if (is_numeric($atts['id'])) {
		$_page = get_page($atts['id']);
        } elseif( is_string($atts['id']) && function_exists('get_page_by_path')) {
		$_page = get_page_by_path($atts['id']);
        } else {
		$page = false;
	}

	if (!$_page) {
		return '<div class="alert alert-danger">Page or Post ' . $atts['id'] . ' not found!</div>';
	}
	
	return do_shortcode($_page->post_content);
}

// USAGE:
// In the post content, you can use [digwp_include id="1235"] where
// "1234" would be the WordPress ID of the Page you are trying to include
add_shortcode("include_page", "includePageShortcode");

// disable wpautop for posts and pages
remove_filter( 'the_content', 'wpautop' );
remove_filter( 'the_excerpt', 'wpautop' );
