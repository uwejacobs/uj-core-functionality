<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {	exit; }

// Start Class
if ( ! class_exists( 'UJ_Theme_Options' ) ) {

	class UJ_Theme_Options {
		private static $checkBoxes = [];
		private static $checkBoxLabels = [];

		/**
		 * Start things up
		 *
		 * @since 1.0.0
		 */
		public function __construct() {
			self::$checkBoxes[] = 'alert';
			self::$checkBoxLabels['alert'] = __('Alerts', 'uj-core-functionality');
			self::$checkBoxes[] = 'booking';
			self::$checkBoxLabels['booking'] = __('Bookings', 'uj-core-functionality');
			self::$checkBoxes[] = 'faq';
			self::$checkBoxLabels['faq'] = __('FAQs', 'uj-core-functionality');
			self::$checkBoxes[] = 'fundraiser';
			self::$checkBoxLabels['fundraiser'] = __('Fundraiser', 'uj-core-functionality');
			self::$checkBoxes[] = 'news';
			self::$checkBoxLabels['news'] = __('News', 'uj-core-functionality');
			self::$checkBoxes[] = 'testimonial';
			self::$checkBoxLabels['testimonial'] = __('Testimonials', 'uj-core-functionality');

			// We only need to register the admin panel on the back-end
			if ( is_admin() ) {
				add_action( 'admin_menu', array( 'UJ_Theme_Options', 'add_admin_menu' ) );
				add_action( 'admin_init', array( 'UJ_Theme_Options', 'register_settings' ) );
				foreach(self::$checkBoxes as $checkBox) {
					if (self::get_theme_option($checkBox.'_checkbox')) {
						add_filter('manage_edit-'.$checkBox.'_columns', 'ujcf_set_custom_edit_'.$checkBox.'_columns');
						add_action('manage_'.$checkBox.'_posts_custom_column', 'ujcf_custom_'.$checkBox.'_column', 10, 2);
						add_action( 'init', 'cptui_register_'.$checkBox.'_cpta_fields', 11 );
					}
				}
			}
		}

		/**
		 * Returns all theme options
		 *
		 * @since 1.0.0
		 */
		public static function get_theme_options() {
			return get_option( 'theme_options' );
		}

		/**
		 * Returns single theme option
		 *
		 * @since 1.0.0
		 */
		public static function get_theme_option( $id ) {
			$options = self::get_theme_options();
			if ( isset( $options[$id] ) ) {
				return $options[$id];
			}
		}

		/**
		 * Add sub menu page
		 *
		 * @since 1.0.0
		 */
		public static function add_admin_menu() {
			$icon_svg =	'<?xml version="1.0" standalone="no"?><!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 20010904//EN" "http://www.w3.org/TR/2001/REC-SVG-20010904/DTD/svg10.dtd"><svg version="1.0" xmlns="http://www.w3.org/2000/svg" width="1024.000000pt" height="1024.000000pt" viewBox="0 0 1024.000000 1024.000000" preserveAspectRatio="xMidYMid meet"><g transform="translate(0.000000,1024.000000) scale(0.100000,-0.100000)" fill="#000000" stroke="none"><path d="M693 7313 c3 -2802 0 -2639 53 -2943 205 -1190 968 -1926 2154 -2079 443 -58 940 -34 1350 64 246 59 578 203 790 342 568 373 925 996 1034 1803 35 255 36 366 36 2891 l0 2519 -620 0 -620 0 0 -2508 c0 -2175 -2 -2524 -15 -2632 -48 -394 -167 -664 -394 -891 -196 -196 -419 -306 -727 -360 -180 -31 -503 -31 -678 0 -202 36 -403 114 -551 214 -83 57 -218 188 -285 278 -108 145 -196 347 -241 550 -50 229 -49 177 -49 2852 l0 2497 -620 0 -620 0 3 -2597z"/><path d="M8390 5411 c0 -1776 -3 -2673 -11 -2742 -33 -331 -135 -579 -314 -768 -125 -131 -256 -208 -440 -258 -94 -25 -113 -27 -315 -27 -193 0 -225 2 -310 23 -292 73 -538 230 -686 439 -16 23 -32 42 -36 42 -7 0 -982 -702 -1006 -724 -10 -10 0 -30 53 -101 271 -363 648 -626 1105 -770 303 -96 577 -131 935 -122 435 12 756 80 1079 229 239 111 412 233 591 419 328 341 509 754 597 1364 l22 150 3 2743 4 2742 -636 0 -635 0 0 -2639z"/></g></svg>';
			$icon_url = 'data:image/svg+xml;base64,' . base64_encode($icon_svg);

			add_menu_page(
				esc_html__( 'Theme Settings', 'uj-core-functionality' ),
				esc_html__( 'Theme Settings', 'uj-core-functionality' ),
				'manage_options',
				'theme_options',
				'',
				$icon_url,
				20
			);
			
			add_submenu_page(
				'theme_options',
				esc_html__( 'General', 'uj-core-functionality' ),
				esc_html__( 'General', 'uj-core-functionality' ),
				'manage_options',
				'theme_options',
				array( 'UJ_Theme_Options', 'create_admin_page' ),
				0
			);
		}

		/**
		 * Register a setting and its sanitization callback.
		 *
		 * We are only registering 1 setting so we can store all options in a single option as
		 * an array. You could, however, register a new setting for each option
		 *
		 * @since 1.0.0
		 */
		public static function register_settings() {
			register_setting( 'theme_options', 'theme_options', array( 'UJ_Theme_Options', 'sanitize' ) );
		}

		/**
		 * Sanitization callback
		 *
		 * @since 1.0.0
		 */
		public static function sanitize( $options ) {

			// If we have options lets sanitize them
			if ( $options ) {

				//  Checkboxes
				foreach(self::$checkBoxes as $checkBox) {
					if ( ! empty( $options[$checkBox.'_checkbox'] ) ) {
						$options[$checkBox.'_checkbox'] = 'on';
					} else {
						unset( $options[$checkBox.'_checkbox'] ); // Remove from options if not checked
					}
				}

				// Input
				if ( ! empty( $options['input_example'] ) ) {
					$options['input_example'] = sanitize_text_field( $options['input_example'] );
				} else {
					unset( $options['input_example'] ); // Remove from options if empty
				}

				// Select
				if ( ! empty( $options['select_example'] ) ) {
					$options['select_example'] = sanitize_text_field( $options['select_example'] );
				}

			}

			// Return sanitized options
			return $options;

		}

		/**
		 * Settings page output
		 *
		 * @since 1.0.0
		 */
		public static function create_admin_page() { ?>

			<div class="wrap">

				<h1><?php esc_html_e( 'Theme Options', 'uj-core-functionality' ); ?></h1>

				<form method="post" action="options.php">

					<?php settings_fields( 'theme_options' ); ?>

					<table class="form-table uj-custom-admin-login-table">

						<?php // Custom posts ?>
						<tr valign="top">
							<th scope="row" style="font-size:125%"><?php esc_html_e('Post Types', 'uj-core-functionality') ?></th>
							<td>
								<?php foreach(self::$checkBoxes as $checkBox) {
								$value = self::get_theme_option( $checkBox.'_checkbox' ); ?>
								<p><input type="checkbox" name="theme_options[<?php echo esc_attr($checkBox) ?>_checkbox]" <?php checked( $value, 'on' ); ?>> <?php echo esc_html(self::$checkBoxLabels[$checkBox]);
								} ?></p>
							</td>
						</tr>

						<?php // Alert ?>
						<?php if (self::get_theme_option('alert_checkbox')) { ?>
						<tr>
							<th colspan="2" style="font-size:125%"><?php esc_html_e( 'Alert Settings:', 'uj-core-functionality' ) ?></th>
						</tr>
						<tr valign="top" class="uj-custom-admin-screen-background-section">
							<th scope="row"><?php esc_html_e( 'Background Color', 'uj-core-functionality' ); ?></th>
							<td>
								<?php $value = self::get_theme_option( 'alert_bg_color' ); ?>
								<select name="theme_options[alert_bg_color]">
									<?php
									$options = array(
										'primary' => esc_html__( 'Primary', 'uj-core-functionality' ),
										'secondary' => esc_html__( 'Secondary', 'uj-core-functionality' ),
										'info' => esc_html__( 'Info', 'uj-core-functionality' ),
										'success' => esc_html__( 'Success', 'uj-core-functionality' ),
										'warning' => esc_html__( 'Warning', 'uj-core-functionality' ),
										'danger' => esc_html__( 'Danger', 'uj-core-functionality' ),
									);
									foreach ( $options as $id => $label ) { ?>
										<option value="<?php echo esc_attr( $id ); ?>" <?php selected( $value, $id, true ); ?>>
											<?php echo strip_tags( $label ); ?>
										</option>
									<?php } ?>
								</select>
								<p>You can see the actual colors for your theme here: <a href="<?php echo site_url('theme-demo') . '#buttons' ?>" target="_blank" rel="noreferrer noopener">Theme Demo</a></p>
							</td>
						</tr>
						<?php } ?>

						<?php // Booking ?>
						<?php if (self::get_theme_option('booking_checkbox')) { ?>
						<tr>
							<th colspan="2" style="font-size:125%"><?php esc_html_e( 'Booking Settings:', 'uj-core-functionality' ) ?></th>
						</tr>
						<tr valign="top">
							<th scope="row"><?php esc_html_e( 'Special Rate Period', 'uj-core-functionality' ); ?></th>
							<td>
								<?php $value = intval(self::get_theme_option( 'special_rate_period' )); ?>
								<input type="text" name="theme_options[special_rate_period]" value="<?php echo esc_attr( $value ); ?>">
							</td>
						</tr>
						<?php } ?>

						<?php // FAQ ?>
						<?php if (self::get_theme_option('faq_checkbox')) { ?>
						<tr>
							<th colspan="2" style="font-size:125%"><?php esc_html_e( 'FAQ Settings:', 'uj-core-functionality' ) ?></th>
						</tr>
						<tr>
							<th><?php esc_html_e( 'Default Image', 'uj-core-functionality' ) ?></th>
							<td>
							<?php $value = self::get_theme_option( 'faq_image' );
								  self::media_script('faq', $value); ?>
							<div class="faq_image_preview_wrapper">
								<img id="faq_image_preview" src="<?php echo wp_get_attachment_image_url( ($value) ) ?>" height="100px"<?php echo (!empty($value) ? '' : ' style="display: none;"') ?>>
							</div>
							<input id="select_faq_image_button" type="button" class="button" value="<?php esc_html_e( 'Select image', 'uj-core-functionality' ) ?>" />
							<input type="hidden" name="theme_options[faq_image]" id="faq_image_attachment_id" value="<?php echo esc_attr($value) ?>">
							<input id="clear_faq_image_button" type="button" class="button" value="Clear" />
							</td>
						</tr>
						<?php } ?>

						<?php // Fundraiser ?>
						<?php if (self::get_theme_option('fundraiser_checkbox')) { ?>
						<tr>
							<th colspan="2" style="font-size:125%"><?php esc_html_e( 'Fundraiser Settings:', 'uj-core-functionality' ) ?></th>
						</tr>
						<tr>
							<th><?php esc_html_e( 'Default Image', 'uj-core-functionality' ) ?></th>
							<td>
							<?php $value = self::get_theme_option( 'fundraiser_image' );
								  self::media_script('fundraiser', $value); ?>
							<div class="fundraiser_image_preview_wrapper">
								<img id="fundraiser_image_preview" src="<?php echo wp_get_attachment_image_url( ($value) ) ?>" height="100px"<?php echo (!empty($value) ? '' : ' style="display: none;"') ?>>
							</div>
							<input id="select_fundraiser_image_button" type="button" class="button" value="<?php esc_html_e( 'Select image', 'uj-core-functionality' ) ?>" />
							<input type="hidden" name="theme_options[fundraiser_image]" id="fundraiser_image_attachment_id" value="<?php echo esc_attr($value) ?>">
							<input id="clear_fundraiser_image_button" type="button" class="button" value="Clear" />
							</td>
						</tr>
						<?php } ?>

						<?php // News ?>
						<?php if (self::get_theme_option('news_checkbox')) { ?>
						<tr>
							<th colspan="2" style="font-size:125%"><?php esc_html_e( 'News Settings:', 'uj-core-functionality' ) ?></th>
						</tr>
						<tr>
							<th><?php esc_html_e( 'Default Image', 'uj-core-functionality' ) ?></th>
							<td>
							<?php $value = self::get_theme_option( 'news_image' );
								  self::media_script('news', $value); ?>
							<div class="news_image_preview_wrapper">
								<img id="news_image_preview" src="<?php echo wp_get_attachment_image_url( ($value) ) ?>" height="100px"<?php echo (!empty($value) ? '' : ' style="display: none;"') ?>>
							</div>
							<input id="select_news_image_button" type="button" class="button" value="<?php esc_html_e( 'Select image', 'uj-core-functionality' ) ?>" />
							<input type="hidden" name="theme_options[news_image]" id="news_image_attachment_id" value="<?php echo esc_attr($value) ?>">
							<input id="clear_news_image_button" type="button" class="button" value="Clear" />
							</td>
						</tr>
						<?php } ?>

						<?php // Testimonials ?>
						<?php if (self::get_theme_option('testimonial_checkbox')) { ?>
						<tr>
							<th colspan="2" style="font-size:125%"><?php esc_html_e( 'Testimonials Settings:', 'uj-core-functionality' ) ?></th>
						</tr>
						<tr>
							<th><?php esc_html_e( 'Default Female Avatar Image', 'uj-core-functionality' ) ?></th>
							<td>
							<?php $value = self::get_theme_option( 'female_avatar_image' );
								  self::media_script('female_avatar', $value); ?>
							<div class="female_avatar_image_preview_wrapper">
								<img id="female_avatar_image_preview" src="<?php echo wp_get_attachment_image_url( ($value) ) ?>" height="100px"<?php echo (!empty($value) ? '' : ' style="display: none;"') ?>>
							</div>
							<input id="select_female_avatar_image_button" type="button" class="button" value="<?php esc_html_e( 'Select image', 'uj-core-functionality' ) ?>" />
							<input type="hidden" name="theme_options[female_avatar_image]" id="female_avatar_image_attachment_id" value="<?php echo esc_attr($value) ?>">
							<input id="clear_female_avatar_image_button" type="button" class="button" value="Clear" />
							</td>
						</tr>
						<tr>
							<th><?php esc_html_e( 'Default Male Avatar Image', 'uj-core-functionality' ) ?></th>
							<td>
							<?php $value = self::get_theme_option( 'male_avatar_image' );
								  self::media_script('male_avatar', $value); ?>
							<div class="male_avatar_image_preview_wrapper">
								<img id="male_avatar_image_preview" src="<?php echo wp_get_attachment_image_url( ($value) ) ?>" height="100px"<?php echo (!empty($value) ? '' : ' style="display: none;"') ?>>
							</div>
							<input id="select_male_avatar_image_button" type="button" class="button" value="<?php esc_html_e( 'Select image', 'uj-core-functionality' ) ?>" />
							<input type="hidden" name="theme_options[male_avatar_image]" id="male_avatar_image_attachment_id" value="<?php echo esc_attr($value) ?>">
							<input id="clear_male_avatar_image_button" type="button" class="button" value="Clear" />
							</td>
						</tr>
						<?php } ?>

						<?php /* // Text input example ?>
						<tr valign="top">
							<th scope="row"><?php esc_html_e( 'Input Example', 'uj-core-functionality' ); ?></th>
							<td>
								<?php $value = self::get_theme_option( 'input_example' ); ?>
								<input type="text" name="theme_options[input_example]" value="<?php echo esc_attr( $value ); ?>">
							</td>
						</tr>

						<?php // Select example ?>
						<tr valign="top" class="uj-custom-admin-screen-background-section">
							<th scope="row"><?php esc_html_e( 'Select Example', 'uj-core-functionality' ); ?></th>
							<td>
								<?php $value = self::get_theme_option( 'select_example' ); ?>
								<select name="theme_options[select_example]">
									<?php
									$options = array(
										'1' => esc_html__( 'Option 1', 'uj-core-functionality' ),
										'2' => esc_html__( 'Option 2', 'uj-core-functionality' ),
										'3' => esc_html__( 'Option 3', 'uj-core-functionality' ),
									);
									foreach ( $options as $id => $label ) { ?>
										<option value="<?php echo esc_attr( $id ); ?>" <?php selected( $value, $id, true ); ?>>
											<?php echo strip_tags( $label ); ?>
										</option>
									<?php } ?>
								</select>
							</td>
						</tr>
<php */ ?>

					</table>

					<?php submit_button(); ?>

				</form>

			</div><!-- .wrap -->
		<?php }

		public static function media_script($type, $value) {
			wp_enqueue_media();
?>
<script type='text/javascript'>
    jQuery(document).ready(function($) {

        // Uploading files
        var image_frame;
        var wp_media_post_id = wp.media.model.settings.post.id; // Store the old id
        var set_to_post_id = <?php echo wp_json_encode($value); ?> ; // Set this

        $('#clear_<?php echo $type ?>_image_button').on('click', function(event) {

            event.preventDefault();

            $('#<?php echo $type ?>_image_attachment_id').val('');
            $('#<?php echo $type ?>_image_preview').attr('src', '');
            $('#<?php echo $type ?>_image_preview').hide();
        });

        $('#select_<?php echo $type ?>_image_button').on('click', function(event) {

            event.preventDefault();

            // If the media frame already exists, reopen it.
            if (image_frame) {
                // Set the post ID to what we want
                image_frame.uploader.uploader.param('post_id', set_to_post_id);
                // Open frame
                image_frame.open();
                return;
            } else {
                // Set the wp.media post id so the uploader grabs the ID we want when initialised
                wp.media.model.settings.post.id = set_to_post_id;
            }

            // Create the media frame.
            image_frame = wp.media.frames.image_frame = wp.media({
                title: 'Select a <?php echo $type ?> image',
                button: {
                    text: 'Use this image'
                },
                library: {
                    type: 'image'
                },
                multiple: false,
                currentValue: set_to_post_id
            });

            image_frame.on('open', function() {
                const selection = image_frame.state().get('selection');
                const attachment = wp.media.attachment(set_to_post_id);
                attachment.fetch();
                selection.add(attachment ? [attachment] : []);
            });

            // When an image is selected, run a callback.
            image_frame.on('select', function() {
                // We set multiple to false so only get one image from the uploader
                attachment = image_frame.state().get('selection').first().toJSON();

                // Do something with attachment.id and/or attachment.url here
                $('#<?php echo $type ?>_image_preview').attr('src', attachment.url).css('width', 'auto');
                $('#<?php echo $type ?>_image_attachment_id').val(attachment.id);
                $('#<?php echo $type ?>_image_preview').show();

                // Restore the main post ID
                wp.media.model.settings.post.id = wp_media_post_id;
            });

            // Finally, open the modal
            image_frame.open();
        });

        // Restore the main ID when the add media button is pressed
        $('a.add_media').on('click', function() {
            wp.media.model.settings.post.id = wp_media_post_id;
        });
    });
</script>
<?php
		}

	}
}
new UJ_Theme_Options();

// Helper function to use in your theme to return a theme option value
if (!function_exists('ujcf_get_theme_option')) {
	function ujcf_get_theme_option( $id = '' ) {
		return UJ_Theme_Options::get_theme_option( $id );
	}
}


// Bookings
if (ujcf_get_theme_option('booking_checkbox')) {
	if (!function_exists('ujcf_set_custom_edit_booking_columns')) {
		function ujcf_set_custom_edit_booking_columns($columns) {
			$columns['start_date'] = esc_html__('Start Date', 'uj-core-functionality');
			$columns['end_date'] = esc_html__('End Date', 'uj-core-functionality');
			$columns['status'] = esc_html__('Status', 'uj-core-functionality');
			$columns['comment'] = esc_html__('Comment', 'uj-core-functionality');
			if (!in_array('administrator',  wp_get_current_user()->roles)) {
				unset($columns['expirationdate']);
			}
			return $columns;
		}
	}

	if (!function_exists('ujcf_custom_booking_column')) {
		function ujcf_custom_booking_column($column, $post_id) {
			$meta = get_post_meta($post_id);
			if ($column == 'start_date' && !empty($meta["start_date"][0])) {
				$date = new DateTime($meta["start_date"][0]);
				echo esc_attr($date->format(get_option('date_format')));
			}
			if ($column == 'end_date' && !empty($meta["end_date"][0])) {
				$date = new DateTime($meta["end_date"][0]);
				echo esc_attr($date->format(get_option('date_format')));
			}
			if ($column == 'status' && !empty($meta["status"][0])) {
				echo esc_attr(ucwords($meta["status"][0]));
			}
			if ($column == 'comment' && !empty($meta["comment"][0])) {
				echo esc_attr($meta["comment"][0]);
			}
		}
	}

	if (!function_exists('ujcf_sortable_booking_column')) {
		function ujcf_sortable_booking_column( $columns ) {
			$columns['start_date'] = 'start_date';

			return $columns;
		}
		
		add_filter( 'manage_edit-booking_sortable_columns', 'ujcf_sortable_booking_column' );
	}

	if (!function_exists('ujcf_booking_start_date_orderby')) {
		function ujcf_booking_start_date_orderby( $query ) {
			if( ! is_admin() )
				return;

			$orderby = $query->get( 'orderby');

			if( 'start_date' == $orderby ) {
				$query->set('meta_key','start_date');
				$query->set('orderby','meta_value');
			}
		}

		add_action( 'pre_get_posts', 'ujcf_booking_start_date_orderby' );
	}
}

// Testimonials
if (ujcf_get_theme_option('testimonial_checkbox')) {
	if (!function_exists('ujcf_set_custom_edit_testimonial_columns')) {
		function ujcf_set_custom_edit_testimonial_columns($columns) {
			$columns['title'] = esc_html__('Name', 'uj-core-functionality');
			$columns['credentials'] = esc_html__('Title', 'uj-core-functionality');
			$columns['picture'] = esc_html__('Picture', 'uj-core-functionality');
			$columns['stars'] = esc_html__('Stars', 'uj-core-functionality');
			$columns['text'] = esc_html__('Text', 'uj-core-functionality');
			return $columns;
		}
	}

	if (!function_exists('ujcf_custom_testimonial_column')) {
		function ujcf_custom_testimonial_column($column, $post_id) {
			$meta = get_post_meta($post_id);
			if ($column == 'credentials' && !empty($meta["title"][0])) {
				echo wp_kses_post(str_replace("\n", '<br>', $meta["title"][0]));
			}
			if ($column == 'picture') {
				$img = wp_get_attachment_image_url($meta["picture"][0], 'thumbnail');
				if (!$img) {
					if (!empty($meta["gender"][0]) && $meta["gender"][0] === 'female') {
						$img = wp_get_attachment_image_url(ujcf_get_theme_option('female_avatar_image'), 'thumbnail');
					} else {
						$img = wp_get_attachment_image_url(ujcf_get_theme_option('male_avatar_image'), 'thumbnail');
					}
				}
				echo '<img src="' . esc_url($img) . '" alt="Avatar" class="rounded-circle">';
			}
			if ($column == 'stars') {
				echo wp_kses_post(ujcf_getStars($meta["stars"][0]));
			}
			if ($column == 'text' && !empty($meta["text"][0])) {
				echo esc_attr($meta["text"][0]);
			}
		}
	}
}

// FAQs
if (ujcf_get_theme_option('faq_checkbox')) {
	if (!function_exists('ujcf_set_custom_edit_faq_columns')) {
		function ujcf_set_custom_edit_faq_columns($columns) {
			$columns['title'] = esc_html__('Question', 'uj-core-functionality');
			$columns['text'] = esc_html__('Answer', 'uj-core-functionality');
			$columns['image'] = esc_html__('Image', 'uj-core-functionality');
			$columns['order'] = esc_html__('Order', 'uj-core-functionality');
			return $columns;
		}
	}

	if (!function_exists('ujcf_custom_faq_column')) {
		function ujcf_custom_faq_column($column, $post_id) {
			$meta = get_post_meta($post_id);
			if ($column == 'text' && !empty($meta["text"][0])) {
				echo esc_attr($meta["text"][0]);
			}
			if ($column == 'image') {
				$img = wp_get_attachment_image_url($meta["image"][0], 'thumbnail');
				if ($img) {
					echo '<img src="' . esc_url($img) . '" alt="Avatar" class="rounded-circle">';
				}
			}
			if ($column == 'order' && !empty($meta["order"][0])) {
				echo esc_attr($meta["order"][0]);
			}
		}
	}

	if (!function_exists('ujcf_sortable_faq_column')) {
		function ujcf_sortable_faq_column( $columns ) {
			$columns['order'] = 'order';

			return $columns;
		}
		
		add_filter( 'manage_edit-faq_sortable_columns', 'ujcf_sortable_faq_column' );
	}
}

// Alerts
if (ujcf_get_theme_option('alert_checkbox')) {
	if (!function_exists('ujcf_set_custom_edit_alert_columns')) {
		function ujcf_set_custom_edit_alert_columns($columns) {
			$columns['text'] = esc_html__('Alert Text', 'uj-core-functionality');
			$columns['color'] = esc_html__('Background Color', 'uj-core-functionality');
			$columns['order'] = esc_html__('Order', 'uj-core-functionality');
			return $columns;
		}
	}

	if (!function_exists('ujcf_custom_alert_column')) {
		function ujcf_custom_alert_column($column, $post_id) {
			$meta = get_post_meta($post_id);
			if ($column == 'text' && !empty($meta["text"][0])) {
				echo esc_attr($meta["text"][0]);
			}
			if ($column == 'color' && !empty($meta["color"][0])) {
				echo esc_attr(ucwords($meta["color"][0]));
			}
			if ($column == 'order' && !empty($meta["order"][0])) {
				echo esc_attr($meta["order"][0]);
			}
		}
	}

	if (!function_exists('ujcf_sortable_alert_column')) {
		function ujcf_sortable_alert_column( $columns ) {
			$columns['order'] = 'order';

			return $columns;
		}
		
		add_filter( 'manage_edit-alert_sortable_columns', 'ujcf_sortable_alert_column' );
	}
}

// News
if (ujcf_get_theme_option('news_checkbox')) {
	if (!function_exists('ujcf_set_custom_edit_news_columns')) {
		function ujcf_set_custom_edit_news_columns($columns) {
			$columns['text'] = esc_html__('Text', 'uj-core-functionality');
			$columns['image'] = esc_html__('Image', 'uj-core-functionality');
			$columns['order'] = esc_html__('Order', 'uj-core-functionality');
			return $columns;
		}
	}

	if (!function_exists('ujcf_custom_news_column')) {
		function ujcf_custom_news_column($column, $post_id) {
			$meta = get_post_meta($post_id);
			if ($column == 'text' && !empty($meta["text"][0])) {
				echo esc_attr($meta["text"][0]);
			}
			if ($column == 'image') {
				$img = wp_get_attachment_image_url($meta["image"][0], 'thumbnail');
				if ($img) {
					echo '<img src="' . esc_url($img) . '" alt="Avatar" class="rounded-circle"';
				}
			}
			if ($column == 'order' && !empty($meta["order"][0])) {
				echo esc_attr($meta["order"][0]);
			}
		}
	}

	if (!function_exists('ujcf_sortable_news_column')) {
		function ujcf_sortable_news_column( $columns ) {
			$columns['order'] = 'order';

			return $columns;
		}
		
		add_filter( 'manage_edit-news_sortable_columns', 'ujcf_sortable_news_column' );
	}
}

// Fundraiser
if (ujcf_get_theme_option('fundraiser_checkbox')) {
	if (!function_exists('ujcf_set_custom_edit_fundraiser_columns')) {
		function ujcf_set_custom_edit_fundraiser_columns($columns) {
			$columns['text'] = esc_html__('Text', 'uj-core-functionality');
			$columns['image'] = esc_html__('Image', 'uj-core-functionality');
			$columns['order'] = esc_html__('Order', 'uj-core-functionality');
			return $columns;
		}
	}

	if (!function_exists('ujcf_custom_fundraiser_column')) {
		function ujcf_custom_fundraiser_column($column, $post_id) {
			$meta = get_post_meta($post_id);
			if ($column == 'text' && !empty($meta["text"][0])) {
				echo esc_attr($meta["text"][0]);
			}
			if ($column == 'image') {
				$img = wp_get_attachment_image_url($meta["image"][0], 'thumbnail');
				if ($img) {
					echo '<img src="' . esc_url($img) . '" alt="Avatar" class="rounded-circle">';
				}
			}
			if ($column == 'order' && !empty($meta["order"][0])) {
				echo esc_attr($meta["order"][0]);
			}
		}
	}

	if (!function_exists('ujcf_sortable_fundraiser_column')) {
		function ujcf_sortable_fundraiser_column( $columns ) {
			$columns['order'] = 'order';

			return $columns;
		}
		
		add_filter( 'manage_edit-fundraiser_sortable_columns', 'ujcf_sortable_fundraiser_column' );
	}
}
