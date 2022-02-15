<?php
/**
 * General
 *
 * @package      CoreFunctionality
 * @author       Uwe Jacobs
 * @since        1.0.0
 * @license      GPL-2.0+
**/

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
function uj_dont_update_core_func_plugin( $r, $url ) {
  if ( 0 !== strpos( $url, 'https://api.wordpress.org/plugins/update-check/1.1/' ) )
    return $r; // Not a plugin update request. Bail immediately.
    $plugins = json_decode( $r['body']['plugins'], true );
    unset( $plugins['plugins'][plugin_basename( UJ_DIR . '/core-functionality.php' )] );
    $r['body']['plugins'] = json_encode( $plugins );
    return $r;
 }
add_filter( 'http_request_args', 'uj_dont_update_core_func_plugin', 5, 2 );

/**
 * Author Links on CF Plugin
 *
 */
function uj_author_links_on_cf_plugin( $links, $file ) {

	if ( strpos( $file, 'core-functionality.php' ) !== false ) {
		$links[1] = 'By <a href="http://www.uwejacobs.com">Uwe Jacobs</a>';
    }

    return $links;
}
add_filter( 'plugin_row_meta', 'uj_author_links_on_cf_plugin', 10, 2 );

// Don't let WPSEO metabox be high priority
add_filter( 'wpseo_metabox_prio', function(){ return 'low'; } );

/**
 * Remove WPSEO Notifications
 *
 */
function uj_remove_wpseo_notifications() {

	if( ! class_exists( 'Yoast_Notification_Center' ) )
		return;

	remove_action( 'admin_notices', array( Yoast_Notification_Center::get(), 'display_notifications' ) );
	remove_action( 'all_admin_notices', array( Yoast_Notification_Center::get(), 'display_notifications' ) );
}
add_action( 'init', 'uj_remove_wpseo_notifications' );

/**
  * Exclude No-index content from search
  *
  */
function uj_exclude_noindex_from_search( $query ) {

	if( $query->is_main_query() && $query->is_search() && ! is_admin() ) {

		$meta_query = empty( $query->query_vars['meta_query'] ) ? array() : $query->query_vars['meta_query'];
		$meta_query[] = array(
			'key' => '_yoast_wpseo_meta-robots-noindex',
			'compare' => 'NOT EXISTS',
		);

		$query->set( 'meta_query', $meta_query );
	}
}
add_action( 'pre_get_posts', 'uj_exclude_noindex_from_search' );

/**
 * Pretty Printing
 *
 * @since 1.0.0
 * @author Chris Bratlien
 * @param mixed $obj
 * @param string $label
 * @return null
 */
function uj_pp( $obj, $label = '' ) {
	$data = json_encode( print_r( $obj,true ) );
	?>
	<style type="text/css">
		#bsdLogger {
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
			var logger = document.getElementById('bsdLogger');
			if (!logger) {
				logger = document.createElement('div');
				logger.id = 'bsdLogger';
				document.body.appendChild(logger);
			}
			////console.log(obj);
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

/**
 * Add inline css editor width
 * Not needed with Classic Editor Plugin
 */
/*
add_action('admin_head', 'uj_editor_full_width_gutenberg');

function uj_editor_full_width_gutenberg() {
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
*/

/*
 * Run shortcodes in text widgets
 */
add_filter('widget_text', 'do_shortcode');

/*
 * Get post content by slug
 */
function get_post_content_by_title($slug) {
	$page = get_page_by_title($slug); 
	$content = apply_filters('the_content', $page->post_content);
	return $content;
}
