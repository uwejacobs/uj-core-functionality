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

        $atts = shortcode_atts(
                array(
					'post_type'             => '',
					'wrapper'               => '',
					'wrapper_id'            => '',
					'wrapper_class'         => 'display-posts-listing',
					'arrow_color_class'     => 'dark',
					'carousel_width'        => 70,
					'carousel_dots'         => true,
					'interval'              => 5000,
                ),
                $atts
        );

        $type              = sanitize_text_field( $atts['post_type'] );
        $wrapper           = sanitize_text_field( $atts['wrapper'] );
        $wrapper_id        = sanitize_text_field( $atts['wrapper_id'] );
		$wrapper_class     = implode( ' ', array_map( 'sanitize_html_class', explode( ' ', $atts['wrapper_class'] ) ) );
		$wrapper_class     = trim($wrapper_class . ' ' . $type);
		$arrow_color_class = 'bg-' . sanitize_text_field( $atts['arrow_color_class'] );
		$interval          = (int)$atts['interval'];
		$carousel_dots     = filter_var( $atts['carousel_dots'], FILTER_VALIDATE_BOOLEAN );
		$carousel_width    = (int)$atts['carousel_width'];
		if ($carousel_width < 0 || $carousel_width > 100) {
			$carousel_width = 70;
		}

		$dpsID = ujcf_static_dps_id();

		$indicator_cnt = $dps_listing->post_count;
		
		$wrapper = getDefaultWrapper($wrapper, $type);

		if ('booking' === $type) {
			ujcf_static_booking_dates();
			$indicator_cnt = 12;
		}

		if ('contact' === $type) {
			$id = !empty($wrapper_id) ? ' id="' . esc_attr($wrapper_id) . '"' : '';
			if (in_array($wrapper, array("div", "ul", "ol"))) {
				$output = '<' . esc_attr($wrapper) . esc_attr($id) . ' class="' . esc_attr($wrapper_class) . '">';
			} else if ($wrapper == "vertical-card") {
				$output = '<div' . esc_attr($id) . ' class="' . esc_attr($wrapper_class) . '">';
			} else if ($wrapper == "raised-image") {
				$output = '<div' . esc_attr($id) . ' class="row g-4 mt-5 ' . esc_attr($wrapper_class) . '">';
			} else {
				$output = '<div' . esc_attr($id) . ' class="row g-4 ' . esc_attr($wrapper_class) . '">';
			}

			return $output;
		}

		if ('carousel' === $wrapper) {
			$output = '<style type="text/css">';
			$output .= '#dps-carousel-' . esc_attr($dpsID) . ' .carousel-indicators {';
			$output .= '  position: absolute;';
			$output .= '}';
			$output .= '#dps-carousel-' . esc_attr($dpsID) . ' .carousel-inner {';
			$output .= '  width: ' . esc_attr($carousel_width) . '%;';
			$output .= '}';
			$output .= '</style>';
			$output .= '<div id="dps-carousel-' . esc_attr($dpsID) . '" class="carousel slide ' . esc_attr($wrapper_class) . '" data-bs-ride="carousel" data-bs-interval="'.$interval.'">';
			if ($carousel_dots) {
				$output .= '    <ol class="carousel-indicators">';

				for ($i = 0; $i < $indicator_cnt; $i++) {
					$output .= '        <li data-bs-target="#dps-carousel-' . esc_attr($dpsID) . '" data-bs-slide-to="' . esc_attr($i) . '" class="' . esc_attr($arrow_color_class) . (!$i ? ' active' : '') . '"></li>';
				}

				$output .= '    </ol>';
			}
			$output .= '    <div class="carousel-inner m-auto">';
		} else if ('accordion' === $wrapper) {
			$output = '<div id="dps-accordion-' . esc_attr($dpsID) . '" class="accordion ' . esc_attr($wrapper_class) . '">';
		} else {
			$output = '<' . esc_attr($wrapper) . (!empty($wrapper_id) ? ' id="' . esc_attr($wrapper_id) . '"' : '') . ' class="' . esc_attr($wrapper_class) . '">';
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

		$original_atts = $atts;

        $atts = shortcode_atts(
                array(
					'post_type'             => '',
					'wrapper'               => '',
					'arrow_color_class'     => 'dark',
					'left_arrow'            => true,
					'right_arrow'           => true,
                ),
                $atts
        );

        $type              = sanitize_text_field( $atts['post_type'] );
        $wrapper           = sanitize_text_field( $atts['wrapper'] );
		$arrow_color_class = 'text-' . sanitize_text_field( $atts['arrow_color_class'] );
		$left_arrow        = filter_var( $atts['left_arrow'], FILTER_VALIDATE_BOOLEAN );
		$right_arrow       = filter_var( $atts['right_arrow'], FILTER_VALIDATE_BOOLEAN );

		$dpsID = ujcf_static_dps_id();
		$addlOutput = '';

		$wrapper = getDefaultWrapper($wrapper, $type);

		if ('booking' === $type) {
			$start = new DateTime();
			$end = new DateTime();
			$end = $end->modify( '+1 year' );
			$interval = new DateInterval('P1M');
			$period = new DatePeriod($start, $interval, $end);

			foreach ($period as $dt) {
				$addlOutput .= ujcf_showCalendarMonth($original_atts, $dt->format("m"), $dt->format("Y"));
			}
		}


		if ('carousel' === $wrapper) {
			$output = '</div>';
			if ($left_arrow) {
				$output .= '    <a class="carousel-control-prev" href="#dps-carousel-' . esc_attr($dpsID) . '" role="button" data-bs-slide="prev">';
				$output .= '        <i class="fas fa-chevron-circle-left fa-3x ' . esc_attr($arrow_color_class) . '" aria-hidden="true"></i>';
				$output .= '        <span class="sr-only">Previous</span>';
				$output .= '    </a>';
			}
			if ($right_arrow) {
				$output .= '<a class="carousel-control-next" href="#dps-carousel-' . esc_attr($dpsID) . '" role="button" data-bs-slide="next">';
				$output .= '        <i class="fas fa-chevron-circle-right fa-3x ' . esc_attr($arrow_color_class) . '" aria-hidden="true"></i>';
				$output .= '    <span class="sr-only">Next</span>';
				$output .= '</a>';
			}
			$output .= '</div>';
			$output .= '<script>';
			$output .= '    jQuery(window).resize(function () {';
			$output .= '        setCarouselHeight' . esc_attr($dpsID) . '("#dps-carousel-' . esc_attr($dpsID) . '");';
			$output .= '    });';
			$output .= '    jQuery(document).ready(function () {';
			$output .= '        jQuery(window).trigger("resize");';
			$output .= '    });';
			$output .= '    jQuery("#dps-carousel-' . esc_attr($dpsID) . '").bind("slide.bs.carousel", function () {';
			$output .= '        jQuery(window).trigger("resize");';
			$output .= '    });';
			$output .= '    function setCarouselHeight' . esc_attr($dpsID) . '(id) {';
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
		} else if ('accordion' === $wrapper) {
			$output = '</div>';
		} else {
			if (in_array($wrapper, array("ul", "ol"))) {
				$output = '</' . esc_attr($wrapper) . '>';
			} else {
				$output = '</div>';
			}
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

		$original_atts = $atts;

        $atts = shortcode_atts(
                array(
					'post_type'             => '',
					'layout'                => false,
                ),
                $atts
        );

        $type      = sanitize_text_field( $atts['post_type'] );
        $layout    = sanitize_text_field( $atts['layout'] );

		if (!empty($layout)) {
			ob_start();
			$ret = get_template_part('template-parts/dps', $layout);
			$new_output = ob_get_clean();
			if (!empty($new_output)) {
				$output = $new_output;
			}
		} else if (!empty($type)) {
			switch($type) {
				case 'testimonial':
					$new_output = ujcf_dps_option_output_testimonials($output, $original_atts);
					if (!empty($new_output)) {
						$output = $new_output;
					}
					break;
				case 'booking':
					if (!empty(get_field("start_date")) && !empty(get_field("status"))) {
						$start = new DateTime(get_field("start_date"));
						if (empty(get_field("end_date"))) {
							$end = new DateTime(get_field("start_date"));
						} else {
							$end = new DateTime(get_field("end_date"));
						}

						$end = $end->modify( '+1 day' );
						$interval = new DateInterval('P1D');
						$period = new DatePeriod($start, $interval, $end);

						$ujcf_booking_dates = ujcf_static_booking_dates();
						foreach ($period as $dt) {
							if (empty($ujcf_booking_dates[$dt->format("Y-m-d")])) {
								$ujcf_booking_dates[$dt->format("Y-m-d")] = [];
							}
							$ujcf_booking_dates[$dt->format("Y-m-d")][] = get_field("status");
						}
						ujcf_static_booking_dates($ujcf_booking_dates);
					}

					$output = '';
					break;
				case 'alert':
					$new_output = ujcf_dps_option_output_alerts($output, $original_atts);
					if (!empty($new_output)) {
						$output = $new_output;
					}
					break;
				case 'faq':
				case 'fundraiser':
				case 'news':
					$new_output = ujcf_dps_option_output_image_and_text($output, $original_atts);
					if (!empty($new_output)) {
						$output = $new_output;
					}
					break;
				case 'event':
					$new_output = ujcf_dps_option_output_image_and_text($output, $original_atts, true);
					if (!empty($new_output)) {
						$output = $new_output;
					}
					break;
				case 'contact':
					$new_output = ujcf_dps_option_output_contact($output, $original_atts);
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

if (!function_exists('ujcf_dps_option_output_image_and_text')) {
	function ujcf_dps_option_output_image_and_text($output, $atts, $date_flag = false) {
		global $post;

		$original_atts = $atts;

        $atts = shortcode_atts(
                array(
					'post_type'             => '',
					'listing_class'         => 'listing-item',
					'content_class'         => 'content',
					'icon_class'            => 'icon',
					'title_class'           => 'title',
					'date_class'            => 'date',
					'image_class'           => 'image',
					'icon_max_height'		=> 50,
					'image_size'            => 'medium',
					'wrapper'               => '',
                    'include_title'         => true,
                    'include_date'          => true,
					'include_icon'          => true,
					'include_image'         => true,
                    'include_content'       => true,
					'read_more'             => true,
                    'date_format'           => 'm/d/Y',
                    'time_format'           => 'g:i a',
                ),
                $atts
        );

        $type            = sanitize_text_field( $atts['post_type'] );
        $wrapper         = sanitize_text_field( $atts['wrapper'] );
		$listing_class   = implode( ' ', array_map( 'sanitize_html_class', explode( ' ', $atts['listing_class'] ) ) );
		$content_class   = implode( ' ', array_map( 'sanitize_html_class', explode( ' ', $atts['content_class'] ) ) );
		$icon_class      = implode( ' ', array_map( 'sanitize_html_class', explode( ' ', $atts['icon_class'] ) ) );
		$title_class     = implode( ' ', array_map( 'sanitize_html_class', explode( ' ', $atts['title_class'] ) ) );
		$date_class      = implode( ' ', array_map( 'sanitize_html_class', explode( ' ', $atts['date_class'] ) ) );
		$image_class     = implode( ' ', array_map( 'sanitize_html_class', explode( ' ', $atts['image_class'] ) ) );
		$icon_max_height = (int) $atts['icon_max_height'];
        $image_size      = sanitize_text_field( $atts['image_size'] );
        $include_title   = filter_var( $atts['include_title'], FILTER_VALIDATE_BOOLEAN );
        $include_date    = filter_var( $atts['include_date'], FILTER_VALIDATE_BOOLEAN );
        $include_icon    = filter_var( $atts['include_icon'], FILTER_VALIDATE_BOOLEAN );
        $include_image   = filter_var( $atts['include_image'], FILTER_VALIDATE_BOOLEAN );
        $include_content = filter_var( $atts['include_content'], FILTER_VALIDATE_BOOLEAN );
        $read_more       = filter_var( $atts['read_more'], FILTER_VALIDATE_BOOLEAN );
        $date_format     = sanitize_text_field( $atts['date_format'] );
        $time_format     = sanitize_text_field( $atts['time_format'] );

		if (empty($type)) {
			return ($output);
		}

		$cnt = ujcf_static_dps_item_counter();
		$dpsID = ujcf_static_dps_id();

		$wrapper = getDefaultWrapper($wrapper, $type);

		$defaultImage = wp_get_attachment_image_url(ujcf_get_theme_option($type . '_image'));
		$defaultAlt = "Generic " . $type . " image";

		if (!empty($defaultImage)) {
			$icon = wp_get_attachment_image_url(get_field("image"), 'thumbnail');
			if (!$icon) {
				$icon = $defaultImage;
			}
			$icon_alt = get_post_meta(get_field("image"), '_wp_attachment_image_alt', true);
			if (!$icon_alt) {
				$icon_alt = $defaultAlt;
			}
		} else {
			$icon = null;
		}
		$rawText = ujcf_wysiswygFormat(get_field("text"));
		$text = get_extended($rawText);

		if ($date_flag) {
			$event_date = ujcf_formatDateLine($atts);
		}

		$image = wp_get_attachment_image_url(get_field("_thumbnail_id"), $image_size);
		$image_alt = "";
		if ($image) {
			$image_alt = get_post_meta(get_field("_thumbnail_id"), '_wp_attachment_image_alt', true);
		}

		if (get_field("image_position") == "right") {
			$image_class .= " float-sm-end ps-3 pb-3";
		} else {
			$image_class .= " float-sm-start pe-3 pb-3";
		}

		if ('carousel' === $wrapper) {
			$output  = '<div class="carousel-item ' . esc_attr($listing_class) . ($cnt == 1 ? ' active' : '') . '">';
			$output .= '<div class="d-md-flex d-inline">';
			if ($icon && $include_icon) {
				$output .= '<img style="max-height:' . esc_attr($icon_max_height) . 'px" class="me-3 ' . esc_attr($icon_class) . '" src="' . esc_url($icon) . '" alt="' . esc_attr($icon_alt) . '">';
			}
			$output .= '<div>';
			if ($include_title) {
				$output .= '<h3 class="mt-0 mb-1 ' . esc_attr($title_class) . '">' . esc_html(get_the_title()) . '</h3>';
			}
			if ($date_flag && $include_date) {
				$output .= '<small class="fs-4 text-muted ' . esc_attr($date_class) . '">' . esc_html($event_date) . '</small>';
			}
			$output .= '</div>';
			$output .= '</div>';	
			if ($image && $include_image) {
				$output .= '<div>';
				$output .= '    <img class="image size-medium ' . esc_attr($image_class) . '" src="' . esc_url($image) . '" alt="' . esc_attr($image_alt) . '">';
			}
			if ($include_content) {
				if ($read_more) {
					$output .= ujcf_print_more_text($text, $content_class, $dpsID, $cnt);
				} else {
					$output .= '<p class="' . esc_attr($content_class) . '">' . wp_kses_post($rawText) . '</p>';
				}
			}
			$output .= '</div>';	
			if ($image && $include_image) {
				$output .= '</div>';
				$output .= '<div class="clearfix"></div>';
			}
			if ($read_more) {
				$output .= ujcf_print_more_script($text, $dpsID, $cnt);
			}
		} else 	if ('accordion' === $wrapper) {
			$output  = '<div class="accordion-item ' . esc_attr($listing_class) . '">';
			$output .= '<h3 id="dps-accordion-head-' . esc_attr($dpsID) . '-' . esc_attr($cnt) . '" class="accordion-header">';
			$output .= '<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#dps-accordion-collapse-' . esc_attr($dpsID) . '-' . esc_attr($cnt) . '" aria-expanded="false" aria-controls="dps-accordion-collapse-' . esc_attr($dpsID) . '-' . esc_attr($cnt) . '">';
			if ($icon && $include_icon) {
				$output .= '<img style="max-height:' . esc_attr($icon_max_height) . 'px" class="accordion-image me-3 ' . esc_attr($icon_class) . '" src="' . esc_url($icon) . '" alt="' . esc_attr($icon_alt) . '">';
			}
			$output .= '<div style="white-space: normal">';
			if ($include_title) {
				$output .= '<span class="fs-4 ' . esc_attr($title_class) . '">' . esc_html(get_the_title()) . '</span>';
			}
			if ($date_flag && $include_date) {
				$output .= '<br clear="none"/><small class="fs-5 text-muted ' . esc_attr($date_class) . '">' . esc_html($event_date) . '</small>';
			}
			$output .= '</div>';
			$output .= '</button>';
			$output .= '</h3>';
			$output .= '<div id="dps-accordion-collapse-' . esc_attr($dpsID) . '-' . esc_attr($cnt) . '" class="accordion-collapse collapse" aria-labelledby="dps-accordion-head-' . esc_attr($dpsID) . '-' . esc_attr($cnt) . '" data-bs-parent="#dps-accordion-' . esc_attr($dpsID) . '">';
			$output .= '<div class="accordion-body">';
			if ($image && $include_image) {
				$output .= '<img class="image size-medium ' . esc_attr($image_class) . '" src="' . esc_url($image) . '" alt="' . esc_attr($image_alt) . '">';
			}
			if ($include_content) {
				$output .= '<div class="' . esc_attr($content_class) . '">' . wp_kses_post($rawText) . '</div>';
			}
			$output .= '</div>';
			if ($image && $include_image) {
				$output .= '<div class="clearfix"></div>';
			}
			$output .= '</div>';
			$output .= '</div>';
		} else {
			$sub_wrapper = in_array($wrapper, array("ol", "ul")) ? 'li' : $wrapper;
			$output = '<' . esc_attr($sub_wrapper) . ' class="d-md-flex d-inline ' . esc_attr($listing_class) . '">';
			if ($icon && $include_icon) {
				$output .= '<img style="max-height:' . esc_attr($icon_max_height) . 'px" class="me-3 ' . esc_attr($icon_class) . '" src="' . esc_url($icon) . '" alt="' . esc_attr($icon_alt) . '">';
			}
			$output .= '<div class="w-100">';
			$output .= '<h3 class="mt-0 mb-2 ' . esc_attr($title_class) . '">';
			if ($include_title) {
				$output .= esc_html(get_the_title());
			}
			if ($date_flag && $include_date) {
				$output .= '<br clear="none"/><small class="fs-4 text-muted ' . esc_attr($date_class) . '">' . esc_html($event_date) . '</small>';
			}
			$output .= '</h3>';

			if ($image && $include_image) {
				$output .= '<div>';
				$output .= '<img class="size-medium ' . esc_attr($image_class) . '" src="' . esc_url($image) . '" alt="' . esc_attr($image_alt) . '">';
			}
			if ($include_content) {
				$output .= '<div class="' . esc_attr($content_class) . '">' . wp_kses_post($rawText) . '</div>';
			}
			$output .= '  </div>';
			if ($image && $include_image) {
				$output .= '</div>';
				$output .= '<div class="clearfix"></div>';
			}
			$output .= '</' . esc_attr($sub_wrapper) . '>';	
		}
		
		return $output;
	}
}

if (!function_exists('ujcf_dps_option_output_contact')) {
	function ujcf_dps_option_output_contact($output, $atts) {
		global $post;
		
		$original_atts = $atts;

        $atts = shortcode_atts(
                array(
					'listing_class'         => 'listing-item',
					'content_class'         => 'content',
					'name_class'            => 'name',
					'position_class'        => 'position',
					'image_class'           => 'image',
					'text_class'            => 'text',
					'image_max_height'		=> 150,
					'image_max_width'		=> 150,
					'image_size'            => 'medium',
					'max_width'             => 0,
					'wrapper'               => '',
					'include_name'          => true,
					'include_position'      => true,
					'include_text'          => true,
					'include_image'         => true,
					'include_content'       => true,
					'include_social'        => true,
                ),
                $atts
        );

        $wrapper           = sanitize_text_field( $atts['wrapper'] );
		$listing_class     = implode( ' ', array_map( 'sanitize_html_class', explode( ' ', $atts['listing_class'] ) ) );
		$content_class     = implode( ' ', array_map( 'sanitize_html_class', explode( ' ', $atts['content_class'] ) ) );
		$name_class        = implode( ' ', array_map( 'sanitize_html_class', explode( ' ', $atts['name_class'] ) ) );
		$position_class    = implode( ' ', array_map( 'sanitize_html_class', explode( ' ', $atts['position_class'] ) ) );
		$image_class       = implode( ' ', array_map( 'sanitize_html_class', explode( ' ', $atts['image_class'] ) ) );
		$text_class        = implode( ' ', array_map( 'sanitize_html_class', explode( ' ', $atts['text_class'] ) ) );
		$image_max_height  = (int) $atts['image_max_height'];
		$image_max_width   = (int) $atts['image_max_width'];
        $image_size        = sanitize_text_field( $atts['image_size'] );
		$max_width         = (int) $atts['max_width'];
        $include_name      = filter_var( $atts['include_name'], FILTER_VALIDATE_BOOLEAN );
        $include_position  = filter_var( $atts['include_position'], FILTER_VALIDATE_BOOLEAN );
        $include_text      = filter_var( $atts['include_text'], FILTER_VALIDATE_BOOLEAN );
        $include_image     = filter_var( $atts['include_image'], FILTER_VALIDATE_BOOLEAN );
        $include_content   = filter_var( $atts['include_content'], FILTER_VALIDATE_BOOLEAN );
        $include_social    = filter_var( $atts['include_social'], FILTER_VALIDATE_BOOLEAN );
		
		$cnt = ujcf_static_dps_item_counter();
		$dpsID = ujcf_static_dps_id();

		$wrapper = getDefaultWrapper($wrapper, "contact");

		if ($wrapper == "round-image" || $wrapper == 'raised-image') {
			$image_size = 'thumbnail';
		}

		$image = wp_get_attachment_image_url(get_field("_thumbnail_id"), $image_size);
		$alt = "";
		if ($image) {
			$alt = get_post_meta(get_field("_thumbnail_id"), '_wp_attachment_image_alt', true);
		}

		if ($wrapper == "card") {
			if ($max_width <= 0) {
				$max_width = 300;
			}
			$output  = '<div class="col-12 col-sm-6 col-md-4 col-lg-3 g-4 ' . esc_attr($listing_class) . '">';
			$output .= '    <div class="card h-100" style="max-width:' . esc_attr($max_width) . 'px;">';
			if ($include_image) {
				$output .= '      <img src="' . esc_url($image) . '" class="card-img-top ' . esc_attr($image_class) . '" alt="' . esc_attr($alt) . '">';
			}
			if ($include_content) {
				$output .= '      <div class="card-body ' . esc_attr($content_class) . '">';
				if ($include_position) {
					$output .= '        <h5 class="card-title ' . esc_attr($position_class) . '">' . esc_html(get_field("position")) . '</h5>';
				}
				if ($include_name) {
					$output .= '        <p class="card-text ' . esc_attr($name_class) . '">' . esc_html(get_the_title()) . '</p>';
				}
				if ($include_text) {
					$output .= '        <p class="card-text ' . esc_attr($text_class) . '">' . wp_kses_post(ujcf_wysiswygFormat(get_field("text"))) . '</p>';
				}
				$output .= '      </div>';
			}
			$output .= '    <div class="card-footer text-center">';
			$output .= ujcf_printSocialIcons($original_atts);
			$output .= '    </div>';
			$output .= '    </div>';
			$output .= '</div>';
		} else if ($wrapper == "vertical-card") {
			if ($max_width <= 0) {
				$max_width = 540;
			}
			$output = '<div class="card ' . esc_attr($listing_class) . '" style="max-width:' . esc_attr($max_width) . 'px;">';
			$output .= '  <div class="row g-0">';
			if ($include_image) {
				$output .= '    <div class="col-md-4">';
				$output .= '      <img src="' . esc_url($image) . '" class="img-responsive rounded-start ' . esc_attr($image_class) . '" alt="' . esc_attr($alt) . '">';
				$output .= '    </div>';
			}
			$output .= '    <div' . ($include_image ? ' class="col-md-8"' : '') . '>';
			if ($include_content) {
				$output .= '      <div class="card-body ' . esc_attr($content_class) . '">';
				if ($include_position) {
					$output .= '        <h5 class="card-title ' . esc_attr($position_class) . '">' . esc_html(get_field("position")) . '</h5>';
				}
				if ($include_name) {
					$output .= '        <p class="card-text ' . esc_attr($name_class) . '">' . esc_html(get_the_title()) . '</p>';
				}
				if ($include_text) {
					$output .= '        <p class="card-text ' . esc_attr($text_class) . '">' . wp_kses_post(ujcf_wysiswygFormat(get_field("text"))) . '</p>';
				}
				$output .= ujcf_printSocialIcons($original_atts);
				$output .= '      </div>';
			}
			$output .= '    </div>';
			$output .= '  </div>';
			$output .= '</div>';
		} else if ($wrapper == "round-image") {
			$output  = '<div class="col-12 col-sm-6 col-md-4 col-lg-3 g-4 ' . esc_attr($listing_class) . '">';
			$output .= '    <div class="card text-center h-100">';
			if ($include_image) {
				$output .= '        <img src="' . esc_url($image) . '" class="img-responsive mx-auto pt-2 rounded-circle ' . esc_attr($image_class) . '" alt="' . esc_attr($alt) . '" style="width:' . esc_attr($image_max_width) . 'px; height:' . esc_attr($image_max_height) . 'px;">';
			}
			if ($include_content) {
				$output .= '      <div class="card-body ' . esc_attr($content_class) . '">';
				if ($include_position) {
					$output .= '        <h5 class="card-title ' . esc_attr($position_class) . '">' . esc_html(get_field("position")) . '</h5>';
				}
				if ($include_name) {
					$output .= '        <p class="card-text ' . esc_attr($name_class) . '">' . esc_html(get_the_title()) . '</p>';
				}
				if ($include_text) {
					$output .= '        <p class="card-text ' . esc_attr($text_class) . '">' . wp_kses_post(ujcf_wysiswygFormat(get_field("text"))) . '</p>';
				}
				$output .= '      </div>';
			}
			$output .= '    <div class="card-footer text-center">';
			$output .= ujcf_printSocialIcons($original_atts);
			$output .= '    </div>';
			$output .= '    </div>';
			$output .= '</div>';
		} else if ($wrapper == "raised-image") {
			$top = intval($image_max_height / 2);

			$output = '<div class="col-12 col-sm-6 col-md-4 col-lg-3 mt-5 ' . esc_attr($listing_class) . '" style="margin-bottom: ' . esc_attr($top) . 'px;">';
			$output .= '	<div class="card border-0 shadow-lg pt-5 position-relative h-100">';
			$output .= '		<div class="card-body p-4">';
			if ($include_image) {
				$output .= '			<div class="position-absolute w-100 text-center" style="top: -' . esc_attr($top) . 'px; left: 0;">';
				$output .= '				<img class="rounded-circle mx-auto d-inline-block shadow-sm ' . esc_attr($image_class) . '" src="' . esc_url($image) . '" alt="' . esc_attr($alt) . '" style="width:' . esc_attr($image_max_width) . 'px; height:' . esc_attr($image_max_height) . 'px;">';
				$output .= '			</div>';
			}
			if ($include_content) {
				$output .= '			<div class="card-text pt-3 ' . esc_attr($content_class) . '">';
				if ($include_name) {
					$output .= '				<h5 class="mb-0 text-center text-primary font-weight-bold ' . esc_attr($name_class) . '">' . esc_html(get_the_title()) . '</h5>';
				}
				if ($include_position) {
					$output .= '				<div class="mb-3 text-center fw-bold ' . esc_attr($position_class) . '">' . esc_html(get_field("position")) . '</div>';
				}
				if ($include_text) {
					$output .= '				<div class="mb-3 text-center ' . esc_attr($text_class) . '">' . wp_kses_post(ujcf_wysiswygFormat(get_field("text"))) . '</div>';
				}
				$output .= '			</div>';
			}
			$output .= '		</div>';
			$output .= '		<div class="card-footer theme-bg-primary border-0 text-center">';
			$output .= ujcf_printSocialIcons($original_atts);
			$output .= '		</div>';
			$output .= '	</div>';
			$output .= '</div>';
		}

		return $output;
	}
}

if (!function_exists('ujcf_printSocialIcons')) {
	function ujcf_printSocialIcons($atts) {
        $atts = shortcode_atts(
                array(
					'include_social'         => true,
					'include_email'          => true,
					'include_phone'          => true,
					'social_listing_class'   => 'social-list',
					'social_item_class'      => 'social-item social',
					'email_class'            => 'social-item email',
					'phone_class'            => 'social-item phone',
                ),
                $atts
        );

        $include_social       = filter_var( $atts['include_social'], FILTER_VALIDATE_BOOLEAN );
        $include_email        = filter_var( $atts['include_email'], FILTER_VALIDATE_BOOLEAN );
        $include_phone        = filter_var( $atts['include_phone'], FILTER_VALIDATE_BOOLEAN );
		$social_listing_class = implode( ' ', array_map( 'sanitize_html_class', explode( ' ', $atts['social_listing_class'] ) ) );
		$social_item_class    = implode( ' ', array_map( 'sanitize_html_class', explode( ' ', $atts['social_item_class'] ) ) );
		$email_class          = implode( ' ', array_map( 'sanitize_html_class', explode( ' ', $atts['email_class'] ) ) );
		$phone_class          = implode( ' ', array_map( 'sanitize_html_class', explode( ' ', $atts['phone_class'] ) ) );

		$output = '';
		if ($include_email || $include_phone || $include_social) {
			$output .= '<ul class="list-inline mb-0 mx-auto ' . esc_attr($social_listing_class) . '">';
		}
		if ($include_email) {
			$email = get_field("email");
			if (!empty($email)) {
				$output .= '<li class="list-inline-item ' . esc_attr($social_item_class) . ' ' . esc_attr($email_class) . '"><a class="text-dark" href="mailto:'. esc_attr(antispambot($email)) .'"><i class="fas fa-envelope fa-fw"></i></a></li>';
			}
		}
		if ($include_phone) {
			$phone = get_field("phone");
			if (!empty($phone)) {
				$output .= '<li class="list-inline-item ' . esc_attr($social_item_class) . ' ' . esc_attr($phone_class) . '"><a class="text-dark" href="tel:' . esc_attr(preg_replace('/[^0-9]/', '', $phone)) . '"><i class="fas fa-phone fa-fw"></i></a></li>';
			}
		}
		if ($include_social) {
			$twitter_url = get_field("twitter_url");
			if (!empty($twitter_url)) {
				$output .= '<li class="list-inline-item ' . esc_attr($social_item_class) . '"><a class="text-dark" href="' . esc_url($twitter_url) . '"><i class="fab fa-twitter fa-fw"></i></a></li>';
			}
			$facebook_url = get_field("facebook_url");
			if (!empty($facebook_url)) {
				$output .= '<li class="list-inline-item ' . esc_attr($social_item_class) . '"><a class="text-dark" href="' . esc_url($facebook_url) . '"><i class="fab fa-facebook-f fa-fw"></i></a></li>';
			}
			$instagram_url = get_field("instagram_url");
			if (!empty($instagram_url)) {
				$output .= '<li class="list-inline-item ' . esc_attr($social_item_class) . '"><a class="text-dark" href="' . esc_url($instagram_url) . '"><i class="fab fa-instagram fa-fw"></i></a></li>';
			}
			$linkedin_url = get_field("linkedin_url");
			if (!empty($linkedin_url)) {
				$output .= '<li class="list-inline-item ' . esc_attr($social_item_class) . '"><a class="text-dark" href="' . esc_url($linkedin_url) . '"><i class="fab fa-linkedin fa-fw"></i></a></li>';
			}
		}
		if ($include_email || $include_phone || $include_social) {
			$output .= '</ul>';
		}

		return $output;
	}
}

if (!function_exists('ujcf_formatDateLine')) {
	function ujcf_formatDateLine($atts) {
        $atts = shortcode_atts(
                array(
                    'date_format' => 'm/d/Y',
                    'time_format' => 'g:i a',
                ),
                $atts
        );

        $date_format     = sanitize_text_field( $atts['date_format'] );
        $time_format     = sanitize_text_field( $atts['time_format'] );

		$timestamp = strtotime(get_field("start_date"));

		$sDate = date($date_format, $timestamp);
		$sTime = date($time_format, $timestamp);
		$sTime_comp = date('g:i a', $timestamp);

		$end_date = get_field("end_date");
		if (!empty($end_date)) {
			$timestamp = strtotime($end_date);
			$eDate = date($date_format, $timestamp);
			$eTime = date($time_format, $timestamp);
			$eTime_comp = date('g:i a', $timestamp);
		} else {
			$eDate = null;
		}

		$output = $sDate;
		$output .= $sTime_comp == "12:00 am" ? "" : " " . $sTime;

		if ($eDate && (($eDate != $sDate) || ($eDate == $sDate && $eTime != $sTime))) {
			$output .= " - ";
			if ($eDate != $sDate) {
				$output .= $eDate . " ";
			}
			if ($eTime != $sTime && $eTime_comp != "12:00 am") {
				$output .= $eTime;
			}
		}

		return $output;
	}
}

if (!function_exists('ujcf_dps_option_output_testimonials')) {
	function ujcf_dps_option_output_testimonials($output, $atts) {
		global $post;

        $atts = shortcode_atts(
                array(
					'size'					=> 'large',
					'content_class'         => 'content',
					'listing_class'         => 'listing-item',
					'title_class'           => 'title',
					'job_title_class'       => 'job-title',
					'image_class'           => 'image',
					'text_class'            => 'text',
					'image_max_height'		=> 150,
					'wrapper'               => '',
					'include_title'         => true,
					'include_job_title'     => true,
					'include_stars'         => true,
					'include_image'         => true,
					'include_review_date'   => true,
					'include_content'       => true,
					'read_more'             => true,
                    'date_format'           => 'm/d/Y',
                ),
                $atts
        );

        $size                = sanitize_text_field( $atts['size'] );
        $wrapper             = sanitize_text_field( $atts['wrapper'] );
		$listing_class       = implode( ' ', array_map( 'sanitize_html_class', explode( ' ', $atts['listing_class'] ) ) );
		$content_class       = implode( ' ', array_map( 'sanitize_html_class', explode( ' ', $atts['content_class'] ) ) );
		$title_class         = implode( ' ', array_map( 'sanitize_html_class', explode( ' ', $atts['title_class'] ) ) );
		$job_title_class     = implode( ' ', array_map( 'sanitize_html_class', explode( ' ', $atts['job_title_class'] ) ) );
		$image_class         = implode( ' ', array_map( 'sanitize_html_class', explode( ' ', $atts['image_class'] ) ) );
		$text_class          = implode( ' ', array_map( 'sanitize_html_class', explode( ' ', $atts['text_class'] ) ) );
		$image_max_height    = (int) $atts['image_max_height'];
        $include_title       = filter_var( $atts['include_title'], FILTER_VALIDATE_BOOLEAN );
        $include_job_title   = filter_var( $atts['include_job_title'], FILTER_VALIDATE_BOOLEAN );
        $include_stars       = filter_var( $atts['include_stars'], FILTER_VALIDATE_BOOLEAN );
        $include_image       = filter_var( $atts['include_image'], FILTER_VALIDATE_BOOLEAN );
        $include_review_date = filter_var( $atts['include_image'], FILTER_VALIDATE_BOOLEAN );
        $include_content     = filter_var( $atts['include_content'], FILTER_VALIDATE_BOOLEAN );
        $read_more           = filter_var( $atts['read_more'], FILTER_VALIDATE_BOOLEAN );
        $date_format         = sanitize_text_field( $atts['date_format'] );

		$output = '';

		$cnt = ujcf_static_dps_item_counter();
		$dpsID = ujcf_static_dps_id();

		$wrapper = getDefaultWrapper($wrapper, "testimonial");

		$img = wp_get_attachment_image_url(get_field("picture"), 'thumbnail');
		if (!$img) {
			if (!empty(get_field("gender")) && get_field("gender") === 'female') {
				$img = wp_get_attachment_image_url(ujcf_get_theme_option('female_avatar_image'), 'thumbnail');
			} else {
				$img = wp_get_attachment_image_url(ujcf_get_theme_option('male_avatar_image'), 'thumbnail');
			}
		}
		$stars = ujcf_getStars(get_field("stars"));
		$rawText = ujcf_wysiswygFormat(get_field("text"));
		$text = get_extended($rawText);
		$preText = '<i class="fas fa-quote-left pe-3"></i>';
		$postText = '<i class="fas fa-quote-right ps-3"></i>';
		$reviewDate = date($date_format, strtotime(get_field("review_date")));

		if ('carousel' === $wrapper) {
			$output .= '<div class="carousel-item ' . esc_attr($listing_class) . ($cnt == 1 ? ' active' : '') . '">';
		} else if ('accordion' === $wrapper) {
			$output .= '<div class="accordion-item ' . esc_attr($listing_class) . '">';
			$output .= '<h3 id="dps-accordion-head-' . esc_attr($dpsID) . '-' . esc_attr($cnt) . '" class="accordion-header">';
			$output .= '<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#dps-accordion-collapse-' . esc_attr($dpsID) . '-' . esc_attr($cnt) . '" aria-expanded="false" aria-controls="dps-accordion-collapse-' . esc_attr($dpsID) . '-' . esc_attr($cnt) . '">';
			$output .= '<span class="me-3 ' . esc_attr($title_class) . '">' .  esc_html(get_the_title()) . '</span>';
			if ($include_stars) {
				$output .= wp_kses_post($stars);
			}
			$output .= '</button>';
			$output .= '</h3>';
			$output .= '<div id="dps-accordion-collapse-' . esc_attr($dpsID) . '-' . esc_attr($cnt) . '" class="accordion-collapse collapse" aria-labelledby="dps-accordion-head-' . esc_attr($dpsID) . '-' . esc_attr($cnt) . '" data-bs-parent="#dps-accordion-' . esc_attr($dpsID) . '">';
			$output .= '    <div class="accordion-body">';
		}

		$output .= '<div class="container testimonial p-4 mt-4 rounded-3 border border-dark bg-light">';
		$output .= '<div class="row text-center ' . ($size == "large" ? "text-md-start" : "") . '">';
		if ($include_image) {
			$output .= '<div class="col-12 ' . ($size == "large" ? "col-md-3" : "") . '">';
			$output .= '<img style="max-height:' . $image_max_height . 'px" src="' . esc_url($img) . '" alt="Avatar" class="rounded-circle ' . esc_attr($image_class) . '">';
			$output .= '</div>';
		}
		$output .= '<div class="col-12' . ($size == "large" && $include_image ? " col-md-9" : "") . '">';
		if ($include_title) {
			$output .= '<p><span class="lead fw-normal me-3 ' . esc_attr($title_class) . '">' . esc_html(get_the_title()) . '</span>';
		}
		if ($include_job_title) {
			$output .= '<br clear="none"/><span class="' . esc_attr($job_title_class) . '">' . wp_kses_post(ujcf_wysiswygFormat(get_field("title"))) . '</span>';
		}
		$output .= '</p>';
		if ($include_stars || ($include_review_date && $reviewDate != '01/01/1970')) {
			$output .= '<p>';
			if ($include_stars) {
				$output .= wp_kses_post($stars);
			}
			if ($include_review_date && $reviewDate != '01/01/1970') {
				$output .= '&nbsp;' . $reviewDate;
			}
			$output .= '</p>';
		}
		if ($include_content) {
			if ('carousel' === $wrapper && $read_more) {
				$output .= ujcf_print_more_text($text, $text_class, $dpsID, $cnt, $preText, $postText);
			} else {
				$output .= '<p class="' . esc_attr($text_class) . '">' . wp_kses_post($preText) . wp_kses_post($rawText) . wp_kses_post($postText) . '</p>';
			}
		}
		$output .= '</div>';
		$output .= '</div>';
		$output .= '</div>';

		if ('carousel' === $wrapper) {
			if ($read_more) {
				$output .= ujcf_print_more_script($text, $dpsID, $cnt);
			}
			$output .= '</div>';
		} else if ('accordion' === $wrapper) {
			$output .= '</div>';
			$output .= '</div>';
			$output .= '</div>';
		}

		return $output;
	}
}

if (!function_exists('ujcf_wysiswygFormat')) {
	function ujcf_wysiswygFormat($s) {
		$s = do_shortcode($s);
		$s = str_replace("li>\r\n", 'li>', $s);
		$s = str_replace("ul>\r\n", 'ul>', $s);
		$s = str_replace("ol>\r\n", 'ol>', $s);
		$s = str_replace("\r\n", '<br clear="none"/>', $s);
		$s = str_replace("\n", '<br clear="none"/>', $s);
		$s = ujcf_removeTags($s, array("p"));
		
		return $s;
	}
}

if (!function_exists('ujcf_removeTags')) {
	function ujcf_removeTags($htmlString, $htmlTags) 
	{
		$tagString = "";  
		foreach($htmlTags as $key => $value) { 
			$tagString .= $key == count($htmlTags)-1 ? $value : "{$value}|"; 
		}
		$pattern= array("/(<\s*\b({$tagString})\b[^>]*>)/i", "/(<\/\s*\b({$tagString})\b\s*>)/i");
		$result = preg_replace($pattern, "", $htmlString);
		return $result;
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
        $atts = shortcode_atts(
                array(
					'wrapper'               => '',
					'listing_class'         => 'listing-item',
					'content_class'         => 'calendar',
					'title_class'           => 'title',
					'legend_class'          => 'legend',
					'calendar_class'        => 'calendar-table',
					'calendar_item_class'   => 'calendar-table-item',
					'include_legend'        => true,
                ),
                $atts
        );

        $wrapper             = sanitize_text_field( $atts['wrapper'] );
		$listing_class       = implode( ' ', array_map( 'sanitize_html_class', explode( ' ', $atts['listing_class'] ) ) );
		$content_class       = implode( ' ', array_map( 'sanitize_html_class', explode( ' ', $atts['content_class'] ) ) );
		$title_class         = implode( ' ', array_map( 'sanitize_html_class', explode( ' ', $atts['title_class'] ) ) );
		$legend_class        = implode( ' ', array_map( 'sanitize_html_class', explode( ' ', $atts['legend_class'] ) ) );
		$calendar_class      = implode( ' ', array_map( 'sanitize_html_class', explode( ' ', $atts['calendar_class'] ) ) );
		$calendar_item_class = implode( ' ', array_map( 'sanitize_html_class', explode( ' ', $atts['calendar_item_class'] ) ) );
        $include_legend      = filter_var( $atts['include_legend'], FILTER_VALIDATE_BOOLEAN );

		$cnt = ujcf_static_dps_item_counter();
		$dpsID = ujcf_static_dps_id();

		$wrapper = getDefaultWrapper($wrapper, "booking");

		$bookingTypes = [];
		$date = mktime(12, 0, 0, $month, 1, $year);
		$numberOfDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
		$offset = date("w", $date);
		$row_number = 1;
		$ujcf_booking_dates = ujcf_static_booking_dates();

		$output = '';
		if ('carousel' === $wrapper) {
			$output .= '<div class="carousel-item ' . esc_attr($listing_class) . ($cnt == 1 ? ' active' : '') . '">';
		} else 	if ('accordion' === $wrapper) {
			$output .= '<div class="accordion-item ' . esc_attr($listing_class) . '">';
			$output .= '    <h3 id="dps-accordion-head-' . esc_attr($dpsID) . '-' . esc_attr($cnt) . '" class="accordion-header' . (!empty($atts['title_class']) ? " " . esc_attr($atts['title_class']) : "") . '">';
			$output .= '      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#dps-accordion-collapse-' . esc_attr($dpsID) . '-' . esc_attr($cnt) . '" aria-expanded="false" aria-controls="dps-accordion-collapse-' . esc_attr($dpsID) . '-' . esc_attr($cnt) . '">';
			$output .= '<i class="far fa-calendar-alt fa-2x me-3"></i>';
			$output .= esc_html(date_i18n("F", mktime(0, 0, 0, $month, 1))) . ' ' . esc_html($year);
			$output .= '      </button>';
			$output .= '    </h3>';
			$output .= '  <div id="dps-accordion-collapse-' . esc_attr($dpsID) . '-' . esc_attr($cnt) . '" class="accordion-collapse collapse" aria-labelledby="dps-accordion-head-' . esc_attr($dpsID) . '-' . esc_attr($cnt) . '" data-bs-parent="#dps-accordion-' . esc_attr($dpsID) . '">';
			$output .= '    <div class="accordion-body">';
		}

		$output .= '<div class="text-center ' . esc_attr($content_class) . '">';
		$output .= '<h4 class="' . esc_attr($title_class) . '">' . esc_html(date_i18n("F", mktime(0, 0, 0, $month, 1))) . ' ' . esc_html($year) . '</h4>';
		$output .= '<table class="table-bordered thead-light ' . esc_attr($calendar_class) . '">';
		$output .= '<thead>';
		$output .= '<tr><th>'.esc_html__("Sun", 'uj-core-functionality').'</th><th>'.esc_html__("Mon", 'uj-core-functionality').'</th><th>'.esc_html__("Tue", 'uj-core-functionality').'</th><th>'.esc_html__("Wed", 'uj-core-functionality').'</th><th>'.esc_html__("Thu", 'uj-core-functionality').'</th><th>'.esc_html__("Fri", 'uj-core-functionality').'</th><th>'.esc_html__("Sat", 'uj-core-functionality').'</th></tr>';
		$output .= '</thead>';
		$output .= '<tbody>';
		$output .= '<tr>';

		for($i = 1; $i <= $offset; $i++) {
			$output .= '<td class="' . esc_attr($calendar_item_class) . '"></td>';
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
			$class = '';
			$style = tableCellBackGround($ujcf_booking_dates[$index] ?? null);
			if (!empty($ujcf_booking_dates[$index])) {
				for($i = 0; $i < count($ujcf_booking_dates[$index]); $i++) {
					$bookingTypes[$ujcf_booking_dates[$index][$i]] = true;
				}
			}
			if (empty($style)) {
				if ($index >= $start && $index <= $end) {
					$class = 'calendar-special';
					$title = esc_html__("Special Rates", 'uj-core-functionality');
					$bookingTypes["special"] = true;
				}
			}

			$output .= '<td class="' . esc_attr($class) . ' ' . esc_attr($calendar_item_class) . '" ' . ($style) . '>' . esc_html($day) . '</td>';
		}

		while( ($day + $offset) <= $row_number * 7) {
			$output .= '<td class="' . esc_attr($calendar_item_class) . '"></td>';
			$day++;
		}

		$output .= '</tr></tbody></table>';

		if ($include_legend) {
			$output .= '<div class="d-flex justify-content-center flex-wrap ' . esc_attr($legend_class) . '">';
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
		}

		$output .= '</div>';

		if ('carousel' === $wrapper) {
			$output .= '</div>';
		} else 	if ('accordion' === $wrapper) {
			$output .= '</div>';
			$output .= '</div>';
			$output .= '</div>';
		}
		
		return $output;
	}
}

function tableCellBackGround($day) {
	if (empty($day)) {
		return '';
	}
	
	$day = array_unique($day);
	$cnt = count($day);
	
	$output = 'style="background: linear-gradient(to bottom';
	for($i = 0; $i < $cnt; $i++) {
		$color = ujcf_get_theme_option($day[$i] . '_color');
		$start = $i * (100 / $cnt);
		$end = ($i + 1) * (100 / $cnt);
		$output .= ',' .$color . ' ' . $start . '%, ' . $color . ' ' . $end . '%';
	}
	$output .= ');"';
	
	return $output;
}

if (!function_exists('ujcf_dps_option_output_alerts')) {
	function ujcf_dps_option_output_alerts($output, $atts) {
		global $post;
		$output = '';
		
		$theme_alert_bg_color = ujcf_get_theme_option('alert_bg_color');
		if (empty($theme_alert_bg_color)) {
			$theme_alert_bg_color = 'danger';
		}
		
		$color = get_field("color");
		if (!empty($color) && $color != 'default') {
			$theme_alert_bg_color = $color;
		}

		$text = get_field("text");
		if (!empty($text)) {
			$output = '<div class="alert alert-' . esc_attr($theme_alert_bg_color) . '">' . esc_html($text) . '</div>';
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

if (!function_exists('ujcf_static_dps_id')) {
	function ujcf_static_dps_id($ujcf_new_counter = null) {
		static $ujcf_counter = null;
		if ($ujcf_new_counter !== null) {
			$ujcf_counter = $ujcf_new_counter;
		}
		
		return $ujcf_counter;
	}
}

if (!function_exists('ujcf_set_static_dps_id')) {
	function ujcf_set_static_dps_id( $out, $pairs, $atts ) {
		ujcf_static_dps_id(uniqid());
		
		return $out;
	}

	add_filter( 'shortcode_atts_display-posts', 'ujcf_set_static_dps_id', 10, 3 );
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

if( ! function_exists( 'ujcf_print_more_text' ) ){
	function ujcf_print_more_text($text, $class, $dpsID, $cnt, $preText = '', $postText = '') {
		$output = '';
		$output .= '<p class="' . $class . '">';
		$output .= wp_kses_post($preText) . wp_kses_post($text["main"]);
		if (!empty($text["extended"])) {
			$output .= '<span id="read-more-text-' . esc_attr($dpsID) . '-' . esc_attr($cnt) . '" style="display:none;">';
			$output .= wp_kses_post($text["extended"]) . wp_kses_post($postText);
			$output	.= '</span>';
			$output .= ' <button class="button" onclick="dps_read_more_' . esc_attr($dpsID) . '_' . esc_attr($cnt) . '()">read ';
			$output .= '<span id="read-more-btn-' . esc_attr($dpsID) . '-' . esc_attr($cnt) . '">more</span>';
			$output .= '</button>';
		} else {
			$output .= wp_kses_post($postText);
		}
		$output .= '</p>';

		return $output;
	}
}

if( ! function_exists( 'ujcf_print_more_script' ) ){
	function ujcf_print_more_script($text, $dpsID, $cnt) {
		$output = '';

		if (!empty($text["extended"])) {
			$output .= '<script>';
			$output .= 'function dps_read_more_' . esc_attr($dpsID) . '_' . esc_attr($cnt) . '() {';
			$output .= '  var moreText = document.getElementById("read-more-text-' . esc_attr($dpsID) . '-' . esc_attr($cnt) . '");';
			$output .= '  var btnText = document.getElementById("read-more-btn-' . esc_attr($dpsID) . '-' . esc_attr($cnt) . '");';
			$output .= '  if (moreText.style.display === "none") {';
			$output .= '    btnText.innerHTML = "less";';
			$output .= '    moreText.style.display = "inline";';
			$output .= '  } else {';
			$output .= '    btnText.innerHTML = "more";';
			$output .= '    moreText.style.display = "none";';
			$output .= '  }';
			$output .= '  setCarouselHeight' . esc_attr($dpsID) . '("#dps-carousel-' . esc_attr($dpsID) . '");';
			$output .= '}';
			$output .= '</script>';
		}

		return $output;
	}
}

if( ! function_exists( 'getDefaultWrapper' ) ){
	function getDefaultWrapper($wrapper, $post_type) {
		if (!empty($wrapper)) {
			return $wrapper;
		}
		
		switch ($post_type) {
			case "alert":
				return "";
				
			case "booking":
				return "carousel";
				
			case "contact":
				return "card";
				
			case "testimonial":
				return "carousel";
				
			default:
				return "ul";
		}
	}
}
