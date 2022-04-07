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
		if (is_numeric($atts['id'])) {
			$_page = get_page($atts['id']);
		} else if(is_string($atts['id']) && function_exists('get_page_by_path')) {
			$_page = get_page_by_path($atts['id']);
			if (!$_page) {
				$_page = get_page_by_path($atts['id'], OBJECT, 'post');
			}
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
	// "1234" would be the WordPress ID of the Page/Post you are trying to include;
	// or use the slugname
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
	$newwindow = ( intval($newwindow) == 1 ? ' target="_blank"' : '' );
	$class = ( !empty( $class ) ? ' class="' . $class . '"' : '' );
	$rel = ( !empty( $rel ) ? ' rel="' . $rel . '"' : '' );

	return '<a' . esc_attr($newwindow) . esc_attr($class) . esc_attr($rel) . ' href="' . esc_url($url) . '">' . esc_html($content) . '</a>';
});


if (!function_exists('ujcf_img_gen')) {

    /*--------------------------------------------------------------------------------------
     * bs_img_gen
     *
     * Based on:
     * Dynamic Dummy Image Generator <97> as seen on DummyImage.com by Fabian Beiner
     *
     * (Original idea by Russel Heimlich. When I first published this script,
     * DummyImage.com was not Open Source, so I had to write a small script to
     * replace the function on my own server.)
     *
     *-------------------------------------------------------------------------------------*/
    function ujcf_img_gen($atts, $content = null) {
        $atts = array_change_key_case((array)$atts, CASE_LOWER);
        $atts = shortcode_atts(array(
            "size" => false,
            "file" => false,
            "text" => false,
            "bg" => false,
            "color" => false,
            "alt" => false,
            "class" => false,
        ) , $atts);

        if (!function_exists('imagettftext')) {
            return ("<p><b>The shortcode [img-gen] requires the PHP extensions GD and FreeType.</b></p>");
        }

        /**
         * Handle the <93>size<94> parameter.
         */
        $size = '640x480';
        if (isset($atts['size'])) {
            $size = $atts['size'];
        }
        list($imgWidth, $imgHeight) = explode('x', $size . 'x');
        if ($imgHeight === '') {
            $imgHeight = $imgWidth;
        }
        $filterOptions = ['options' => ['min_range' => 0, 'max_range' => 9999]];
        if (filter_var($imgWidth, FILTER_VALIDATE_INT, $filterOptions) === false) {
            $imgWidth = '640';
        }
        if (filter_var($imgHeight, FILTER_VALIDATE_INT, $filterOptions) === false) {
            $imgHeight = '480';
        }

        /**
         * Handle the <93>file<94> parameter.
         */
        $filetype = 'png';
        if (isset($atts['file']) && in_array(strtolower($atts['file']) , ['png', 'gif', 'jpg', 'jpeg'])) {
            $filetype = strtolower($atts['file']);
        }

        /**
         * Handle the <93>text<94> parameter.
         */
        $text = $imgWidth . '×' . $imgHeight;
        if (isset($atts['text']) && strlen($atts['text'])) {
            $text = filter_var(trim($atts['text']) , FILTER_SANITIZE_STRING);
        }
        $encoding = mb_detect_encoding($text, 'UTF-8, ISO-8859-1');
        if ($encoding !== 'UTF-8') {
            $text = mb_convert_encoding($text, 'UTF-8', $encoding);
        }
        $text = mb_encode_numericentity($text, [0x0, 0xffff, 0, 0xffff], 'UTF-8');

        /**
         * Handle the <93>bg<94> parameter.
         */
        $bg = '000080';
        if (isset($atts['bg']) && (strlen($atts['bg']) === 6 || strlen($atts['bg']) === 3)) {
            $bg = strtoupper($atts['bg']);
            if (strlen($atts['bg']) === 3) {
                $bg = strtoupper($atts['bg'][0] . $atts['bg'][0] . $atts['bg'][1] . $atts['bg'][1] . $atts['bg'][2] . $atts['bg'][2]);
            }
        }
        list($bgRed, $bgGreen, $bgBlue) = sscanf($bg, "%02x%02x%02x");

        /**
         * Handle the <93>color<94> parameter.
         */
        $color = 'FFFFFF';
        if (isset($atts['color']) && (strlen($atts['color']) === 6 || strlen($atts['color']) === 3)) {
            $color = strtoupper($atts['color']);
            if (strlen($atts['color']) === 3) {
                $color = strtoupper($atts['color'][0] . $atts['color'][0] . $atts['color'][1] . $atts['color'][1] . $atts['color'][2] . $atts['color'][2]);
            }
        }
        list($colorRed, $colorGreen, $colorBlue) = sscanf($color, "%02x%02x%02x");

        /**
         * Handle the "alt" parameter.
         */
        if (!isset($GLOBALS['img_gen_count'])) $GLOBALS['img_gen_count'] = 0;
        $alt_text = ($atts['alt']) ? ($atts['alt']) : "Generated Dummy Image " . ++$GLOBALS['img_gen_count'];

        /**
         * Define the typeface settings.
         */
        $fontFile = plugin_dir_path(__FILE__) . '/fonts/RobotoMono-Regular.ttf';
        if (!is_readable($fontFile)) {
            $fontFile = 'arial';
        }

        $fontSize = round(($imgWidth - 50) / 8);
        if ($fontSize <= 9) {
            $fontSize = 9;
        }

        /**
         * Generate the image.
         */
        $image = imagecreatetruecolor($imgWidth, $imgHeight);
        $colorFill = imagecolorallocate($image, $colorRed, $colorGreen, $colorBlue);
        $bgFill = imagecolorallocate($image, $bgRed, $bgGreen, $bgBlue);
        imagefill($image, 0, 0, $bgFill);
        $textBox = imagettfbbox($fontSize, 0, $fontFile, $text);

        while ($textBox[4] >= $imgWidth) {
            $fontSize -= round($fontSize / 2);
            $textBox = imagettfbbox($fontSize, 0, $fontFile, $text);
            if ($fontSize <= 9) {
                $fontSize = 9;
                break;
            }
        }
        $textWidth = abs($textBox[4] - $textBox[0]);
        $textHeight = abs($textBox[5] - $textBox[1]);
        $textX = ($imgWidth - $textWidth) / 2;
        $textY = ($imgHeight + $textHeight) / 2;
        imagettftext($image, $fontSize, 0, $textX, $textY, $colorFill, $fontFile, $text);

        /**
         * Return the image and destroy it afterwards.
         */
        ob_start();
        switch ($filetype) {
            case 'png':
                $img_type = 'image/png';
                imagepng($image, null, 9);
            break;
            case 'gif':
                $img_type = 'image/gif';
                imagegif($image);
            break;
            case 'jpg':
            case 'jpeg':
                $img_type = 'image/jpeg';
                imagejpeg($image);
            break;
        }
        imagedestroy($image);
        $img_data = ob_get_clean();

        return sprintf('<img%s src="data:%s;base64,%s" alt="%s" />', ($atts["class"] ? ' class="' . $atts["class"] . '"' : ''), $img_type, base64_encode($img_data) , $alt_text);
    }

	add_shortcode("img-gen", "ujcf_img_gen");
}

if (!function_exists('ujcf_lorem_ipsum')) {
    function ujcf_lorem_ipsum($atts, $content = null) {
        require_once (dirname(__FILE__) . '/LoremIpsum.php');

        $atts = array_change_key_case((array)$atts, CASE_LOWER);
        $atts = shortcode_atts(array(
            "tag" => 'p',
            "words" => false,
            "sentences" => false,
            "paragraphs" => false,
        ) , $atts);

        $lipsum = new joshtronic\LoremIpsum();

        if ($atts['words'] && intval($atts['words']) > 0) {
            $return = $lipsum->words(intval($atts['words']), $atts['tag']);
        }
        else if ($atts['sentences'] && intval($atts['sentences']) > 0) {
            $return = $lipsum->sentences(intval($atts['sentences']), $atts['tag']);
        }
        else if ($atts['paragraphs'] && intval($atts['paragraphs']) > 0) {
            $return = $lipsum->paragraph(intval($atts['paragraphs']), $atts['tag']);
        }
        else {
            $return = $lipsum->sentences(1, $atts['tag']);
        }

        return $return;
    }

	add_shortcode("lorem-ipsum", "ujcf_lorem_ipsum");
}

if (!function_exists('ujcf_img_shortcode')) {
	function ujcf_img_shortcode($atts, $content = null) {
    	extract(shortcode_atts(array("src" => ''), $atts));
    	return '<img src="' . $src . '" alt="'. do_shortcode(trim($content)) .'" />';
	}

	add_shortcode('img', 'ujcf_img_shortcode');
}
