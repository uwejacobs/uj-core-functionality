<?php
/**
 * General
 *
 * @package      CoreFunctionality
 * @author       Uwe Jacobs
 * @since        1.0.0
 * @license      GPL-2.0+
**/

if (!defined('ABSPATH')) exit; // Exit if accessed directly

/**
 * Dont Update the Plugin
 * If there is a plugin in the repo with the same name, this prevents WP from prompting an update.
 *
 * @since  1.2.1 Fix incorrect key when removing from $plugins array
 * @since  1.0.0
 * @author Jon Brown
 * @param  array $r Existing request arguments
 * @param  string $url Request URL
 * @return array Amended request arguments
 */
if (!function_exists('ujcf_dont_update_core_func_plugin')) {
	function ujcf_dont_update_core_func_plugin( $r, $url ) {
	  if ( 0 !== strpos( $url, 'https://api.wordpress.org/plugins/update-check/1.1/' ) )
		return $r; // Not a plugin update request. Bail immediately.
		$plugins = json_decode( $r['body']['plugins'], true );
		unset( $plugins['plugins'][plugin_basename( UJ_DIR . '/core-functionality.php' )] );
		$r['body']['plugins'] = json_encode( $plugins );
		return $r;
	 }
	
	add_filter( 'http_request_args', 'ujcf_dont_update_core_func_plugin', 5, 2 );
}

/**
 * Author Links on CF Plugin
 *
 */
if (!function_exists('ujcf_author_links_on_cf_plugin')) {
	function ujcf_author_links_on_cf_plugin( $links, $file ) {

		if ( strpos( $file, 'core-functionality.php' ) !== false ) {
			$links[1] = 'By <a href="http://www.ujsoftware.com">Uwe Jacobs</a>';
		}

		return $links;
	}

	add_filter( 'plugin_row_meta', 'ujcf_author_links_on_cf_plugin', 10, 2 );
}

// Don't let WPSEO metabox be high priority
add_filter( 'wpseo_metabox_prio', function(){ return 'low'; } );

/**
 * Remove WPSEO Notifications
 *
 */
if (!function_exists('ujcf_remove_wpseo_notifications')) {
	function ujcf_remove_wpseo_notifications() {

		if( ! class_exists( 'Yoast_Notification_Center' ) )
			return;

		remove_action( 'admin_notices', array( Yoast_Notification_Center::get(), 'display_notifications' ) );
		remove_action( 'all_admin_notices', array( Yoast_Notification_Center::get(), 'display_notifications' ) );
	}

	add_action( 'init', 'ujcf_remove_wpseo_notifications' );
}

/**
  * Exclude No-index content from search
  *
  */
if (!function_exists('ujcf_exclude_noindex_from_search')) {
	function ujcf_exclude_noindex_from_search( $query ) {

		if( $query->is_main_query() && $query->is_search() && ! is_admin() ) {

			$meta_query = empty( $query->query_vars['meta_query'] ) ? array() : $query->query_vars['meta_query'];
			$meta_query[] = array(
				'key' => '_yoast_wpseo_meta-robots-noindex',
				'compare' => 'NOT EXISTS',
			);

			$query->set( 'meta_query', $meta_query );
		}
	}

	add_action( 'pre_get_posts', 'ujcf_exclude_noindex_from_search' );
}

/**
 * Pretty Printing
 *
 * @since 1.0.0
 * @author Chris Bratlien
 * @param mixed $obj
 * @param string $label
 * @return null
 */
if (!function_exists('ujcf_pp')) {
	function ujcf_pp( $obj, $label = '' ) {
		$data = json_encode( print_r( $obj,true ) );
		?>
		<style type="text/css">
			#ujcfLogger {
			position: absolute;
			top: 30px;
			right: 0px;
			border-left: 4px solid #bbb;
			padding: 6px;
			background: white;
			color: #444;
			z-index: 999;
			font-size: 1.25em;
			width: 400px;
			height: 800px;
			overflow: scroll;
			}
		</style>
		<script type="text/javascript">
			var doStuff = function(){
				var obj = <?php echo $data; ?>;
				var logger = document.getElementById('ujcfLogger');
				if (!logger) {
					logger = document.createElement('div');
					logger.id = 'ujcfLogger';
					document.body.appendChild(logger);
				}
				console.log(obj);
				var pre = document.createElement('pre');
				var h2 = document.createElement('h2');
				pre.innerHTML = obj;
				h2.innerHTML = '<?php echo addslashes($label); ?>';
				logger.appendChild(h2);
				logger.appendChild(pre);
			};
			window.addEventListener ("DOMContentLoaded", doStuff, false);
		</script>
		<?php
	}
}

/**
 * Add inline css editor width
 * Not needed with Classic Editor Plugin
 */
/*
if (!function_exists('ujcf_editor_full_width_gutenberg')) {
	function ujcf_editor_full_width_gutenberg() {
	  echo '<style>
		body.gutenberg-editor-page .editor-post-title__block, body.gutenberg-editor-page .editor-default-block-appender, body.gutenberg-editor-page .editor-block-list__block {
					max-width: none !important;
			}
		.block-editor__container .wp-block {
			max-width: none !important;
		}
		.edit-post-text-editor__body {
			max-width: none !important;
			margin-left: auto;
			margin-right: auto;
		}
	  </style>';
	}

	add_action('admin_head', 'ujcf_editor_full_width_gutenberg');
}
*/

/*
 * Run shortcodes in text widgets
 */
add_filter('widget_text', 'do_shortcode');

// disable wpautop for pages, posts, post excerpt and ACF wysiwig
remove_filter( 'the_content', 'wpautop' );
remove_filter( 'the_excerpt', 'wpautop' );
remove_filter( 'acf_the_content', 'wpautop' );

// keep P and BR in ACF wysiwig
add_filter( 'tiny_mce_before_init', function($init) { $init['wpautop'] = false; $init['indent'] = true; $init['tadv_noautop'] = true; }, 10, 2 );
