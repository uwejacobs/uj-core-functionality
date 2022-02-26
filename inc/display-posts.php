<?php
/**
 * Display Posts hooks
 *
 * @package    CoreFunctionality
 * @since      1.0.0
 * @copyright  Copyright (c) 2021, Uwe Jacobs
 * @license    GPL-2.0+
 */

/**
 * Display Posts, open
 *
 * @param string $output Output.
 * @param array  $atts Atttributes.
 */
function uj_dps_posts_open($output, $atts) {
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
            $output .= '        <li data-target="#dps_carousel" data-slide-to="' . $i . '" class="' . ($atts['arrow-color-class'] ? 'bg-' . $atts['arrow-color-class'] : "bg-dark") . (!$i ? ' active' : '') . '"></li>';
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
		$output = '</div>';
		if (!isset($atts['left-arrow']) ||
		   (isset($atts['left-arrow']) && $atts['left-arrow'] === 'true')) {
    		$output .= '    <a class="carousel-control-prev" href="#dps_carousel" role="button" data-slide="prev">';
			$output .= '        <i class="fas fa-chevron-circle-left fa-3x ' . ($atts['arrow-color-class'] ? 'text-' . $atts['arrow-color-class'] : "text-dark") . '" aria-hidden="true"></i>';
		    $output .= '        <span class="sr-only">Previous</span>';
    		$output .= '    </a>';
        }
		if (!isset($atts['right-arrow']) ||
		   (isset($atts['right-arrow']) && $atts['right-arrow'] === 'true')) {
    		$output .= '<a class="carousel-control-next" href="#dps_carousel" role="button" data-slide="next">';
			$output .= '        <i class="fas fa-chevron-circle-right fa-3x ' . ($atts['arrow-color-class'] ? 'text-' . $atts['arrow-color-class'] : "text-dark") . '" aria-hidden="true"></i>';
		    $output .= '    <span class="sr-only">Next</span>';
    		$output .= '</a>';
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
	} else if (!empty($atts['wrapper']) && 'accordion' === $atts['wrapper']) {
        $output = '</div>';
	}

	return $output;
}
add_filter('display_posts_shortcode_wrapper_close', 'uj_dps_posts_close', 10, 2);

/**
 * Display Posts, option output
 *
 * @param string $output Output.
 * @param array  $atts Atttributes.
 */
function uj_dps_option_output($output, $atts) {
	if (!empty($atts['layout'])) {
		ob_start();
		get_template_part('template-parts/dps', $atts['layout']);
		$new_output = ob_get_clean();
		if (!empty($new_output)) {
			$output = $new_output;
		}
	} else if (!empty($atts['wrapper_id'])) {
		switch($atts['wrapper_id']) {
			case 'frontpage-updates':
				$new_output = uj_dps_option_output_frontpage_updates($output, $atts);
				if (!empty($new_output)) {
					$output = $new_output;
				}
				break;
			case 'testimonials':
			case 'testimonials-small':
				$new_output = uj_dps_option_output_testimonials($output, $atts, $atts['wrapper_id'] == "testimonials" ? "large" : "small");
				if (!empty($new_output)) {
					$output = $new_output;
				}
				break;
		}
	}

	return $output;
}
add_filter('display_posts_shortcode_output', 'uj_dps_option_output', 10, 2);

function uj_dps_option_output_frontpage_updates($output, $atts) {
	global $post;
	static $cnt = 0;
	$posttags = get_the_tags($post->ID);
	$icon = get_icon($posttags);

	if (!empty($atts['wrapper'] ) && 'carousel' === $atts['wrapper']) {
		++$cnt;

	 	$output = ' <div class="carousel-item' . ($cnt == 1 ? ' active' : '') . '">';
	 	$output .= '   <p class="dps_title' . (!empty($atts['title-class']) ? " " . $atts['title-class'] : "") . '">' . $icon .  esc_html( get_the_title() ) . '</p>';
	 	$output .= '   <p class="dps_text' . (!empty($atts['text-class']) ? " " . $atts['text-class'] : "") . '">' . apply_filters('the_content', get_post_field('post_content', $post->ID)) .  '</p></div>';
	} else 	if (!empty( $atts['wrapper'] ) && 'accordion' === $atts['wrapper']) {
		++$cnt;

        $output  = '<div class="card">';
        $output .= '  <div class="card-header" id="dps-accordion-head' . $cnt . '">';
        $output .= '    <h5 class="mb-0">';
        $output .= '      <button class="btn btn-link btn-block text-left" data-toggle="collapse" data-target="#dps-accordion-collapse' . $cnt . '" aria-expanded="true" aria-controls="dps-accordion-collapse' . $cnt . '">';
        $output .= '        <i class="fas fa-plus float-right"></i>' . $icon .  esc_html(get_the_title());
        $output .= '      </button>';
        $output .= '    </h5>';
        $output .= '  </div>';
        $output .= '  <div id="dps-accordion-collapse' . $cnt . '" class="collapse" aria-labelledby="dps-accordion-head' . $cnt . '" data-parent="#dps-accordion">';
        $output .= '    <div class="card-body">';
        $output .= apply_filters('the_content', get_post_field('post_content', $post->ID));
        $output .= '    </div>';
        $output .= '  </div>';
        $output .= '</div>';
    }

	return $output;
}

function uj_dps_option_output_testimonials($output, $atts, $size = "large") {
	global $post;
	static $cnt = 0;
	$output = '';

	$posttags = get_the_tags($post->ID);
	$tags = [];
	if ($posttags) {
		foreach($posttags as $tag) {
			$tags[] = $tag->slug;
		}
	}
	$title = explode(" &#8211;", get_the_title(), 2);
	$img = wp_get_attachment_url(get_post_thumbnail_id($post->ID), 'thumbnail');
	if (!$img) {
		if (in_array('female', $tags)) {
			$img = home_url() . '/wp-content/uploads/avatar_female.png';
		} else {
			$img = home_url() . '/wp-content/uploads/avatar_male.png';
		}
	}
	$stars = getStars($tags);

	if (!empty($atts['wrapper'] ) && 'carousel' === $atts['wrapper']) {
		++$cnt;

	 	$output .= ' <div class="carousel-item' . ($cnt == 1 ? ' active' : '') . '">';
	} else if (!empty( $atts['wrapper'] ) && 'accordion' === $atts['wrapper']) {
		++$cnt;

        $output .= '<div class="card">';
        $output .= '  <div class="card-header" id="dps-accordion-head' . $cnt . '">';
        $output .= '    <h5 class="mb-0">';
        $output .= '      <button class="btn btn-block text-left" data-toggle="collapse" data-target="#dps-accordion-collapse' . $cnt . '" aria-expanded="true" aria-controls="dps-accordion-collapse' . $cnt . '">';
        $output .= '        <i class="fas fa-plus float-right"></i><span class="mr-3">' .  esc_html(get_the_title()) . '</span>' . $stars;
        $output .= '      </button>';
        $output .= '    </h5>';
        $output .= '  </div>';
        $output .= '  <div id="dps-accordion-collapse' . $cnt . '" class="collapse" aria-labelledby="dps-accordion-head' . $cnt . '" data-parent="#dps-accordion">';
        $output .= '    <div class="card-body">';
    }


	ob_start();
?>
<div class="container testimonial p-4 mt-4 rounded-lg border border-dark bg-light">
  <div class="row text-center <?php echo ($size == "large" ? "text-md-left" : "") ?>">
    <div class="col-12 <?php echo ($size == "large" ? "col-md-3" : "") ?>">
		<img src="<?php echo $img ?>" alt="Avatar" class="rounded-circle" style="width: 90px;">
	</div>
    <div class="col-12 <?php echo ($size == "large" ? "col-md-9" : "") ?>">
		<p><span class="lead font-weight-normal mr-3"><?php echo (!empty($title[0]) ? trim($title[0]) : '') ?></span> <?php echo (!empty($title[1]) ? do_shortcode(trim($title[1])) : '') ?></p>
		<p><?php echo $stars ?></p>
		<p><i class="fas fa-quote-left pr-3"></i><?php echo apply_filters('the_content', get_post_field('post_content', $post->ID)) ?><i class="fas fa-quote-right pl-3"></i></p>
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

function getStars($tags) {
	$stars = '';

	if ($tags) {
		if (in_array('5-stars', $tags)) {
			$num = 5;
		} else if (in_array('4-stars', $tags)) {
			$num = 4;
		} else if (in_array('3-stars', $tags)) {
			$num = 3;
		} else if (in_array('2-stars', $tags)) {
			$num = 2;
		} else if (in_array('1-star', $tags)) {
			$num = 1;
		} else {
			$num = 5;
		}
	} else {
		$num = 5;
	}

	for ($i = 1; $i <= 5; $i++) {
		$stars .= '<span class="fa fa-star mr-0"' . ($num >= $i ? ' style="color: gold!important;"' : '') . '"></span>';
	}

	return $stars;
}