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
			return '<div class="alert alert-danger">';
		}

		$interval = intval($atts["interval"] ?? 5000);

		if ( ! empty( $atts['wrapper'] ) && 'carousel' === $atts['wrapper'] ) {
			$arrow_class = (!empty($atts['arrow-color-class']) ? 'bg-' . $atts['arrow-color-class'] : "bg-dark");
			
			$output = '<style>';
			$output .= '#dps-carousel-' . esc_attr($dpsCnt) . ' .carousel-indicators {';
			$output .= '  position: absolute;';
			$output .= '  bottom: -50px;';
			$output .= '}';
			$output .= '#dps-carousel-' . esc_attr($dpsCnt) . ' .carousel-inner {';
			$output .= '  width: 70%;';
			$output .= '}';
			$output .= '</style>';
			$output .= '<div id="dps-carousel-' . esc_attr($dpsCnt) . '" class="carousel slide display-posts-listing mb-5" data-ride="carousel" data-interval="'.$interval.'">';
			$output .= '    <ol class="carousel-indicators">';

			for ($i = 0; $i < $indicator_cnt; $i++) {
				$output .= '        <li data-target="#dps-carousel-' . esc_attr($dpsCnt) . '" data-slide-to="' . esc_attr($i) . '" class="' . esc_attr($arrow_class) . (!$i ? ' active' : '') . '"></li>';
			}

			$output .= '    </ol>';
			$output .= '    <div class="carousel-inner m-auto">';
		} else if ( ! empty( $atts['wrapper'] ) && 'accordion' === $atts['wrapper'] ) {
			$output = '<div id="dps-accordion-' . esc_attr($dpsCnt) . '">';
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
			return '</div>';
		}

		if ( ! empty( $atts['wrapper'] ) && 'carousel' === $atts['wrapper'] ) {
			$output = '</div>';
			if (!isset($atts['left-arrow']) ||
			   (isset($atts['left-arrow']) && $atts['left-arrow'] === 'true')) {
				$arrow_class = (!empty($atts['arrow-color-class']) ? 'text-' . $atts['arrow-color-class'] : "text-dark");
				
				$output .= '    <a class="carousel-control-prev" href="#dps-carousel-' . esc_attr($dpsCnt) . '" role="button" data-slide="prev">';
				$output .= '        <i class="fas fa-chevron-circle-left fa-3x ' . esc_attr($arrow_class) . '" aria-hidden="true"></i>';
				$output .= '        <span class="sr-only">Previous</span>';
				$output .= '    </a>';
			}
			if (!isset($atts['right-arrow']) ||
			   (isset($atts['right-arrow']) && $atts['right-arrow'] === 'true')) {
				$output .= '<a class="carousel-control-next" href="#dps-carousel-' . esc_attr($dpsCnt) . '" role="button" data-slide="next">';
				$output .= '        <i class="fas fa-chevron-circle-right fa-3x ' . esc_attr($arrow_class) . '" aria-hidden="true"></i>';
				$output .= '    <span class="sr-only">Next</span>';
				$output .= '</a>';
			}
			$output .= '</div>';
			$output .= '<script>';
			$output .= '    jQuery(window).resize(function () {';
			$output .= '        setCarouselHeight' . esc_attr($dpsCnt) . '("#dps-carousel-' . esc_attr($dpsCnt) . '");';
			$output .= '    });';
			$output .= '    setCarouselHeight' . esc_attr($dpsCnt) . '("#dps-carousel-' . esc_attr($dpsCnt) . '");';
			$output .= '    function setCarouselHeight' . esc_attr($dpsCnt) . '(id) {';
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
			$output .= '   <h3 class="dps-title' . (!empty($atts['title-class']) ? " " . $atts['title-class'] : "") . '">' . $icon .  esc_html( get_the_title() ) . '</h3>';
			$output .= '   <p class="dps-text' . (!empty($atts['text-class']) ? " " . $atts['text-class'] : "") . '">' . apply_filters('the_content', get_post_field('post_content', $post->ID)) .  '</p></div>';
		} else 	if (!empty( $atts['wrapper'] ) && 'accordion' === $atts['wrapper']) {
			$output  = '<div class="card">';
			$output .= '  <div class="card-header" id="dps-accordion-head-' . esc_attr($dpsCnt) . '-' . esc_attr($cnt) . '">';
			$output .= '    <h3 class="mb-0 dps-title' . (!empty($atts['title-class']) ? " " . $atts['title-class'] : "") . '">';
			$output .= '      <button class="btn btn-block text-left" data-toggle="collapse" data-target="#dps-accordion-collapse-' . esc_attr($dpsCnt) . '-' . esc_attr($cnt) . '" aria-expanded="true" aria-controls="dps-accordion-collapse-' . esc_attr($dpsCnt) . '-' . esc_attr($cnt) . '">';
			$output .= '        <i class="fas fa-plus float-right"></i>' . wp_kses($icon, $icon_kses) .  esc_html(get_the_title());
			$output .= '      </button>';
			$output .= '    </h3>';
			$output .= '  </div>';
			$output .= '  <div id="dps-accordion-collapse-' . esc_attr($dpsCnt) . '-' . esc_attr($cnt) . '" class="collapse" aria-labelledby="dps-accordion-head-' . esc_attr($dpsCnt) . '-' . esc_attr($cnt) . '" data-parent="#dps-accordion-' . esc_attr($dpsCnt) . '">';
			$output .= '    <div class="card-body">';
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
		
		$defaultImage = wp_get_attachment_url(ujcf_get_theme_option($type . '_image'));
		$defaultAlt = "Generic " . $type . " image";

		$meta = get_post_meta($post->ID);
		
		if (!empty($defaultImage)) {
			$img = wp_get_attachment_url($meta["image"][0], 'thumbnail');
			if (!$img) {
				$img = $defaultImage;
			}
			$alt = get_post_meta($meta["image"][0], '_wp_attachment_image_alt', true);
			if (!$alt) {
				$alt = $defaultAlt;
			}
			$max_height = $atts["max_height"] ?? 50;
		} else {
			$img = null;
		}
		$text = $meta["text"][0] ?? '';

		if (!empty($atts['wrapper'] ) && 'carousel' === $atts['wrapper']) {
			$output = ' <div class="carousel-item' . ($cnt == 1 ? ' active' : '') . '">';
			$output .= '<div class="media">';
			if ($img) {
				$output .= '  <img style="max-height:' . $max_height . 'px" class="mr-3" src="' . $img . '" alt="' . $alt . '">';
			}
			$output .= '  <div class="media-body">';
			$output .= '    <h3 class="mt-0 mb-1 dps-title' . (!empty($atts['title-class']) ? " " . $atts['title-class'] : "") . '">' . esc_html( get_the_title() ) . '</h3>';
			$output .= '    <p class="dps-text' . (!empty($atts['text-class']) ? " " . $atts['text-class'] : "") . '">' . apply_filters('the_content', $text) .  '</p>';
			$output .= '  </div>';
			$output .= '</div>';	
			$output .= '</div>';	
		} else 	if (!empty( $atts['wrapper'] ) && 'accordion' === $atts['wrapper']) {
			$output  = '<div class="card">';
			$output .= '  <div class="card-header" id="dps-accordion-head-' . esc_attr($dpsCnt) . '-' . esc_attr($cnt) . '">';
			$output .= '    <h3 class="mb-0 dps-title' . (!empty($atts['title-class']) ? " " . $atts['title-class'] : "") . '">';
			$output .= '      <button class="btn btn-block text-left" data-toggle="collapse" data-target="#dps-accordion-collapse-' . esc_attr($dpsCnt) . '-' . esc_attr($cnt) . '" aria-expanded="true" aria-controls="dps-accordion-collapse-' . esc_attr($dpsCnt) . '-' . esc_attr($cnt) . '">';
			$output .= '        <i class="fas fa-plus float-right"></i>';
			if ($img) {
				$output .= '  <img style="max-height:' . $max_height . 'px" class="mr-3 accordion-image" src="' . $img . '" alt="' . $alt . '">';
			}
			$output .= esc_html(get_the_title());
			$output .= '      </button>';
			$output .= '    </h3>';
			$output .= '  </div>';
			$output .= '  <div id="dps-accordion-collapse-' . esc_attr($dpsCnt) . '-' . esc_attr($cnt) . '" class="collapse" aria-labelledby="dps-accordion-head-' . esc_attr($dpsCnt) . '-' . esc_attr($cnt) . '" data-parent="#dps-accordion-' . esc_attr($dpsCnt) . '">';
			$output .= '    <div class="card-body">';
			$output .= apply_filters('the_content', $text);
			$output .= '    </div>';
			$output .= '  </div>';
			$output .= '</div>';
		} else {
			$tag = empty($atts["wrapper"]) ? 'li' : 'div';
			$output = '<' . $tag . ' class="media">';
			if ($img) {
				$output .= '  <img style="max-height:' . $max_height . 'px" class="mr-3" src="' . $img . '" alt="' . $alt . '">';
			}
			$output .= '  <div class="media-body">';
			$output .= '    <h3 class="mt-0 mb-1 dps-title' . (!empty($atts['title-class']) ? " " . $atts['title-class'] : "") . '">' . esc_html( get_the_title() ) . '</h3>';
			$output .= '    <p class="dps-text' . (!empty($atts['text-class']) ? " " . $atts['text-class'] : "") . '">' . apply_filters('the_content', $text) .  '</p>';
			$output .= '  </div>';
			$output .= '</' . $tag . '>';	
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
		$img = wp_get_attachment_url($meta["picture"][0], 'thumbnail');
		if (!$img) {
			if ($meta["gender"][0] === 'female') {
				$img = wp_get_attachment_url(ujcf_get_theme_option('female_avatar_image'), 'thumbnail');
			} else {
				$img = wp_get_attachment_url(ujcf_get_theme_option('male_avatar_image'), 'thumbnail');
			}
		}
		$stars = ujcf_getStars($meta["stars"][0]);
		$size = !empty($atts["size"]) ? $atts["size"] : "large";

		if (!empty($atts['wrapper'] ) && 'carousel' === $atts['wrapper']) {
			$output .= ' <div class="carousel-item' . ($cnt == 1 ? ' active' : '') . '">';
		} else if (!empty( $atts['wrapper'] ) && 'accordion' === $atts['wrapper']) {
			$output .= '<div class="card">';
			$output .= '  <div class="card-header" id="dps-accordion-head-' . esc_attr($dpsCnt) . '-' . esc_attr($cnt) . '">';
			$output .= '    <h3 class="mb-0 dps-title' . (!empty($atts['title-class']) ? " " . $atts['title-class'] : "") . '">';
			$output .= '      <button class="btn btn-block text-left" data-toggle="collapse" data-target="#dps-accordion-collapse-' . esc_attr($dpsCnt) . '-' . esc_attr($cnt) . '" aria-expanded="true" aria-controls="dps-accordion-collapse-' . esc_attr($dpsCnt) . '-' . esc_attr($cnt) . '">';
			$output .= '        <i class="fas fa-plus float-right"></i><span class="mr-3">' .  esc_html(get_the_title()) . '</span>' . wp_kses_post($stars);
			$output .= '      </button>';
			$output .= '    </h3>';
			$output .= '  </div>';
			$output .= '  <div id="dps-accordion-collapse-' . esc_attr($dpsCnt) . '-' . esc_attr($cnt) . '" class="collapse" aria-labelledby="dps-accordion-head-' . esc_attr($dpsCnt) . '-' . esc_attr($cnt) . '" data-parent="#dps-accordion-' . esc_attr($dpsCnt) . '">';
			$output .= '    <div class="card-body">';
		}


		ob_start();
	?>
	<div class="container testimonial p-4 mt-4 rounded-lg border border-dark bg-light">
	  <div class="row text-center <?php echo ($size == "large" ? "text-md-left" : "") ?>">
		<div class="col-12 <?php echo ($size == "large" ? "col-md-3" : "") ?>">
			<img src="<?php echo esc_url($img) ?>" alt="Avatar" class="rounded-circle" style="width: 90px;">
		</div>
		<div class="col-12 <?php echo ($size == "large" ? "col-md-9" : "") ?>">
			<p><span class="lead font-weight-normal mr-3"><?php echo esc_html(get_the_title()) ?></span><?php echo "<br>" . wp_kses_post(nl2br($meta["title"][0])) ?></p>
			<p><?php echo wp_kses_post($stars) ?></p>
			<p><i class="fas fa-quote-left pr-3"></i><?php echo wp_kses_post(nl2br($meta["text"][0])) ?><i class="fas fa-quote-right pl-3"></i></p>
		</div>
	  </div>
	</div>
	<?php
		$output	.= ob_get_clean();

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
				$output .= '<span class="fa fa-star mr-0" style="color: gold!important;"></span>';
			} else if ($i > $num && ($i -1) < $num) {
				$output .= '<span class="fas fa-star-half-alt mr-0" style="color: gold!important;"></span>';
			} else {
				$output .= '<span class="far fa-star mr-0"></span>';
			}
		}

		return $output;
	}
}

if (!function_exists('ujcf_showCalendarMonth')) {
	function ujcf_showCalendarMonth($atts, $month, $year) {
		$cnt = ujcf_static_dps_item_counter();
		$dpsCnt = ujcf_static_dps_counter();

		$output = '';
		$date = mktime(12, 0, 0, $month, 1, $year);
		$numberOfDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
		$offset = date("w", $date);
		$row_number = 1;
		$ujcf_booking_dates = ujcf_static_booking_dates();

		if (!empty($atts['wrapper'] ) && 'carousel' === $atts['wrapper']) {
			$output .= '<div class="carousel-item' . ($cnt == 1 ? ' active' : '') . '">';
		} else 	if (!empty( $atts['wrapper'] ) && 'accordion' === $atts['wrapper']) {
			$output .= '<div class="card">';
			$output .= '  <div class="card-header" id="dps-accordion-head-' . esc_attr($dpsCnt) . '-' . esc_attr($cnt) . '">';
			$output .= '    <h3 class="mb-0 dps-title' . (!empty($atts['title-class']) ? " " . $atts['title-class'] : "") . '">';
			$output .= '      <button class="btn btn-block text-left" data-toggle="collapse" data-target="#dps-accordion-collapse-' . esc_attr($dpsCnt) . '-' . esc_attr($cnt) . '" aria-expanded="true" aria-controls="dps-accordion-collapse-' . esc_attr($dpsCnt) . '-' . esc_attr($cnt) . '">';
			$output .= '        <i class="fas fa-plus float-right"></i>';
			$output .= '<i class="far fa-calendar-alt fa-2x mr-3"></i>';
			$output .= esc_html(date_i18n("F", mktime(0, 0, 0, $month, 1))) . ' ' . esc_html($year);
			$output .= '      </button>';
			$output .= '    </h3>';
			$output .= '  </div>';
			$output .= '  <div id="dps-accordion-collapse-' . esc_attr($dpsCnt) . '-' . esc_attr($cnt) . '" class="collapse" aria-labelledby="dps-accordion-head-' . esc_attr($dpsCnt) . '-' . esc_attr($cnt) . '" data-parent="#dps-accordion-' . esc_attr($dpsCnt) . '">';
			$output .= '    <div class="card-body">';
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

		$start = date('Y-m-d');
		$end = date('Y-m-d', strtotime($start . "+21 days"));

		for($day = 1; $day <= $numberOfDays; $day++) {
			if( ($day + $offset - 1) % 7 == 0 && $day != 1) {
				$output .= '</tr><tr>';
				$row_number++;
			}
			$index = $year . '-' . str_pad($month, 2, 0, STR_PAD_LEFT) . '-' . str_pad($day, 2, 0, STR_PAD_LEFT);
			$class = !empty($ujcf_booking_dates[$index]) ? ' class="calendar-' . $ujcf_booking_dates[$index] . '"' : '';
			$title = !empty($ujcf_booking_dates[$index]) ? ' title="' . ucwords($ujcf_booking_dates[$index]) . '"' : '';
			if (empty($class)) {
				if ($index >= $start && $index <= $end) {
					$class = ' class="calendar-special"';
					$title = ' title="' . esc_html__("Special Rates", 'uj-core-functionality') . '"';
				}
			}

			$output .= '<td' . $class . $title . '>' . $day . '</td>';
		}
		while( ($day + $offset) <= $row_number * 7) {
			$output .= '<td></td>';
			$day++;
		}
		$output .= '</tr></tbody></table>';
 		$output .= '<p>';
 		$output .= '<span class="calendar-legend calendar-inquiry">Inquiry</span>';
  		$output .= '<span class="calendar-legend calendar-tentative">Tentative</span>';
  		$output .= '<span class="calendar-legend calendar-booked">Booked</span>';
  		$output .= '<span class="calendar-legend calendar-event">Event</span>';
  		$output .= '<span class="calendar-legend calendar-holiday">Holiday</span>';
  		$output .= '<span class="calendar-legend calendar-special">Special Rate</span>';
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

		if (!empty($meta["text"][0])) {
			$output = '<i class="fas fa-exclamation-triangle mr-2"></i>' . $meta["text"][0];
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