<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly

if (!function_exists('cptui_register_booking_cpta_fields')) {
	function cptui_register_booking_cpta_fields() {
		if( function_exists('acf_add_local_field_group') ) {
			acf_add_local_field_group(array(
				'key' => 'group_621eb09d2ec7e',
				'title' => 'Booking',
				'fields' => array(
					array(
						'key' => 'field_621eb0e90d330',
						'label' => 'Start Date',
						'name' => 'start_date',
						'type' => 'date_picker',
						'instructions' => '',
						'required' => 1,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'display_format' => 'm/d/Y',
						'return_format' => 'Ymd',
						'first_day' => 1,
					),
					array(
						'key' => 'field_621eb287b16e3',
						'label' => 'End Date',
						'name' => 'end_date',
						'type' => 'date_picker',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'display_format' => 'm/d/Y',
						'return_format' => 'Ymd',
						'first_day' => 1,
					),
					array(
						'key' => 'field_621eb2b2b16e4',
						'label' => 'Status',
						'name' => 'status',
						'type' => 'radio',
						'instructions' => '',
						'required' => 1,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'choices' => array(
							'inquiry' => 'Inquiry',
							'tentative' => 'Tentative',
							'booked' => 'Booked',
							'event' => 'Event',
							'holiday' => 'Holiday',
						),
						'allow_null' => 0,
						'other_choice' => 0,
						'default_value' => 'inquiry',
						'layout' => 'horizontal',
						'return_format' => 'value',
						'save_other_choice' => 0,
					),
					array(
						'key' => 'field_621fa0926aa63',
						'label' => 'Comment',
						'name' => 'comment',
						'type' => 'textarea',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'maxlength' => '',
						'rows' => 3,
						'new_lines' => '',
					),
				),
				'location' => array(
					array(
						array(
							'param' => 'post_type',
							'operator' => '==',
							'value' => 'booking',
						),
					),
				),
				'menu_order' => 0,
				'position' => 'normal',
				'style' => 'seamless',
				'label_placement' => 'top',
				'instruction_placement' => 'label',
				'hide_on_screen' => array(
					0 => 'permalink',
					1 => 'the_content',
					2 => 'excerpt',
					3 => 'discussion',
					4 => 'comments',
					5 => 'revisions',
					6 => 'slug',
					7 => 'author',
					8 => 'format',
					9 => 'page_attributes',
					10 => 'featured_image',
					11 => 'categories',
					12 => 'tags',
					13 => 'send-trackbacks',
				),
				'active' => true,
				'description' => '',
				'show_in_rest' => 0,
			));
		}
	}
}

if (!function_exists('cptui_register_testimonial_cpta_fields')) {
	function cptui_register_testimonial_cpta_fields() {
		if( function_exists('acf_add_local_field_group') ) {
			acf_add_local_field_group(array(
				'key' => 'group_621e551a87429',
				'title' => 'Testimonial',
				'fields' => array(
					array(
						'key' => 'field_621e5556457dc',
						'label' => 'Picture',
						'name' => 'picture',
						'type' => 'image',
						'instructions' => 'Preferred square image with size 90x90 pixels. (Standard: generic avatar image)',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'return_format' => 'id',
						'preview_size' => 'thumbnail',
						'library' => 'all',
						'min_width' => 90,
						'min_height' => 90,
						'min_size' => '',
						'max_width' => '',
						'max_height' => '',
						'max_size' => '',
						'mime_types' => '',
					),
					array(
						'key' => 'field_621e89acd7d46',
						'label' => 'Gender',
						'name' => 'gender',
						'type' => 'radio',
						'instructions' => 'Gender for the generic avatar picture.',
						'required' => 1,
						'conditional_logic' => array(
							array(
								array(
									'field' => 'field_621e5556457dc',
									'operator' => '==empty',
								),
							),
						),
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'choices' => array(
							'male' => 'Male',
							'female' => 'Female',
						),
						'allow_null' => 0,
						'other_choice' => 0,
						'default_value' => 'Male',
						'layout' => 'horizontal',
						'return_format' => 'value',
						'save_other_choice' => 0,
					),
					array(
						'key' => 'field_621e5587457dd',
						'label' => 'Title(s)',
						'name' => 'title',
						'type' => 'textarea',
						'instructions' => 'Enter all titles and credentials.',
						'required' => 1,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'maxlength' => '',
						'rows' => 4,
						'new_lines' => '',
					),
					array(
						'key' => 'field_621e56b69deab',
						'label' => 'Star Rating',
						'name' => 'stars',
						'type' => 'number',
						'instructions' => 'Enter the number of stars from 1 - 5 with step size 0.5. (Standard: 5)',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => 5,
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'min' => 1,
						'max' => 5,
						'step' => '0.5',
					),
					array(
						'key' => 'field_621e571e9deac',
						'label' => 'Text',
						'name' => 'text',
						'type' => 'textarea',
						'instructions' => 'Enter the testimonial.',
						'required' => 1,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'maxlength' => '',
						'rows' => '',
						'new_lines' => '',
					),
				),
				'location' => array(
					array(
						array(
							'param' => 'post_type',
							'operator' => '==',
							'value' => 'testimonial',
						),
					),
				),
				'menu_order' => 0,
				'position' => 'normal',
				'style' => 'seamless',
				'label_placement' => 'top',
				'instruction_placement' => 'label',
				'hide_on_screen' => array(
					0 => 'permalink',
					1 => 'the_content',
					2 => 'excerpt',
					3 => 'discussion',
					4 => 'comments',
					5 => 'revisions',
					6 => 'slug',
					7 => 'author',
					8 => 'format',
					9 => 'page_attributes',
					10 => 'featured_image',
					11 => 'categories',
					12 => 'tags',
					13 => 'send-trackbacks',
				),
				'active' => true,
				'description' => '',
				'show_in_rest' => 0,
			));
		}
	}
}

if (!function_exists('cptui_register_faq_cpta_fields')) {
	function cptui_register_faq_cpta_fields() {
		if( function_exists('acf_add_local_field_group') ) {
			acf_add_local_field_group(array(
				'key' => 'group_622657270b3d3',
				'title' => 'FAQ',
				'fields' => array(
					array(
						'key' => 'field_622657539f7ca',
						'label' => 'Answer',
						'name' => 'text',
						'type' => 'textarea',
						'instructions' => '',
						'required' => 1,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'maxlength' => '',
						'rows' => '',
						'new_lines' => '',
					),
					array(
						'key' => 'field_622657719f7cb',
						'label' => 'Image',
						'name' => 'image',
						'type' => 'image',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'return_format' => 'array',
						'preview_size' => 'thumbnail',
						'library' => 'all',
						'min_width' => '',
						'min_height' => '',
						'min_size' => '',
						'max_width' => '',
						'max_height' => '',
						'max_size' => '',
						'mime_types' => '',
					),
					array(
						'key' => 'field_622920c2ddb4a',
						'label' => 'Order',
						'name' => 'order',
						'type' => 'number',
						'instructions' => 'Menu Order (1-99)',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => 10,
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'min' => 1,
						'max' => 99,
						'step' => 1,
					),
				),
				'location' => array(
					array(
						array(
							'param' => 'post_type',
							'operator' => '==',
							'value' => 'faq',
						),
					),
				),
				'menu_order' => 0,
				'position' => 'normal',
				'style' => 'seamless',
				'label_placement' => 'top',
				'instruction_placement' => 'label',
				'hide_on_screen' => array(
					0 => 'permalink',
					1 => 'the_content',
					2 => 'excerpt',
					3 => 'discussion',
					4 => 'comments',
					5 => 'revisions',
					6 => 'slug',
					7 => 'author',
					8 => 'format',
					9 => 'page_attributes',
					10 => 'featured_image',
					11 => 'categories',
					12 => 'tags',
					13 => 'send-trackbacks',
				),
				'active' => true,
				'description' => '',
				'show_in_rest' => 0,
			));
		}
	}
}

if (!function_exists('cptui_register_alert_cpta_fields')) {
	function cptui_register_alert_cpta_fields() {
		if( function_exists('acf_add_local_field_group') ) {
			acf_add_local_field_group(array(
				'key' => 'group_62266099aa59a',
				'title' => 'Alerts',
				'fields' => array(
					array(
						'key' => 'field_62266099b0004',
						'label' => 'Text',
						'name' => 'text',
						'type' => 'textarea',
						'instructions' => '',
						'required' => 1,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'maxlength' => '',
						'rows' => 2,
						'new_lines' => '',
					),
					array(
						'key' => 'field_62291fe254a7b',
						'label' => 'Order',
						'name' => 'order',
						'type' => 'number',
						'instructions' => 'Menu Order (1-99)',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => 10,
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'min' => 1,
						'max' => 99,
						'step' => 1,
					),
				),
				'location' => array(
					array(
						array(
							'param' => 'post_type',
							'operator' => '==',
							'value' => 'alert',
						),
					),
				),
				'menu_order' => 0,
				'position' => 'normal',
				'style' => 'seamless',
				'label_placement' => 'top',
				'instruction_placement' => 'label',
				'hide_on_screen' => array(
					0 => 'permalink',
					1 => 'the_content',
					2 => 'excerpt',
					3 => 'discussion',
					4 => 'comments',
					5 => 'revisions',
					6 => 'slug',
					7 => 'author',
					8 => 'format',
					9 => 'page_attributes',
					10 => 'featured_image',
					11 => 'categories',
					12 => 'tags',
					13 => 'send-trackbacks',
				),
				'active' => true,
				'description' => '',
				'show_in_rest' => 0,
			));
		}
	}
}

if (!function_exists('cptui_register_news_cpta_fields')) {
	function cptui_register_news_cpta_fields() {
		if( function_exists('acf_add_local_field_group') ) {
			acf_add_local_field_group(array(
				'key' => 'group_62267284167b3',
				'title' => 'News',
				'fields' => array(
					array(
						'key' => 'field_6226728420269',
						'label' => 'Text',
						'name' => 'text',
						'type' => 'textarea',
						'instructions' => '',
						'required' => 1,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'maxlength' => '',
						'rows' => '',
						'new_lines' => '',
					),
					array(
						'key' => 'field_622672e07d5f7',
						'label' => 'Image',
						'name' => 'image',
						'type' => 'image',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'return_format' => 'array',
						'preview_size' => 'medium',
						'library' => 'all',
						'min_width' => '',
						'min_height' => '',
						'min_size' => '',
						'max_width' => '',
						'max_height' => '',
						'max_size' => '',
						'mime_types' => '',
					),
					array(
						'key' => 'field_62292161757fd',
						'label' => 'Order',
						'name' => 'order',
						'type' => 'number',
						'instructions' => 'Menu Order (1-99)',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => 10,
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'min' => 1,
						'max' => 99,
						'step' => 1,
					),
				),
				'location' => array(
					array(
						array(
							'param' => 'post_type',
							'operator' => '==',
							'value' => 'news',
						),
					),
				),
				'menu_order' => 0,
				'position' => 'normal',
				'style' => 'seamless',
				'label_placement' => 'top',
				'instruction_placement' => 'label',
				'hide_on_screen' => array(
					0 => 'permalink',
					1 => 'the_content',
					2 => 'excerpt',
					3 => 'discussion',
					4 => 'comments',
					5 => 'revisions',
					6 => 'slug',
					7 => 'author',
					8 => 'format',
					9 => 'page_attributes',
					10 => 'featured_image',
					11 => 'categories',
					12 => 'tags',
					13 => 'send-trackbacks',
				),
				'active' => true,
				'description' => '',
				'show_in_rest' => 0,
			));
		}
	}
}

if (!function_exists('cptui_register_fundraiser_cpta_fields')) {
	function cptui_register_fundraiser_cpta_fields() {
		if( function_exists('acf_add_local_field_group') ) {
			acf_add_local_field_group(array(
				'key' => 'group_6226765a5f488',
				'title' => 'Fundraiser',
				'fields' => array(
					array(
						'key' => 'field_6226765a6456b',
						'label' => 'Text',
						'name' => 'text',
						'type' => 'textarea',
						'instructions' => '',
						'required' => 1,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'maxlength' => '',
						'rows' => '',
						'new_lines' => '',
					),
					array(
						'key' => 'field_6226765a645a4',
						'label' => 'Image',
						'name' => 'image',
						'type' => 'image',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'return_format' => 'array',
						'preview_size' => 'medium',
						'library' => 'all',
						'min_width' => '',
						'min_height' => '',
						'min_size' => '',
						'max_width' => '',
						'max_height' => '',
						'max_size' => '',
						'mime_types' => '',
					),
					array(
						'key' => 'field_6229211b63e4e',
						'label' => 'Order',
						'name' => 'order',
						'type' => 'number',
						'instructions' => 'Menu Order (1-99)',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => 10,
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'min' => 1,
						'max' => 99,
						'step' => 1,
					),
				),
				'location' => array(
					array(
						array(
							'param' => 'post_type',
							'operator' => '==',
							'value' => 'fundraiser',
						),
					),
				),
				'menu_order' => 0,
				'position' => 'normal',
				'style' => 'seamless',
				'label_placement' => 'top',
				'instruction_placement' => 'label',
				'hide_on_screen' => array(
					0 => 'permalink',
					1 => 'the_content',
					2 => 'excerpt',
					3 => 'discussion',
					4 => 'comments',
					5 => 'revisions',
					6 => 'slug',
					7 => 'author',
					8 => 'format',
					9 => 'page_attributes',
					10 => 'featured_image',
					11 => 'categories',
					12 => 'tags',
					13 => 'send-trackbacks',
				),
				'active' => true,
				'description' => '',
				'show_in_rest' => 0,
			));
		}
	}
}
