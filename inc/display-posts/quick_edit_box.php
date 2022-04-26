<?php
/*
    Description: Add custom field status for the booking post type to quick edit box
    Version: 1.0.0
    Original Author: Apple Rinquest
    Original Author URI: https://applerinquest.com/
    Text Domain: uj-core-functionality
*/

if (!defined('ABSPATH')) exit; // Exit if accessed directly

/**
 * Add custom fields to the quick edit box
 * 
 * quick_edit_custom_box allows to add HTML in Quick Edit
 */
if (!function_exists('ujcf_add_quick_edit_status')) {
    // $column_name stores only the custom fields
    function ujcf_add_quick_edit_status($column_name, $post_type)
    {

        if (!($post_type === 'booking' && $column_name === 'status')) return;

		global $post;
		$status = get_post_meta($post->ID, "status");
		$status = $status[0] ?? "";
        echo '<fieldset class="inline-edit-col-right" style="border: 1px solid #dddddd;">
				<legend style="font-weight: bold; margin-left: 10px;">'.esc_html('Booking Fields', 'uj-core-functionality').':</legend>
                <div class="inline-edit-col">';
        wp_nonce_field('ujcf_q_edit_status_nonce', 'ujcf_nonce');
        echo '<label class="alignleft" style="width: 100%;">
                <span class="title">' . esc_html__('Status', 'uj-core-functionality') . '</span>';
		echo '<ul class="acf-radio-list acf-hl">';
		echo '<li><label><input type="radio" name="acf[field_621eb2b2b16e4]" value="inquiry"'.checked($status, "inquiry", false).'>Inquiry</label></li>';
		echo '<li><label><input type="radio" name="acf[field_621eb2b2b16e4]" value="tentative"'.checked($status, "tentative", false).'>Tentative</label></li>';
		echo '<li><label><input type="radio" name="acf[field_621eb2b2b16e4]" value="booked"'.checked($status, "booked", false).'>Booked</label></li>';
		echo '<li><label><input type="radio" name="acf[field_621eb2b2b16e4]" value="event"'.checked($status, "event", false).'>Event</label></li>';
		echo '<li><label><input type="radio" name="acf[field_621eb2b2b16e4]" value="holiday"'.checked($status, "holiday", false).'>Holiday</label></li>';
		echo '</ul>';		
        echo '</label>';
        echo '<br><br>';
        echo '</div></fieldset>';
    }

    add_action('quick_edit_custom_box',  'ujcf_add_quick_edit_status', 10, 2);
}


/**
 * Save the custom field value from the quick edit box 
 */
if (!function_exists(('ujcf_quick_edit_status_save'))) {
    function ujcf_quick_edit_status_save($post_id)
    {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
            return $post_id;

        if (!current_user_can('edit_post', $post_id)) {
            return;
        }

        if (!empty($_POST['ujcf_nonce']) && !wp_verify_nonce($_POST['ujcf_nonce'], 'ujcf_q_edit_status_nonce')) {
            return;
        }

        if (isset($_POST['acf']) && !empty($_POST['acf']['field_621eb2b2b16e4'])) {
            update_post_meta($post_id, 'status', $_POST['acf']['field_621eb2b2b16e4']);
        }
    }

    add_action('save_post_booking', 'ujcf_quick_edit_status_save');
}


/**
 * Populate the custom field values at the quick edit box using Javascript
 */
if (!function_exists('ujcf_quick_edit_status_js')) {
    function ujcf_quick_edit_status_js()
    {
        $current_screen = get_current_screen();

        if ($current_screen->id != 'edit-booking' || $current_screen->post_type !== 'booking')
            return;

        wp_enqueue_script('jquery');
        ?>
        <!-- add JS script -->
        <script id="ujcf_quick_edit_status_js" type="text/javascript">
            jQuery(function($) {
                var $ujcf_inline_editor = inlineEditPost.edit;
                inlineEditPost.edit = function(id) {
                    $ujcf_inline_editor.apply(this, arguments);
                    var $post_id = 0;

                    if (typeof(id) == 'object') {
                        $post_id = parseInt(this.getId(id));
                    }

                    if ($post_id != 0) {
                        var $edit_row = $('#edit-' + $post_id);
                        var $post_row = $('#post-' + $post_id);
                        var $status = $('.column-status', $post_row).text();
                        $(':radio[value="'+$status.toLowerCase()+'"]', $edit_row).prop('checked',true);
                    }
                }
            });
        </script>
		<style type="text/css">
		ul.acf-radio-list.acf-hl li { margin-right: 20px; clear: none;}
		</style>
<?php
    }

    add_action('admin_print_footer_scripts-edit.php', 'ujcf_quick_edit_status_js');
}

if (!function_exists('ujcf_get_quick_edit_field_name')) {
	function ujcf_get_quick_edit_field_name($post_type) {
		switch($post_type) {
			case 'alert':
				return '62291fe254a7b';
			case 'faq':
				return '622920c2ddb4a';
			case 'fundraiser':
				return '6229211b63e4e';
			case 'news':
				return '62292161757fd';
			case 'testimonial':
				return '6242046726ca2';
			default:
				return false;
		}
	}
}
