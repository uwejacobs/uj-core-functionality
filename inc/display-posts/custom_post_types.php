<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly

if (!function_exists('cptui_register_my_cpts')) {
	function cptui_register_my_cpts() {

		if (ujcf_get_theme_option("alert_checkbox")) {
			/**
			 * Post Type: Alerts.
			 */

			$labels = [
				"name" => __( "Alerts", "uj-core-functionality" ),
				"singular_name" => __( "Alert", "uj-core-functionality" ),
				"menu_name" => __( "My Alerts", "uj-core-functionality" ),
				"all_items" => __( "Alerts", "uj-core-functionality" ),
				"add_new" => __( "Add new", "uj-core-functionality" ),
				"add_new_item" => __( "Add new Alert", "uj-core-functionality" ),
				"edit_item" => __( "Edit Alert", "uj-core-functionality" ),
				"new_item" => __( "New Alert", "uj-core-functionality" ),
				"view_item" => __( "View Alert", "uj-core-functionality" ),
				"view_items" => __( "View Alerts", "uj-core-functionality" ),
				"search_items" => __( "Search Alerts", "uj-core-functionality" ),
				"not_found" => __( "No Alerts found", "uj-core-functionality" ),
				"not_found_in_trash" => __( "No Alerts found in trash", "uj-core-functionality" ),
				"parent" => __( "Parent Alert:", "uj-core-functionality" ),
				"featured_image" => __( "Featured image for this Alert", "uj-core-functionality" ),
				"set_featured_image" => __( "Set featured image for this Alert", "uj-core-functionality" ),
				"remove_featured_image" => __( "Remove featured image for this Alert", "uj-core-functionality" ),
				"use_featured_image" => __( "Use as featured image for this Alert", "uj-core-functionality" ),
				"archives" => __( "Alert archives", "uj-core-functionality" ),
				"insert_into_item" => __( "Insert into Alert", "uj-core-functionality" ),
				"uploaded_to_this_item" => __( "Upload to this Alert", "uj-core-functionality" ),
				"filter_items_list" => __( "Filter Alerts list", "uj-core-functionality" ),
				"items_list_navigation" => __( "Alerts list navigation", "uj-core-functionality" ),
				"items_list" => __( "Alerts list", "uj-core-functionality" ),
				"attributes" => __( "Alerts attributes", "uj-core-functionality" ),
				"name_admin_bar" => __( "Alert", "uj-core-functionality" ),
				"item_published" => __( "Alert published", "uj-core-functionality" ),
				"item_published_privately" => __( "Alert published privately.", "uj-core-functionality" ),
				"item_reverted_to_draft" => __( "Alert reverted to draft.", "uj-core-functionality" ),
				"item_scheduled" => __( "Alert scheduled", "uj-core-functionality" ),
				"item_updated" => __( "Alert updated.", "uj-core-functionality" ),
				"parent_item_colon" => __( "Parent Alert:", "uj-core-functionality" ),
			];

			$args = [
				"label" => __( "Alerts", "uj-core-functionality" ),
				"labels" => $labels,
				"description" => "",
				"public" => true,
				"publicly_queryable" => true,
				"show_ui" => true,
				"show_in_rest" => true,
				"rest_base" => "",
				"rest_controller_class" => "WP_REST_Posts_Controller",
				"has_archive" => false,
				"show_in_menu" => "theme_options",
				"show_in_nav_menus" => true,
				"delete_with_user" => false,
				"exclude_from_search" => false,
				"capability_type" => "post",
				"map_meta_cap" => true,
				"hierarchical" => false,
				"rewrite" => [ "slug" => "alert", "with_front" => true ],
				"query_var" => true,
				"menu_icon" => "dashicons-info-outline",
				"supports" => [ "title", "custom-fields", "page-attributes" ],
				"show_in_graphql" => false,
			];

			register_post_type( "alert", $args );
		}

		if (ujcf_get_theme_option("booking_checkbox")) {
			/**
			 * Post Type: Bookings.
			 */

			$labels = [
				"name" => __( "Bookings", "uj-core-functionality" ),
				"singular_name" => __( "Booking", "uj-core-functionality" ),
				"menu_name" => __( "My Bookings", "uj-core-functionality" ),
				"all_items" => __( "Bookings", "uj-core-functionality" ),
				"add_new" => __( "Add new", "uj-core-functionality" ),
				"add_new_item" => __( "Add new Booking", "uj-core-functionality" ),
				"edit_item" => __( "Edit Booking", "uj-core-functionality" ),
				"new_item" => __( "New Booking", "uj-core-functionality" ),
				"view_item" => __( "View Booking", "uj-core-functionality" ),
				"view_items" => __( "View Bookings", "uj-core-functionality" ),
				"search_items" => __( "Search Bookings", "uj-core-functionality" ),
				"not_found" => __( "No Bookings found", "uj-core-functionality" ),
				"not_found_in_trash" => __( "No Bookings found in trash", "uj-core-functionality" ),
				"parent" => __( "Parent Booking:", "uj-core-functionality" ),
				"featured_image" => __( "Featured image for this Booking", "uj-core-functionality" ),
				"set_featured_image" => __( "Set featured image for this Booking", "uj-core-functionality" ),
				"remove_featured_image" => __( "Remove featured image for this Booking", "uj-core-functionality" ),
				"use_featured_image" => __( "Use as featured image for this Booking", "uj-core-functionality" ),
				"archives" => __( "Booking archives", "uj-core-functionality" ),
				"insert_into_item" => __( "Insert into Booking", "uj-core-functionality" ),
				"uploaded_to_this_item" => __( "Upload to this Booking", "uj-core-functionality" ),
				"filter_items_list" => __( "Filter Bookings list", "uj-core-functionality" ),
				"items_list_navigation" => __( "Bookings list navigation", "uj-core-functionality" ),
				"items_list" => __( "Bookings list", "uj-core-functionality" ),
				"attributes" => __( "Bookings attributes", "uj-core-functionality" ),
				"name_admin_bar" => __( "Booking", "uj-core-functionality" ),
				"item_published" => __( "Booking published", "uj-core-functionality" ),
				"item_published_privately" => __( "Booking published privately.", "uj-core-functionality" ),
				"item_reverted_to_draft" => __( "Booking reverted to draft.", "uj-core-functionality" ),
				"item_scheduled" => __( "Booking scheduled", "uj-core-functionality" ),
				"item_updated" => __( "Booking updated.", "uj-core-functionality" ),
				"parent_item_colon" => __( "Parent Booking:", "uj-core-functionality" ),
			];

			$args = [
				"label" => __( "Bookings", "uj-core-functionality" ),
				"labels" => $labels,
				"description" => "",
				"public" => true,
				"publicly_queryable" => true,
				"show_ui" => true,
				"show_in_rest" => true,
				"rest_base" => "",
				"rest_controller_class" => "WP_REST_Posts_Controller",
				"has_archive" => false,
				"show_in_menu" => "theme_options",
				"show_in_nav_menus" => true,
				"delete_with_user" => false,
				"exclude_from_search" => false,
				"capability_type" => "post",
				"map_meta_cap" => true,
				"hierarchical" => false,
				"rewrite" => [ "slug" => "booking", "with_front" => true ],
				"query_var" => true,
				"menu_icon" => "dashicons-calendar",
				"supports" => [ "title", "custom-fields" ],
				"show_in_graphql" => false,
			];

			register_post_type( "booking", $args );
		}

		if (ujcf_get_theme_option("contact_checkbox")) {

			/**
			 * Post Type: Contacts.
			 */

			$labels = [
				"name" => __( "Contacts", "uj-core-functionality" ),
				"singular_name" => __( "Contact", "uj-core-functionality" ),
				"menu_name" => __( "My Contacts", "uj-core-functionality" ),
				"all_items" => __( "Contacts", "uj-core-functionality" ),
				"add_new" => __( "Add new", "uj-core-functionality" ),
				"add_new_item" => __( "Add new Contact", "uj-core-functionality" ),
				"edit_item" => __( "Edit Contact", "uj-core-functionality" ),
				"new_item" => __( "New Contact", "uj-core-functionality" ),
				"view_item" => __( "View Contact", "uj-core-functionality" ),
				"view_items" => __( "View Contacts", "uj-core-functionality" ),
				"search_items" => __( "Search Contacts", "uj-core-functionality" ),
				"not_found" => __( "No Contacts found", "uj-core-functionality" ),
				"not_found_in_trash" => __( "No Contacts found in trash", "uj-core-functionality" ),
				"parent" => __( "Parent Contact:", "uj-core-functionality" ),
				"featured_image" => __( "Featured image for this Contact", "uj-core-functionality" ),
				"set_featured_image" => __( "Set featured image for this Contact", "uj-core-functionality" ),
				"remove_featured_image" => __( "Remove featured image for this Contact", "uj-core-functionality" ),
				"use_featured_image" => __( "Use as featured image for this Contact", "uj-core-functionality" ),
				"archives" => __( "Contact archives", "uj-core-functionality" ),
				"insert_into_item" => __( "Insert into Contact", "uj-core-functionality" ),
				"uploaded_to_this_item" => __( "Upload to this Contact", "uj-core-functionality" ),
				"filter_items_list" => __( "Filter Contacts list", "uj-core-functionality" ),
				"items_list_navigation" => __( "Contacts list navigation", "uj-core-functionality" ),
				"items_list" => __( "Contacts list", "uj-core-functionality" ),
				"attributes" => __( "Contacts attributes", "uj-core-functionality" ),
				"name_admin_bar" => __( "Contact", "uj-core-functionality" ),
				"item_published" => __( "Contact published", "uj-core-functionality" ),
				"item_published_privately" => __( "Contact published privately.", "uj-core-functionality" ),
				"item_reverted_to_draft" => __( "Contact reverted to draft.", "uj-core-functionality" ),
				"item_scheduled" => __( "Contact scheduled", "uj-core-functionality" ),
				"item_updated" => __( "Contact updated.", "uj-core-functionality" ),
				"parent_item_colon" => __( "Parent Contact:", "uj-core-functionality" ),
			];

			$args = [
				"label" => __( "Contacts", "wk-wow-child" ),
				"labels" => $labels,
				"description" => "",
				"public" => true,
				"publicly_queryable" => true,
				"show_ui" => true,
				"show_in_rest" => true,
				"rest_base" => "",
				"rest_controller_class" => "WP_REST_Posts_Controller",
				"has_archive" => false,
				"show_in_menu" => "theme_options",
				"show_in_nav_menus" => true,
				"delete_with_user" => false,
				"exclude_from_search" => false,
				"capability_type" => "post",
				"map_meta_cap" => true,
				"hierarchical" => false,
				"can_export" => false,
				"rewrite" => [ "slug" => "contact", "with_front" => true ],
				"query_var" => true,
				"menu_icon" => "dashicons-universal-access",
				"supports" => [ "title", "thumbnail", "custom-fields", "page-attributes" ],
				"taxonomies" => [ "category", "post_tag" ],
				"show_in_graphql" => false,
			];

			register_post_type( "contact", $args );
		}

		if (ujcf_get_theme_option("event_checkbox")) {
			/**
			 * Post Type: Events.
			 */

			$labels = [
				"name" => __( "Events", "uj-core-functionality" ),
				"singular_name" => __( "Event", "uj-core-functionality" ),
				"menu_name" => __( "My Events", "uj-core-functionality" ),
				"all_items" => __( "Events", "uj-core-functionality" ),
				"add_new" => __( "Add new", "uj-core-functionality" ),
				"add_new_item" => __( "Add new Event", "uj-core-functionality" ),
				"edit_item" => __( "Edit Event", "uj-core-functionality" ),
				"new_item" => __( "New Event", "uj-core-functionality" ),
				"view_item" => __( "View Event", "uj-core-functionality" ),
				"view_items" => __( "View Events", "uj-core-functionality" ),
				"search_items" => __( "Search Events", "uj-core-functionality" ),
				"not_found" => __( "No Events found", "uj-core-functionality" ),
				"not_found_in_trash" => __( "No Events found in trash", "uj-core-functionality" ),
				"parent" => __( "Parent Event:", "uj-core-functionality" ),
				"featured_image" => __( "Featured image for this Event", "uj-core-functionality" ),
				"set_featured_image" => __( "Set featured image for this Event", "uj-core-functionality" ),
				"remove_featured_image" => __( "Remove featured image for this Event", "uj-core-functionality" ),
				"use_featured_image" => __( "Use as featured image for this Event", "uj-core-functionality" ),
				"archives" => __( "Event archives", "uj-core-functionality" ),
				"insert_into_item" => __( "Insert into Event", "uj-core-functionality" ),
				"uploaded_to_this_item" => __( "Upload to this Event", "uj-core-functionality" ),
				"filter_items_list" => __( "Filter Events list", "uj-core-functionality" ),
				"items_list_navigation" => __( "Events list navigation", "uj-core-functionality" ),
				"items_list" => __( "Events list", "uj-core-functionality" ),
				"attributes" => __( "Events attributes", "uj-core-functionality" ),
				"name_admin_bar" => __( "Event", "uj-core-functionality" ),
				"item_published" => __( "Event published", "uj-core-functionality" ),
				"item_published_privately" => __( "Event published privately.", "uj-core-functionality" ),
				"item_reverted_to_draft" => __( "Event reverted to draft.", "uj-core-functionality" ),
				"item_scheduled" => __( "Event scheduled", "uj-core-functionality" ),
				"item_updated" => __( "Event updated.", "uj-core-functionality" ),
				"parent_item_colon" => __( "Parent Event:", "uj-core-functionality" ),
			];

			$args = [
				"label" => __( "Events", "uj-core-functionality" ),
				"labels" => $labels,
				"description" => "",
				"public" => true,
				"publicly_queryable" => true,
				"show_ui" => true,
				"show_in_rest" => true,
				"rest_base" => "",
				"rest_controller_class" => "WP_REST_Posts_Controller",
				"has_archive" => false,
				"show_in_menu" => "theme_options",
				"show_in_nav_menus" => true,
				"delete_with_user" => false,
				"exclude_from_search" => false,
				"capability_type" => "post",
				"map_meta_cap" => true,
				"hierarchical" => false,
				"can_export" => false,
				"rewrite" => [ "slug" => "event", "with_front" => true ],
				"query_var" => true,
				"menu_icon" => "dashicons-calendar-alt",
				"supports" => [ "title", "thumbnail", "custom-fields" ],
				"taxonomies" => [ "category", "post_tag" ],
				"show_in_graphql" => false,
			];

			register_post_type( "event", $args );
		}

		if (ujcf_get_theme_option("faq_checkbox")) {
			/**
			 * Post Type: FAQs.
			 */

			$labels = [
				"name" => __( "FAQs", "uj-core-functionality" ),
				"singular_name" => __( "FAQ", "uj-core-functionality" ),
				"menu_name" => __( "My FAQs", "uj-core-functionality" ),
				"all_items" => __( "FAQs", "uj-core-functionality" ),
				"add_new" => __( "Add new", "uj-core-functionality" ),
				"add_new_item" => __( "Add new FAQ", "uj-core-functionality" ),
				"edit_item" => __( "Edit FAQ", "uj-core-functionality" ),
				"new_item" => __( "New FAQ", "uj-core-functionality" ),
				"view_item" => __( "View FAQ", "uj-core-functionality" ),
				"view_items" => __( "View FAQs", "uj-core-functionality" ),
				"search_items" => __( "Search FAQs", "uj-core-functionality" ),
				"not_found" => __( "No FAQs found", "uj-core-functionality" ),
				"not_found_in_trash" => __( "No FAQs found in trash", "uj-core-functionality" ),
				"parent" => __( "Parent FAQ:", "uj-core-functionality" ),
				"featured_image" => __( "Featured image for this FAQ", "uj-core-functionality" ),
				"set_featured_image" => __( "Set featured image for this FAQ", "uj-core-functionality" ),
				"remove_featured_image" => __( "Remove featured image for this FAQ", "uj-core-functionality" ),
				"use_featured_image" => __( "Use as featured image for this FAQ", "uj-core-functionality" ),
				"archives" => __( "FAQ archives", "uj-core-functionality" ),
				"insert_into_item" => __( "Insert into FAQ", "uj-core-functionality" ),
				"uploaded_to_this_item" => __( "Upload to this FAQ", "uj-core-functionality" ),
				"filter_items_list" => __( "Filter FAQs list", "uj-core-functionality" ),
				"items_list_navigation" => __( "FAQs list navigation", "uj-core-functionality" ),
				"items_list" => __( "FAQs list", "uj-core-functionality" ),
				"attributes" => __( "FAQs attributes", "uj-core-functionality" ),
				"name_admin_bar" => __( "FAQ", "uj-core-functionality" ),
				"item_published" => __( "FAQ published", "uj-core-functionality" ),
				"item_published_privately" => __( "FAQ published privately.", "uj-core-functionality" ),
				"item_reverted_to_draft" => __( "FAQ reverted to draft.", "uj-core-functionality" ),
				"item_scheduled" => __( "FAQ scheduled", "uj-core-functionality" ),
				"item_updated" => __( "FAQ updated.", "uj-core-functionality" ),
				"parent_item_colon" => __( "Parent FAQ:", "uj-core-functionality" ),
			];

			$args = [
				"label" => __( "FAQs", "uj-core-functionality" ),
				"labels" => $labels,
				"description" => "",
				"public" => true,
				"publicly_queryable" => true,
				"show_ui" => true,
				"show_in_rest" => true,
				"rest_base" => "",
				"rest_controller_class" => "WP_REST_Posts_Controller",
				"has_archive" => false,
				"show_in_menu" => "theme_options",
				"show_in_nav_menus" => true,
				"delete_with_user" => false,
				"exclude_from_search" => false,
				"capability_type" => "post",
				"map_meta_cap" => true,
				"hierarchical" => false,
				"rewrite" => [ "slug" => "faq", "with_front" => true ],
				"query_var" => true,
				"menu_icon" => "dashicons-info",
				"supports" => [ "title", "thumbnail", "custom-fields", "page-attributes" ],
				"taxonomies" => [ "category", "post_tag" ],
				"show_in_graphql" => false,
			];

			register_post_type( "faq", $args );
		}

		if (ujcf_get_theme_option("fundraiser_checkbox")) {
			/**
			 * Post Type: News.
			 */
			$labels = [
				"name" => __( "Fundraiser", "uj-core-functionality" ),
				"singular_name" => __( "Fundraiser", "uj-core-functionality" ),
				"menu_name" => __( "My Fundraiser", "uj-core-functionality" ),
				"all_items" => __( "Fundraiser", "uj-core-functionality" ),
				"add_new" => __( "Add new", "uj-core-functionality" ),
				"add_new_item" => __( "Add new Fundraiser", "uj-core-functionality" ),
				"edit_item" => __( "Edit Fundraiser", "uj-core-functionality" ),
				"new_item" => __( "New Fundraiser", "uj-core-functionality" ),
				"view_item" => __( "View Fundraiser", "uj-core-functionality" ),
				"view_items" => __( "View Fundraiser", "uj-core-functionality" ),
				"search_items" => __( "Search Fundraiser", "uj-core-functionality" ),
				"not_found" => __( "No Fundraiser found", "uj-core-functionality" ),
				"not_found_in_trash" => __( "No Fundraiser found in trash", "uj-core-functionality" ),
				"parent" => __( "Parent Fundraiser:", "uj-core-functionality" ),
				"featured_image" => __( "Featured image for this Fundraiser", "uj-core-functionality" ),
				"set_featured_image" => __( "Set featured image for this Fundraiser", "uj-core-functionality" ),
				"remove_featured_image" => __( "Remove featured image for this Fundraiser", "uj-core-functionality" ),
				"use_featured_image" => __( "Use as featured image for this Fundraiser", "uj-core-functionality" ),
				"archives" => __( "Fundraiser archives", "uj-core-functionality" ),
				"insert_into_item" => __( "Insert into Fundraiser", "uj-core-functionality" ),
				"uploaded_to_this_item" => __( "Upload to this Fundraiser", "uj-core-functionality" ),
				"filter_items_list" => __( "Filter Fundraiser list", "uj-core-functionality" ),
				"items_list_navigation" => __( "Fundraiser list navigation", "uj-core-functionality" ),
				"items_list" => __( "Fundraiser list", "uj-core-functionality" ),
				"attributes" => __( "Fundraiser attributes", "uj-core-functionality" ),
				"name_admin_bar" => __( "Fundraiser", "uj-core-functionality" ),
				"item_published" => __( "Fundraiser published", "uj-core-functionality" ),
				"item_published_privately" => __( "Fundraiser published privately.", "uj-core-functionality" ),
				"item_reverted_to_draft" => __( "Fundraiser reverted to draft.", "uj-core-functionality" ),
				"item_scheduled" => __( "Fundraiser scheduled", "uj-core-functionality" ),
				"item_updated" => __( "Fundraiser updated.", "uj-core-functionality" ),
				"parent_item_colon" => __( "Parent Fundraiser:", "uj-core-functionality" ),
			];

			$args = [
				"label" => __( "Fundraiser", "uj-core-functionality" ),
				"labels" => $labels,
				"description" => "",
				"public" => true,
				"publicly_queryable" => true,
				"show_ui" => true,
				"show_in_rest" => true,
				"rest_base" => "",
				"rest_controller_class" => "WP_REST_Posts_Controller",
				"has_archive" => false,
				"show_in_menu" => "theme_options",
				"show_in_nav_menus" => true,
				"delete_with_user" => false,
				"exclude_from_search" => false,
				"capability_type" => "post",
				"map_meta_cap" => true,
				"hierarchical" => false,
				"rewrite" => [ "slug" => "fundraiser", "with_front" => true ],
				"query_var" => true,
				"menu_icon" => "dashicons-info",
				"supports" => [ "title", "thumbnail", "custom-fields", "page-attributes" ],
				"taxonomies" => [ "category", "post_tag" ],
				"show_in_graphql" => false,
			];

			register_post_type( "fundraiser", $args );
		}

		if (ujcf_get_theme_option("news_checkbox")) {
			/**
			 * Post Type: News.
			 */

			$labels = [
				"name" => __( "News", "uj-core-functionality" ),
				"singular_name" => __( "News", "uj-core-functionality" ),
				"menu_name" => __( "My News", "uj-core-functionality" ),
				"all_items" => __( "News", "uj-core-functionality" ),
				"add_new" => __( "Add new", "uj-core-functionality" ),
				"add_new_item" => __( "Add new News", "uj-core-functionality" ),
				"edit_item" => __( "Edit News", "uj-core-functionality" ),
				"new_item" => __( "New News", "uj-core-functionality" ),
				"view_item" => __( "View News", "uj-core-functionality" ),
				"view_items" => __( "View News", "uj-core-functionality" ),
				"search_items" => __( "Search News", "uj-core-functionality" ),
				"not_found" => __( "No News found", "uj-core-functionality" ),
				"not_found_in_trash" => __( "No News found in trash", "uj-core-functionality" ),
				"parent" => __( "Parent News:", "uj-core-functionality" ),
				"featured_image" => __( "Featured image for this News", "uj-core-functionality" ),
				"set_featured_image" => __( "Set featured image for this News", "uj-core-functionality" ),
				"remove_featured_image" => __( "Remove featured image for this News", "uj-core-functionality" ),
				"use_featured_image" => __( "Use as featured image for this News", "uj-core-functionality" ),
				"archives" => __( "News archives", "uj-core-functionality" ),
				"insert_into_item" => __( "Insert into News", "uj-core-functionality" ),
				"uploaded_to_this_item" => __( "Upload to this News", "uj-core-functionality" ),
				"filter_items_list" => __( "Filter News list", "uj-core-functionality" ),
				"items_list_navigation" => __( "News list navigation", "uj-core-functionality" ),
				"items_list" => __( "News list", "uj-core-functionality" ),
				"attributes" => __( "News attributes", "uj-core-functionality" ),
				"name_admin_bar" => __( "News", "uj-core-functionality" ),
				"item_published" => __( "News published", "uj-core-functionality" ),
				"item_published_privately" => __( "News published privately.", "uj-core-functionality" ),
				"item_reverted_to_draft" => __( "News reverted to draft.", "uj-core-functionality" ),
				"item_scheduled" => __( "News scheduled", "uj-core-functionality" ),
				"item_updated" => __( "News updated.", "uj-core-functionality" ),
				"parent_item_colon" => __( "Parent News:", "uj-core-functionality" ),
			];

			$args = [
				"label" => __( "News", "uj-core-functionality" ),
				"labels" => $labels,
				"description" => "",
				"public" => true,
				"publicly_queryable" => true,
				"show_ui" => true,
				"show_in_rest" => true,
				"rest_base" => "",
				"rest_controller_class" => "WP_REST_Posts_Controller",
				"has_archive" => false,
				"show_in_menu" => "theme_options",
				"show_in_nav_menus" => true,
				"delete_with_user" => false,
				"exclude_from_search" => false,
				"capability_type" => "post",
				"map_meta_cap" => true,
				"hierarchical" => false,
				"rewrite" => [ "slug" => "news", "with_front" => true ],
				"query_var" => true,
				"menu_icon" => "dashicons-info",
				"supports" => [ "title", "thumbnail", "custom-fields", "page-attributes" ],
				"taxonomies" => [ "category", "post_tag" ],
				"show_in_graphql" => false,
			];

			register_post_type( "news", $args );
		}

		if (ujcf_get_theme_option("testimonial_checkbox")) {
			/**
			 * Post Type: Testimonials.
			 */

			$labels = [
				"name" => __( "Testimonials", "uj-core-functionality" ),
				"singular_name" => __( "Testimonial", "uj-core-functionality" ),
				"menu_name" => __( "My Testimonials", "uj-core-functionality" ),
				"all_items" => __( "Testimonials", "uj-core-functionality" ),
				"add_new" => __( "Add new", "uj-core-functionality" ),
				"add_new_item" => __( "Add new Testimonial", "uj-core-functionality" ),
				"edit_item" => __( "Edit Testimonial", "uj-core-functionality" ),
				"new_item" => __( "New Testimonial", "uj-core-functionality" ),
				"view_item" => __( "View Testimonial", "uj-core-functionality" ),
				"view_items" => __( "View Testimonials", "uj-core-functionality" ),
				"search_items" => __( "Search Testimonials", "uj-core-functionality" ),
				"not_found" => __( "No Testimonials found", "uj-core-functionality" ),
				"not_found_in_trash" => __( "No Testimonials found in trash", "uj-core-functionality" ),
				"parent" => __( "Parent Testimonial:", "uj-core-functionality" ),
				"featured_image" => __( "Featured image for this Testimonial", "uj-core-functionality" ),
				"set_featured_image" => __( "Set featured image for this Testimonial", "uj-core-functionality" ),
				"remove_featured_image" => __( "Remove featured image for this Testimonial", "uj-core-functionality" ),
				"use_featured_image" => __( "Use as featured image for this Testimonial", "uj-core-functionality" ),
				"archives" => __( "Testimonial archives", "uj-core-functionality" ),
				"insert_into_item" => __( "Insert into Testimonial", "uj-core-functionality" ),
				"uploaded_to_this_item" => __( "Upload to this Testimonial", "uj-core-functionality" ),
				"filter_items_list" => __( "Filter Testimonials list", "uj-core-functionality" ),
				"items_list_navigation" => __( "Testimonials list navigation", "uj-core-functionality" ),
				"items_list" => __( "Testimonials list", "uj-core-functionality" ),
				"attributes" => __( "Testimonials attributes", "uj-core-functionality" ),
				"name_admin_bar" => __( "Testimonial", "uj-core-functionality" ),
				"item_published" => __( "Testimonial published", "uj-core-functionality" ),
				"item_published_privately" => __( "Testimonial published privately.", "uj-core-functionality" ),
				"item_reverted_to_draft" => __( "Testimonial reverted to draft.", "uj-core-functionality" ),
				"item_scheduled" => __( "Testimonial scheduled", "uj-core-functionality" ),
				"item_updated" => __( "Testimonial updated.", "uj-core-functionality" ),
				"parent_item_colon" => __( "Parent Testimonial:", "uj-core-functionality" ),
			];

			$args = [
				"label" => __( "Testimonials", "uj-core-functionality" ),
				"labels" => $labels,
				"description" => "",
				"public" => true,
				"publicly_queryable" => true,
				"show_ui" => true,
				"show_in_rest" => true,
				"rest_base" => "",
				"rest_controller_class" => "WP_REST_Posts_Controller",
				"has_archive" => false,
				"show_in_menu" => "theme_options",
				"show_in_nav_menus" => true,
				"delete_with_user" => false,
				"exclude_from_search" => false,
				"capability_type" => "post",
				"map_meta_cap" => true,
				"hierarchical" => false,
				"rewrite" => [ "slug" => "testimonial", "with_front" => true ],
				"query_var" => true,
				"menu_icon" => "dashicons-testimonial",
				"supports" => [ "title", "custom-fields", "page-attributes" ],
				"taxonomies" => [ "category", "post_tag" ],
				"show_in_graphql" => false,
			];

			register_post_type( "testimonial", $args );
		}
	}

	if ( is_admin() ) {
		add_action( 'init', 'cptui_register_my_cpts' );
	}
}
