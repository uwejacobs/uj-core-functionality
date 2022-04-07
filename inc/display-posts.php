<?php
/**
 * Display Posts hooks
 *
 * @package    CoreFunctionality
 * @since      1.0.0
 * @copyright  Copyright (c) 2021, Uwe Jacobs
 * @license    GPL-2.0+
 */

if (!defined('ABSPATH')) exit; // Exit if accessed directly

require_once( 'display-posts/init.php' );
require_once( 'display-posts/custom_post_types.php' );
require_once( 'display-posts/custom_fields.php' );
require_once( 'display-posts/quick_edit_box.php' );

/**
 * Display Posts, open
 *
 * @param string $output Output.
 * @param array  $atts Atttributes.
 */
if (!function_exists('ujcf_dps_posts_open')) {
	function ujcf_dps_posts_open($output, $atts) {
		global $dps_listing;

		$dpsCnt = ujcf_static_dps_counter();

		$indicator_cnt = $dps_listing->post_count;

		if ( ! empty( $atts['post_type'] ) && 'booking' === $atts['post_type'] ) {
			ujcf_static_booking_dates();
			$indicator_cnt = 12;
		}

		if ( ! empty( $atts['post_type'] ) && 'alert' === $atts['post_type'] ) {
			return $output;
		}

		$interval = intval($atts["interval"] ?? 5000);

		if ( ! empty( $atts['wrapper'] ) && 'carousel' === $atts['wrapper'] ) {
			$arrow_class = (!empty($atts['arrow-color-class']) ? 'bg-' . $atts['arrow-color-class'] : "bg-dark");
			
			$output = '<style type="text/css">';
			$output .= '#dps-carousel-' . esc_attr($dpsCnt) . ' .carousel-indicators {';
			$output .= '  position: absolute;';
			$output .= '}';
			$output .= '#dps-carousel-' . esc_attr($dpsCnt) . ' .carousel-inner {';
			$output .= '  width: 70%;';
			$output .= '}';
			$output .= '</style>';
			$output .= '<div id="dps-carousel-' . esc_attr($dpsCnt) . '" class="dps-carousel carousel slide mb-5" data-bs-ride="carousel" data-bs-interval="'.$interval.'">';
			$output .= '    <ol class="carousel-indicators">';

			for ($i = 0; $i < $indicator_cnt; $i++) {
				$output .= '        <li data-bs-target="#dps-carousel-' . esc_attr($dpsCnt) . '" data-bs-slide-to="' . esc_attr($i) . '" class="' . esc_attr($arrow_class) . (!$i ? ' active' : '') . '"></li>';
			}

			$output .= '    </ol>';
			$output .= '    <div class="carousel-inner m-auto">';
		} else if ( ! empty( $atts['wrapper'] ) && 'accordion' === $atts['wrapper'] ) {
			$output = '<div id="dps-accordion-' . esc_attr($dpsCnt) . '" class="accordion dps-accordion">';
		}

		return $output;
	}
	add_filter( 'display_posts_shortcode_wrapper_open', 'ujcf_dps_posts_open', 10, 2 );
}

/**
 * Display Posts, close
 *
 * @param string $output Output.
 * @param array  $atts Atttributes.
 */
if (!function_exists('ujcf_dps_posts_close')) {
	function ujcf_dps_posts_close( $output, $atts ) {

		$dpsCnt = ujcf_static_dps_counter();
		$addlOutput = '';

		if (!empty($atts['post_type']) && 'booking' === $atts['post_type']) {
			$start = new DateTime();
			$end = new DateTime();
			$end = $end->modify( '+1 year' );
			$interval = new DateInterval('P1M');
			$period = new DatePeriod($start, $interval, $end);

			foreach ($period as $dt) {
				$addlOutput .= ujcf_showCalendarMonth($atts, $dt->format("m"), $dt->format("Y"));
			}
		}

		if ( ! empty( $atts['post_type'] ) && 'alert' === $atts['post_type'] ) {
			return $output;
		}

		if ( ! empty( $atts['wrapper'] ) && 'carousel' === $atts['wrapper'] ) {
			$output = '</div>';
			$arrow_class = (!empty($atts['arrow-color-class']) ? 'text-' . $atts['arrow-color-class'] : "text-dark");
			if (!isset($atts['left-arrow']) ||
			   (isset($atts['left-arrow']) && $atts['left-arrow'] === 'true')) {
				$output .= '    <a class="carousel-control-prev" href="#dps-carousel-' . esc_attr($dpsCnt) . '" role="button" data-bs-slide="prev">';
				$output .= '        <i class="fas fa-chevron-circle-left fa-3x ' . esc_attr($arrow_class) . '" aria-hidden="true"></i>';
				$output .= '        <span class="sr-only">Previous</span>';
				$output .= '    </a>';
			}
			if (!isset($atts['right-arrow']) ||
			   (isset($atts['right-arrow']) && $atts['right-arrow'] === 'true')) {
				$output .= '<a class="carousel-control-next" href="#dps-carousel-' . esc_attr($dpsCnt) . '" role="button" data-bs-slide="next">';
				$output .= '        <i class="fas fa-chevron-circle-right fa-3x ' . esc_attr($arrow_class) . '" aria-hidden="true"></i>';
				$output .= '    <span class="sr-only">Next</span>';
				$output .= '</a>';
			}
			$output .= '</div>';
			$output .= '<script>';
			$output .= '    jQuery(window).resize(function () {';
			$output .= '        setCarouselHeight' . esc_attr($dpsCnt) . '("#dps-carousel-' . esc_attr($dpsCnt) . '");';
			$output .= '    });';
			$output .= '    jQuery(document).ready(function () {';
			$output .= '        jQuery(window).trigger("resize");';
			$output .= '    });';
			$output .= '    jQuery("#dps-carousel-' . esc_attr($dpsCnt) . '").bind("slide.bs.carousel", function () {';
			$output .= '        jQuery(window).trigger("resize");';
			$output .= '    });';
			$output .= '    function setCarouselHeight' . esc_attr($dpsCnt) . '(id) {';
			$output .= '        var slideHeight = [];';
			$output .= '        jQuery(id + " .carousel-item").each(function() {';
			$output .= '            slideHeight.push(jQuery(this).height());';
			$output .= '        });';
			$output .= '        max = Math.max.apply(null, slideHeight);';
			$output .= '        jQuery(id + " .carousel-inner").each(function() {';
			$output .= '            jQuery(this).css("height", (max+50) + "px");';
			$output .= '        });';
			$output .= '    }';
			$output .= '</script>';
		} else if (!empty($atts['wrapper']) && 'accordion' === $atts['wrapper']) {
			$output = '</div>';
		}

		return $addlOutput . $output;
	}
	add_filter('display_posts_shortcode_wrapper_close', 'ujcf_dps_posts_close', 10, 2);
}

/**
 * Display Posts, option output
 *
 * @param string $output Output.
 * @param array  $atts Atttributes.
 */
if (!function_exists('ujcf_dps_option_output')) {
	function ujcf_dps_option_output($output, $atts) {
		global $post;

		if (!empty($atts['layout'])) {
			ob_start();
			get_template_part('template-parts/dps', $atts['layout']);
			$new_output = ob_get_clean();
			if (!empty($new_output)) {
				$output = $new_output;
			}
		} else if (!empty($atts['wrapper_id']) && $atts['wrapper_id'] == 'frontpage-updates') {
			$new_output = ujcf_dps_option_output_frontpage_updates($output, $atts);
			if (!empty($new_output)) {
				$output = $new_output;
			}
		} else if (!empty($atts['post_type'])) {
			switch($atts['post_type']) {
				case 'testimonial':
					$new_output = ujcf_dps_option_output_testimonials($output, $atts);
					if (!empty($new_output)) {
						$output = $new_output;
					}
					break;
				case 'booking':
					$meta = get_post_meta($post->ID);

					if (!empty($meta["start_date"][0]) && !empty($meta["status"][0])) {
						$start = new DateTime( $meta["start_date"][0] );
						if (empty($meta["end_date"][0])) {
							$end = new DateTime( $meta["start_date"][0] );
						} else {
							$end = new DateTime( $meta["end_date"][0] );
						}

						$end = $end->modify( '+1 day' );
						$interval = new DateInterval('P1D');
						$period = new DatePeriod($start, $interval, $end);

						$ujcf_booking_dates = ujcf_static_booking_dates();
						foreach ($period as $dt) {
							$ujcf_booking_dates[$dt->format("Y-m-d")] = $meta["status"][0];
						}
						ujcf_static_booking_dates($ujcf_booking_dates);
					}

					$output = '';
					break;
				case 'alert':
					$new_output = ujcf_dps_option_output_alerts($output, $atts);
					if (!empty($new_output)) {
						$output = $new_output;
					}
					break;
				case 'faq':
				case 'fundraiser':
				case 'news':
					$new_output = ujcf_dps_option_output_image_and_text($output, $atts);
					if (!empty($new_output)) {
						$output = $new_output;
					}
					break;
				case 'event':
					$new_output = ujcf_dps_option_output_events($output, $atts);
					if (!empty($new_output)) {
						$output = $new_output;
					}
					break;
			}
		}

		return $output;
	}
	add_filter('display_posts_shortcode_output', 'ujcf_dps_option_output', 10, 2);
}

if (!function_exists('ujcf_dps_option_output_frontpage_updates')) {
	function ujcf_dps_option_output_frontpage_updates($output, $atts) {
		global $post;

		$cnt = ujcf_static_dps_item_counter();
		$dpsCnt = ujcf_static_dps_counter();
		$posttags = get_the_tags($post->ID);
		$icon = ujcf_get_icon($posttags);
		$icon_kses = array('i' => array('class' => array(), 'aria-hidden' => array()));

		if (!empty($atts['wrapper'] ) && 'carousel' === $atts['wrapper']) {
			$output = ' <div class="carousel-item' . ($cnt == 1 ? ' active' : '') . '">';
			$output .= '   <h3 class="dps-title' . (!empty($atts['title-class']) ? " " . esc_attr($atts['title-class']) : "") . '">' . wp_kses($icon, $icon_kses) .  esc_html(get_the_title()) . '</h3>';
			$output .= '   <p class="dps-text' . (!empty($atts['text-class']) ? " " . esc_attr($atts['text-class']) : "") . '">' . apply_filters('the_content', get_post_field('post_content', $post->ID)) .  '</p></div>';
		} else 	if (!empty( $atts['wrapper'] ) && 'accordion' === $atts['wrapper']) {
			$output  = '<div class="accordion-item">';
			$output .= '    <h3 id="dps-accordion-head-' . esc_attr($dpsCnt) . '-' . esc_attr($cnt) . '" class="accordion-header' . (!empty($atts['title-class']) ? " " . esc_attr($atts['title-class']) : "") . '">';
			$output .= '      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#dps-accordion-collapse-' . esc_attr($dpsCnt) . '-' . esc_attr($cnt) . '" aria-expanded="false" aria-controls="dps-accordion-collapse-' . esc_attr($dpsCnt) . '-' . esc_attr($cnt) . '">';
			$output .= wp_kses($icon, $icon_kses) .  esc_html(get_the_title());
			$output .= '      </button>';
			$output .= '    </h3>';
			$output .= '  <div id="dps-accordion-collapse-' . esc_attr($dpsCnt) . '-' . esc_attr($cnt) . '" class="accordion-collapse collapse" aria-labelledby="dps-accordion-head-' . esc_attr($dpsCnt) . '-' . esc_attr($cnt) . '" data-bs-parent="#dps-accordion-' . esc_attr($dpsCnt) . '">';
			$output .= '    <div class="accordion-body">';
			$output .= apply_filters('the_content', get_post_field('post_content', $post->ID));
			$output .= '    </div>';
			$output .= '  </div>';
			$output .= '</div>';
		}
		
		return $output;
	}
}

if (!function_exists('ujcf_dps_option_output_image_and_text')) {
	function ujcf_dps_option_output_image_and_text($output, $atts) {
		global $post;

		$cnt = ujcf_static_dps_item_counter();
		$dpsCnt = ujcf_static_dps_counter();
		$type = $atts['post_type'];
		if (empty($type)) {
			return ($output);
		}
		
		$defaultImage = wp_get_attachment_image_url(ujcf_get_theme_option($type . '_image'));
		$defaultAlt = "Generic " . $type . " image";

		$meta = get_post_meta($post->ID);
		
		if (!empty($defaultImage)) {
			$img = wp_get_attachment_image_url($meta["image"][0], 'thumbnail');
			if (!$img) {
				$img = $defaultImage;
			}
			$alt = get_post_meta($meta["image"][0], '_wp_attachment_image_alt', true);
			if (!$alt) {
				$alt = $defaultAlt;
			}
			$max_height = intval($atts["max_height"] ?? 50);
		} else {
			$img = null;
		}
		$rawText = do_shortcode($meta["text"][0] ?? '');
		$rawText = str_replace("\n", '<br>', $rawText);
		$text = ujcf_wp_split_words( $rawText );

		if (!empty($atts['wrapper'] ) && 'carousel' === $atts['wrapper']) {
			$output = ' <div class="carousel-item' . ($cnt == 1 ? ' active' : '') . '">';
			$output .= '<div class="d-flex">';
			if ($img) {
				$output .= '<div class="flex-shrink-0 me-3">';
				$output .= '  <img style="max-height:' . esc_attr($max_height) . 'px" class="me-3" src="' . esc_url($img) . '" alt="' . esc_attr($alt) . '">';
				$output .= '</div>';
			}
			$output .= '  <div class="flex-grow-1">';
			$output .= '    <h3 class="mt-0 mb-1 dps-title' . (!empty($atts['title-class']) ? " " . esc_attr($atts['title-class']) : "") . '">' . esc_html( get_the_title() ) . '</h3>';

			$output .= ujcf_print_more_text($text, $dpsCnt, $cnt);

			$output .= '  </div>';
			$output .= '</div>';	
			$output .= '</div>';	
			$output .= ujcf_print_more_script($text, $dpsCnt, $cnt);
		} else 	if (!empty( $atts['wrapper'] ) && 'accordion' === $atts['wrapper']) {
			$output  = '<div class="accordion-item">';
			$output .= '    <h3 id="dps-accordion-head-' . esc_attr($dpsCnt) . '-' . esc_attr($cnt) . '" class="accordion-header' . (!empty($atts['title-class']) ? " " . esc_attr($atts['title-class']) : "") . '">';
			$output .= '      <button class="accordion-button collapsed" type-"button" data-bs-toggle="collapse" data-bs-target="#dps-accordion-collapse-' . esc_attr($dpsCnt) . '-' . esc_attr($cnt) . '" aria-expanded="false" aria-controls="dps-accordion-collapse-' . esc_attr($dpsCnt) . '-' . esc_attr($cnt) . '">';
			if ($img) {
				$output .= '  <img style="max-height:' . $max_height . 'px" class="me-3 dps-thumbnail" src="' . esc_url($img) . '" alt="' . esc_attr($alt) . '">';
			}
			$output .= esc_html(get_the_title());
			$output .= '      </button>';
			$output .= '    </h3>';
			$output .= '  <div id="dps-accordion-collapse-' . esc_attr($dpsCnt) . '-' . esc_attr($cnt) . '" class="accordion-collapse collapse" aria-labelledby="dps-accordion-head-' . esc_attr($dpsCnt) . '-' . esc_attr($cnt) . '" data-bs-parent="#dps-accordion-' . esc_attr($dpsCnt) . '">';
			$output .= '    <div class="accordion-body">';
			$output .= wp_kses_post(str_replace("\n", '<br>', $rawText));
			$output .= '    </div>';
			$output .= '  </div>';
			$output .= '</div>';
		} else {
			$tag = empty($atts["wrapper"]) ? 'li' : 'div';
			$output = '<' . esc_attr($tag) . ' class="d-flex">';
			if ($img) {
				$output .= '<div class="flex-shrink-0 me-3">';
				$output .= '  <img style="max-height:' . esc_attr($max_height) . 'px" class="me-3" src="' . esc_url($img) . '" alt="' . esc_attr($alt) . '">';
				$output .= '</div>';
			}
			$output .= '  <div class="flex-grow-1">';
			$output .= '    <h3 class="mt-0 mb-1 dps-title' . (!empty($atts['title-class']) ? " " . esc_attr($atts['title-class']) : "") . '">' . esc_html( get_the_title() ) . '</h3>';
			$output .= '    <p class="dps-text' . (!empty($atts['text-class']) ? " " . esc_attr($atts['text-class']) : "") . '">' . wp_kses_post(str_replace("\n", '<br>', $rawText)) .  '</p>';
			$output .= '  </div>';
			$output .= '</' . esc_attr($tag) . '>';	
		}
		
		return $output;
	}
}

if (!function_exists('ujcf_dps_option_output_events')) {
	function ujcf_dps_option_output_events($output, $atts) {
		global $post;

		$cnt = ujcf_static_dps_item_counter();
		$dpsCnt = ujcf_static_dps_counter();
		$type = $atts['post_type'];
		if (empty($type)) {
			return ($output);
		}
		
		$defaultImage = wp_get_attachment_image_url(ujcf_get_theme_option($type . '_image'));
		$defaultAlt = "Generic " . $type . " image";

		$meta = get_post_meta($post->ID);

		if (!empty($defaultImage)) {
			$img = wp_get_attachment_image_url($meta["image"][0], 'thumbnail');
			if (!$img) {
				$img = $defaultImage;
			}
			$alt = get_post_meta($meta["image"][0], '_wp_attachment_image_alt', true);
			if (!$alt) {
				$alt = $defaultAlt;
			}
			$max_height = intval($atts["max_height"] ?? 50);
		} else {
			$img = null;
		}
		$text = do_shortcode($meta["text"][0] ?? '');

		$start = date('m/d/Y', strtotime($meta["start_date"][0]));
		if (!empty($meta["end_date"][0])) {
			$end = date('m/d/Y', strtotime($meta["end_date"][0]));
		} else {
			$end = null;
		}

		$txt_img = wp_get_attachment_image_url($meta["text_image"][0], 'medium');
		$txt_alt = "";
		if ($img) {
			$txt_alt = get_post_meta($meta["text_image"][0], '_wp_attachment_image_alt', true);
		}

		if (!empty($atts['wrapper'] ) && 'carousel' === $atts['wrapper']) {
			$output = ' <div class="carousel-item' . ($cnt == 1 ? ' active' : '') . '">';
			$output .= '<div class="d-flex">';
			if ($img) {
				$output .= '<div class="flex-shrink-0 me-3">';
				$output .= '  <img style="max-height:' . esc_attr($max_height) . 'px" class="me-3" src="' . esc_url($img) . '" alt="' . esc_attr($alt) . '">';
				$output .= '</div>';
			}
			$output .= '  <div class="flex-grow-1">';
			$output .= '    <h3 class="mt-0 mb-1 dps-title' . (!empty($atts['title-class']) ? " " . esc_attr($atts['title-class']) : "") . '">' . esc_html( get_the_title() ) . '</h3>';
			$output .= '<p style="opacity:0.8">' . $start . ($end ? " - " . $end : "") . '</p>';
			if ($txt_img) {
				$output .= '<div class="">';
				$output .= '		<img class="size-medium float-end ps-2" src="' . esc_url($txt_img) . '" alt="' . esc_attr($txt_alt) . '">';
			}
			$output .= '<p>' . wp_kses_post(str_replace("\n", '<br>', $text)) . '</p>';
			if ($txt_img) {
				$output .= '</div>';
			}

			$output .= '  </div>';
			$output .= '</div>';	
			$output .= '</div>';	
		} else 	if (!empty( $atts['wrapper'] ) && 'accordion' === $atts['wrapper']) {
			$output  = '<div class="accordion-item">';
			$output .= '    <h3 id="dps-accordion-head-' . esc_attr($dpsCnt) . '-' . esc_attr($cnt) . '" class="accordion-header' . (!empty($atts['title-class']) ? " " . esc_attr($atts['title-class']) : "") . '">';
			$output .= '      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#dps-accordion-collapse-' . esc_attr($dpsCnt) . '-' . esc_attr($cnt) . '" aria-expanded="false" aria-controls="dps-accordion-collapse-' . esc_attr($dpsCnt) . '-' . esc_attr($cnt) . '">';
			if ($img) {
				$output .= '  <img style="max-height:' . $max_height . 'px" class="me-3 accordion-image" src="' . esc_url($img) . '" alt="' . esc_attr($alt) . '">';
			}
			$output .= '<div style="white-space: normal">';
			$output .= esc_html(get_the_title());
			$output .= '<br><span class="small" style="opacity:0.8">';
			$output .= $start . ($end ? " - " . $end : "");
			$output .= '</span></div>';
			$output .= '      </button>';
			$output .= '    </h3>';
			$output .= '  <div id="dps-accordion-collapse-' . esc_attr($dpsCnt) . '-' . esc_attr($cnt) . '" class="accordion-collapse collapse" aria-labelledby="dps-accordion-head-' . esc_attr($dpsCnt) . '-' . esc_attr($cnt) . '" data-bs-parent="#dps-accordion-' . esc_attr($dpsCnt) . '">';
			$output .= '    <div class="accordion-body">';

			if ($txt_img) {
				$output .= '<img class="size-medium float-end ps-2" src="' . esc_url($txt_img) . '" alt="' . esc_attr($txt_alt) . '">';
			}
			$output .= '<p>' . wp_kses_post(str_replace("\n", '<br>', $text)) . '</p>';

			$output .= '  </div>';
			$output .= '</div>';
			$output .= '</div>';
		} else {
			$tag = empty($atts["wrapper"]) ? 'li' : 'div';
			$output = '<' . esc_attr($tag) . ' class="d-flex">';
			if ($img) {
				$output .= '<div class="flex-shrink-0 me-3">';
				$output .= '  <img style="max-height:' . esc_attr($max_height) . 'px" class="me-3" src="' . esc_url($img) . '" alt="' . esc_attr($alt) . '">';
				$output .= '</div>';
			}
			$output .= '  <div class="flex-grow-1">';
			$output .= '    <h3 class="mt-0 mb-2 dps-title' . (!empty($atts['title-class']) ? " " . esc_attr($atts['title-class']) : "") . '">';

			$output .= esc_html(get_the_title());
			$output .= '<br><span class="small" style="opacity:0.8">';
			$output .= $start . ($end ? " - " . $end : "");
			$output .= '</span>';
			$output .= '</h3>';

			if ($txt_img) {
				$output .= '<div class="">';
				$output .= '		<img class="size-medium float-end ps-2" src="' . esc_url($txt_img) . '" alt="' . esc_attr($txt_alt) . '">';
			}
			$output .= wp_kses_post(str_replace("\n", '<br>', $text));
			if ($txt_img) {
				$output .= '</div>';
			}
			$output .= '  </div>';
			$output .= '</' . esc_attr($tag) . '>';	
		}
		
		return $output;
	}
}

if (!function_exists('ujcf_dps_option_output_testimonials')) {
	function ujcf_dps_option_output_testimonials($output, $atts) {
		global $post;
		$output = '';

		$cnt = ujcf_static_dps_item_counter();
		$dpsCnt = ujcf_static_dps_counter();

		$meta = get_post_meta($post->ID);
		$img = wp_get_attachment_image_url($meta["picture"][0], 'thumbnail');
		if (!$img) {
			if (!empty($meta["gender"][0]) && $meta["gender"][0] === 'female') {
				$img = wp_get_attachment_image_url(ujcf_get_theme_option('female_avatar_image'), 'thumbnail');
			} else {
				$img = wp_get_attachment_image_url(ujcf_get_theme_option('male_avatar_image'), 'thumbnail');
			}
		}
		$stars = ujcf_getStars($meta["stars"][0]);
		$size = !empty($atts["size"]) ? $atts["size"] : "large";
		$rawText = do_shortcode($meta["text"][0] ?? '');
		$rawText = str_replace("\n", '<br>', $rawText);
		$text = ujcf_wp_split_words( $rawText );
		$preText = '<i class="fas fa-quote-left pe-3"></i>';
		$postText = '<i class="fas fa-quote-right ps-3"></i>';

		if (!empty($atts['wrapper'] ) && 'carousel' === $atts['wrapper']) {
			$output .= ' <div class="carousel-item' . ($cnt == 1 ? ' active' : '') . '">';
		} else if (!empty( $atts['wrapper'] ) && 'accordion' === $atts['wrapper']) {
			$output .= '<div class="accordion-item">';
			$output .= '    <h3 id="dps-accordion-head-' . esc_attr($dpsCnt) . '-' . esc_attr($cnt) . '" class="accordion-header' . (!empty($atts['title-class']) ? " " . esc_attr($atts['title-class']) : "") . '">';
			$output .= '      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#dps-accordion-collapse-' . esc_attr($dpsCnt) . '-' . esc_attr($cnt) . '" aria-expanded="false" aria-controls="dps-accordion-collapse-' . esc_attr($dpsCnt) . '-' . esc_attr($cnt) . '">';
			$output .= '        <span class="me-3">' .  esc_html(get_the_title()) . '</span>' . wp_kses_post($stars);
			$output .= '      </button>';
			$output .= '    </h3>';
			$output .= '  <div id="dps-accordion-collapse-' . esc_attr($dpsCnt) . '-' . esc_attr($cnt) . '" class="accordion-collapse collapse" aria-labelledby="dps-accordion-head-' . esc_attr($dpsCnt) . '-' . esc_attr($cnt) . '" data-bs-parent="#dps-accordion-' . esc_attr($dpsCnt) . '">';
			$output .= '    <div class="accordion-body">';
		}

		$output .= '<div class="container testimonial p-4 mt-4 rounded-3 border border-dark bg-light">';
		$output .= '  <div class="row text-center ' . ($size == "large" ? "text-md-start" : "") . '">';
		$output .= '	<div class="col-12 ' . ($size == "large" ? "col-md-3" : "") . '">';
		$output .= '		<img style="max-height:150px" src="' . esc_url($img) . '" alt="Avatar" class="rounded-circle">';
		$output .= '	</div>';
		$output .= '	<div class="col-12 ' . ($size == "large" ? "col-md-9" : "") . '">';
		$output .= '		<p><span class="lead fw-normal me-3">' . esc_html(get_the_title()) . '</span><br>' . wp_kses_post(str_replace("\n", '<br>', $meta["title"][0])) . '</p>';
		$output .= '		<p>' . wp_kses_post($stars) . '</p>';
		if (!empty($atts['wrapper'] ) && 'carousel' === $atts['wrapper']) {
			$output .= ujcf_print_more_text($text, $dpsCnt, $cnt, $preText, $postText);
		} else {
			$output .= $preText . wp_kses_post($rawText) . $postText;
		}
		$output .= '	</div>';
		$output .= '  </div>';
		$output .= '</div>';

		if (!empty($atts['wrapper'] ) && 'carousel' === $atts['wrapper']) {
			$output .= ujcf_print_more_script($text, $dpsCnt, $cnt);
		}

		if (!empty($atts['wrapper'] ) && 'carousel' === $atts['wrapper']) {
			$output .= '</div>';
		} else if (!empty( $atts['wrapper'] ) && 'accordion' === $atts['wrapper']) {
			$output .= '    </div>';
			$output .= '  </div>';
			$output .= '</div>';
		}

		return $output;
	}
}

if (!function_exists('ujcf_get_icon')) {
	function ujcf_get_icon($tags) {
		$icons = '';

		if ($tags) {
			foreach($tags as $tag) {
				if ($tag->name == "Download") {
					$icons .= '<i class="fas fa-paperclip fa-2x me-2" aria-hidden="true"></i>';
				}

				if ($tag->name == "Event") {
					$icons .= '<i class="far fa-calendar-alt fa-2x me-2" aria-hidden="true"></i>';
				}

				if ($tag->name == "Info") {
					$icons .= '<i class="fa fa-info fa-2x me-2" aria-hidden="true"></i>';
				}

				if ($tag->name == "Shoot") {
					$icons .= '<i class="fas fa-bullseye fa-2x me-2" aria-hidden="true"></i>';
				}

				if ($tag->name == "Meeting") {
					$icons .= '<i class="fas fa-user-clock fa-2x me-2" aria-hidden="true"></i>';
				}

				if ($tag->name == "Workparty") {
					$icons .= '<i class="fas fa-tools fa-2x me-2" aria-hidden="true"></i>';
				}
			}
		}

		return $icons;
	}
}

if (!function_exists('ujcf_getStars')) {
	function ujcf_getStars($stars) {
		$output = '';

		if (!empty($stars) && $stars >= 1 && $stars <= 5) {
			$num = $stars;
		} else {
			$num = 5;
		}

		for ($i = 1; $i <= 5; $i++) {
			if ($i <= $num) {
				$output .= '<span class="fa fa-star me-0" style="color: gold!important;"></span>';
			} else if ($i > $num && ($i -1) < $num) {
				$output .= '<span class="fas fa-star-half-alt me-0" style="color: gold!important;"></span>';
			} else {
				$output .= '<span class="far fa-star me-0"></span>';
			}
		}

		return $output;
	}
}

if (!function_exists('ujcf_showCalendarMonth')) {
	function ujcf_showCalendarMonth($atts, $month, $year) {
		$cnt = ujcf_static_dps_item_counter();
		$dpsCnt = ujcf_static_dps_counter();

		$bookingTypes = [];
		$output = '';
		$date = mktime(12, 0, 0, $month, 1, $year);
		$numberOfDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
		$offset = date("w", $date);
		$row_number = 1;
		$ujcf_booking_dates = ujcf_static_booking_dates();

		if (!empty($atts['wrapper'] ) && 'carousel' === $atts['wrapper']) {
			$output .= '<div class="carousel-item' . ($cnt == 1 ? ' active' : '') . '">';
		} else 	if (!empty( $atts['wrapper'] ) && 'accordion' === $atts['wrapper']) {
			$output .= '<div class="accordion-item">';
			$output .= '    <h3 id="dps-accordion-head-' . esc_attr($dpsCnt) . '-' . esc_attr($cnt) . '" class="accordion-header' . (!empty($atts['title-class']) ? " " . esc_attr($atts['title-class']) : "") . '">';
			$output .= '      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#dps-accordion-collapse-' . esc_attr($dpsCnt) . '-' . esc_attr($cnt) . '" aria-expanded="false" aria-controls="dps-accordion-collapse-' . esc_attr($dpsCnt) . '-' . esc_attr($cnt) . '">';
			$output .= '<i class="far fa-calendar-alt fa-2x me-3"></i>';
			$output .= esc_html(date_i18n("F", mktime(0, 0, 0, $month, 1))) . ' ' . esc_html($year);
			$output .= '      </button>';
			$output .= '    </h3>';
			$output .= '  <div id="dps-accordion-collapse-' . esc_attr($dpsCnt) . '-' . esc_attr($cnt) . '" class="accordion-collapse collapse" aria-labelledby="dps-accordion-head-' . esc_attr($dpsCnt) . '-' . esc_attr($cnt) . '" data-bs-parent="#dps-accordion-' . esc_attr($dpsCnt) . '">';
			$output .= '    <div class="accordion-body">';
		}

		$output .= '<div class="calendar-table text-center">';
		$output .= '<h4>' . esc_html(date_i18n("F", mktime(0, 0, 0, $month, 1))) . ' ' . esc_html($year) . '</h4>';
		$output .= '<table class="table-bordered thead-light">';
		$output .= '<thead>';
		$output .= '<tr><th>'.esc_html__("Sun", 'uj-core-functionality').'</th><th>'.esc_html__("Mon", 'uj-core-functionality').'</th><th>'.esc_html__("Tue", 'uj-core-functionality').'</th><th>'.esc_html__("Wed", 'uj-core-functionality').'</th><th>'.esc_html__("Thu", 'uj-core-functionality').'</th><th>'.esc_html__("Fri", 'uj-core-functionality').'</th><th>'.esc_html__("Sat", 'uj-core-functionality').'</th></tr>';
		$output .= '</thead>';
		$output .= '<tbody>';
		$output .= '<tr>';

		for($i = 1; $i <= $offset; $i++) {
			$output .= '<td></td>';
		}

		$special_rate_period = intval(ujcf_get_theme_option('special_rate_period'));
		if ($special_rate_period > 0) {
			$start = date('Y-m-d');
			$end = date('Y-m-d', strtotime($start . "+" . $special_rate_period . " days"));
		} else {
			$start = 0;
			$end = 0;
		}

		for ($day = 1; $day <= $numberOfDays; $day++) {
			if( ($day + $offset - 1) % 7 == 0 && $day != 1) {
				$output .= '</tr><tr>';
				$row_number++;
			}
			$index = $year . '-' . str_pad($month, 2, 0, STR_PAD_LEFT) . '-' . str_pad($day, 2, 0, STR_PAD_LEFT);
			$class = !empty($ujcf_booking_dates[$index]) ? ' class="calendar-' . esc_attr($ujcf_booking_dates[$index]) . '"' : '';
			$title = !empty($ujcf_booking_dates[$index]) ? ' title="' . esc_attr(ucwords($ujcf_booking_dates[$index])) . '"' : '';
			if (!empty($ujcf_booking_dates[$index])) {
				$bookingTypes[$ujcf_booking_dates[$index]] = true;
			}
			if (empty($class)) {
				if ($index >= $start && $index <= $end) {
					$class = ' class="calendar-special"';
					$title = ' title="' . esc_html__("Special Rates", 'uj-core-functionality') . '"';
					$bookingTypes["special"] = true;
				}
			}

			$output .= '<td' . $class . $title . '>' . esc_html($day) . '</td>';
		}
		while( ($day + $offset) <= $row_number * 7) {
			$output .= '<td></td>';
			$day++;
		}
		$output .= '</tr></tbody></table>';
		$output .= '<div class="d-flex justify-content-center flex-wrap">';
		if (!empty($bookingTypes["inquiry"])) {
			$output .= '<div class="m-2 calendar-legend calendar-inquiry">Inquiry</div>';
		}
		if (!empty($bookingTypes["tentative"])) {
			$output .= '<div class="m-2 calendar-legend calendar-tentative">Tentative</div>';
		}
		if (!empty($bookingTypes["booked"])) {
			$output .= '<div class="m-2 calendar-legend calendar-booked">Booked</div>';
		}
		if (!empty($bookingTypes["event"])) {
			$output .= '<div class="m-2 calendar-legend calendar-event">Event</div>';
		}
		if (!empty($bookingTypes["holiday"])) {
			$output .= '<div class="m-2 calendar-legend calendar-holiday">Holiday</div>';
		}
		if (!empty($bookingTypes["special"])) {
			$output .= '<div class="m-2 calendar-legend calendar-special">Special Rate</div>';
		}
		$output .= '</div>';

		$output .= '</div>';

		if (!empty($atts['wrapper'] ) && 'carousel' === $atts['wrapper']) {
			$output .= '</div>';
		} else 	if (!empty( $atts['wrapper'] ) && 'accordion' === $atts['wrapper']) {
			$output .= '    </div>';
			$output .= '  </div>';
			$output .= '</div>';
		}
		
		return $output;
	}
}

if (!function_exists('ujcf_dps_option_output_alerts')) {
	function ujcf_dps_option_output_alerts($output, $atts) {
		global $post;
		$output = '';
		
		$meta = get_post_meta($post->ID);
		$theme_alert_bg_color = ujcf_get_theme_option('alert_bg_color');
		if (empty($theme_alert_bg_color)) {
			$theme_alert_bg_color = 'danger';
		}
		
		if (!empty($meta["color"][0]) && $meta["color"][0] != 'default') {
			$theme_alert_bg_color = $meta["color"][0];
		}

		if (!empty($meta["text"][0])) {
			$output = '<div class="alert alert-' . esc_attr($theme_alert_bg_color) . '">' . esc_html($meta["text"][0]) . '</div>';
		}

		return $output;
	}
}

if (!function_exists('ujcf_static_booking_dates')) {
	function ujcf_static_booking_dates($ujcf_new_booking_dates = null) {
		static $ujcf_booking_dates;
		if ($ujcf_new_booking_dates !== null) {
			$ujcf_booking_dates = $ujcf_new_booking_dates;
		}
		
		return $ujcf_booking_dates;
	}
}

if (!function_exists('ujcf_static_dps_counter')) {
	function ujcf_static_dps_counter($ujcf_new_carousel_counter = null) {
		static $ujcf_carousel_counter = 1;
		if ($ujcf_new_carousel_counter !== null) {
			$ujcf_carousel_counter = $ujcf_new_carousel_counter;
		}
		
		return $ujcf_carousel_counter;
	}
}

if (!function_exists('ujcf_increment_static_dps_counter')) {
	function ujcf_increment_static_dps_counter( $out, $pairs, $atts ) {
		static $dpsCnt = 0;
		
		ujcf_static_dps_counter(++$dpsCnt);
		
		return $out;
	}

	add_filter( 'shortcode_atts_display-posts', 'ujcf_increment_static_dps_counter', 10, 3 );
}

if (!function_exists('ujcf_static_dps_item_counter')) {
	function ujcf_static_dps_item_counter($ujcf_new_item_counter = null) {
		static $ujcf_item_counter = 0;

		if ($ujcf_new_item_counter !== null) {
			$ujcf_item_counter = $ujcf_new_item_counter;
		}
		
		return $ujcf_item_counter++;
	}
}

if (!function_exists('ujcf_reset_static_dps_item_counter')) {
	function ujcf_reset_static_dps_item_counter( $out, $pairs, $atts ) {
		ujcf_static_dps_item_counter(0);
		
		return $out;
	}

	add_filter( 'shortcode_atts_display-posts', 'ujcf_reset_static_dps_item_counter', 10, 3 );
}

if( ! function_exists( 'ujcf_wp_split_words' ) ){
    /**
     * Split a string based on word count
     *
     * This is similar to WordPress wp_trim_words function, but instead of just trimming after a certain amount of
     * words, this function returns an array with 'before' and 'after' keys -- providing you the string of text up
     * to the number of words (in before key), and the words after (in the after key).  After key will be empty string
     * if there are less words in the passed string than number of words to split on.
     *
     *
     * @param string    $text
     * @param int       $num_words
     *
     * @return array    Array with `before` and `after` keys. The `before` key contains all words up to $num_words, the
     *                  `after` key contains the words after $num_words (or empty string if passed string has less words
     *                  than passed in $text)
     *
     */
    function ujcf_wp_split_words( $text, $num_words = 55 ) {
        $text = wp_strip_all_tags( $text );
        /*
         * translators: If your word count is based on single characters (e.g. East Asian characters),
         * enter 'characters_excluding_spaces' or 'characters_including_spaces'. Otherwise, enter 'words'.
         * Do not translate into your own language.
         */
        if ( strpos( _x( 'words', 'Word count type. Do not translate!' ), 'characters' ) === 0 && preg_match( '/^utf\-?8$/i', get_option( 'blog_charset' ) ) ) {
            $text = trim( preg_replace( "/[\n\r\t ]+/", ' ', $text ), ' ' );
            preg_match_all( '/./u', $text, $words_array_matches );
            $words_array = $words_array_matches[0];
            $sep         = '';
        } else {
            $words_array = preg_split( "/[\n\r\t ]+/", $text, -1, PREG_SPLIT_NO_EMPTY );
            $sep         = ' ';
        }
        if ( count( $words_array ) > $num_words ) {
            $before = implode( $sep, array_slice( $words_array, 0, $num_words ) );
            $after  = implode( $sep, array_slice( $words_array, $num_words, count( $words_array ) - 1 ) );
        } else {
            $before = implode( $sep, $words_array );
        }
        $results = array(
            'before' => $before,
            'after' => isset( $after ) ? $after : ''
        );
        return $results;
    }
}

if( ! function_exists( 'ujcf_print_more_text' ) ){
	function ujcf_print_more_text($text, $dpsCnt, $cnt, $preText = '', $postText = '') {
		$output = '';
		$output .= '<p class="dps-text' . (!empty($atts['text-class']) ? " " . esc_attr($atts['text-class']) : "") . '">';
		$output .= $preText . wp_kses_post($text["before"]);
		if (!empty($text["after"])) {
			$output .= '<span id="dps-read-more-text-' . esc_attr($dpsCnt) . '-' . esc_attr($cnt) . '" style="display:none;">';
			$output .= wp_kses_post($text["after"]) . $postText;
			$output	.= '</span><span id="dps-dots-' . esc_attr($dpsCnt) . '-' . esc_attr($cnt) . '">...</span>';
			$output .= ' <button class="button" onclick="dps_read_more_' . esc_attr($dpsCnt) . '_' . esc_attr($cnt) . '()">read ';
			$output .= '<span id="dps-read-more-btn-' . esc_attr($dpsCnt) . '-' . esc_attr($cnt) . '">more</span>';
			$output .= '</button>';
		} else {
			$output .= $postText;
		}
		$output .= '</p>';

		return $output;
	}
}

if( ! function_exists( 'ujcf_print_more_script' ) ){
	function ujcf_print_more_script($text, $dpsCnt, $cnt) {
		$output = '';

		if (!empty($text["after"])) {
			$output .= '<script>';
			$output .= 'function dps_read_more_' . esc_attr($dpsCnt) . '_' . esc_attr($cnt) . '() {';
			$output .= '  var dots = document.getElementById("dps-dots-' . esc_attr($dpsCnt) . '-' . esc_attr($cnt) . '");';
			$output .= '  var moreText = document.getElementById("dps-read-more-text-' . esc_attr($dpsCnt) . '-' . esc_attr($cnt) . '");';
			$output .= '  var btnText = document.getElementById("dps-read-more-btn-' . esc_attr($dpsCnt) . '-' . esc_attr($cnt) . '");';
			$output .= '  if (moreText.style.display === "none") {';
			$output .= '    dots.style.display = "none";';
			$output .= '    btnText.innerHTML = "less";';
			$output .= '    moreText.style.display = "inline";';
			$output .= '  } else {';
			$output .= '    dots.style.display = "inline";';
			$output .= '    btnText.innerHTML = "more";';
			$output .= '    moreText.style.display = "none";';
			$output .= '  }';
			$output .= '  setCarouselHeight' . esc_attr($dpsCnt) . '("#dps-carousel-' . esc_attr($dpsCnt) . '");';
			$output .= '}';
			$output .= '</script>';
		}

		return $output;
	}
}
