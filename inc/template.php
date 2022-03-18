<?php
/**
 * Child Template Shortcodes
 *
 * @package      CoreFunctionality
 * @author       Uwe Jacobs
 * @since        1.0.0
 * @license      GPL-2.0+
**/

if (!defined('ABSPATH')) exit; // Exit if accessed directly

if (!function_exists('ujcfe_getSiteOwnerCompany')) {
	function ujcfe_getSiteOwnerCompany($atts) {
		return get_theme_mod("site_owner_company_setting");
	}
	add_shortcode("cts_site_owner_company", "ujcfe_getSiteOwnerCompany");
}

if (!function_exists('ujcfe_getSiteOwnerEmail')) {
	function ujcfe_getSiteOwnerEmail($atts) {
		$email = get_theme_mod("site_owner_email_setting");

		return ujcfe_formatEmail($email);
	}
	add_shortcode("cts_site_owner_email", "ujcfe_getSiteOwnerEmail");
}

if (!function_exists('ujcfe_getSiteOwnerPhone')) {
	function ujcfe_getSiteOwnerPhone($atts) {
		$phone = get_theme_mod("site_owner_phone_setting");
		
		return ujcfe_formatPhone($phone);
	}
	add_shortcode("cts_site_owner_phone", "ujcfe_getSiteOwnerPhone");
}

if (!function_exists('ujcfe_getSiteOwnerLocationAddress')) {
	function ujcfe_getSiteOwnerLocationAddress($atts) {
		return str_replace("\n", '<br>', get_theme_mod("site_owner_location_address_setting"));
	}
	add_shortcode("cts_site_owner_location_address", "ujcfe_getSiteOwnerLocationAddress");
}

if (!function_exists('ujcfe_getSiteOwnerMailingAddress')) {
	function ujcfe_getSiteOwnerMailingAddress($atts) {
		$address = get_theme_mod("site_owner_mailing_address_setting");
		if (!empty($address)) {
			return str_replace("\n", '<br>', $address);
		}
		
		return ujcfe_getSiteOwnerLocationAddress($atts);
	}
	add_shortcode("cts_site_owner_mailing_address", "ujcfe_getSiteOwnerMailingAddress");
}

if (!function_exists('ujcfe_getFullLocationAddress')) {
	function ujcfe_getFullLocationAddress($atts) {
		$s = '<div class="location-address">';
		$s .= '[cts_site_owner_company]<br />';
		$s .= '[cts_site_owner_location_address]<br />';
		$s .= '[cts_site_owner_email]<br />';
		$s .= '[cts_site_owner_phone]';
		$s .= '</div>';
		
		return do_shortcode($s);
	}
	add_shortcode("cts_full_location_address", "ujcfe_getFullLocationAddress");
}

if (!function_exists('ujcfe_getSiteOwnerContact1')) {
	function ujcfe_getSiteOwnerContact1($atts) {
		return get_theme_mod("site_owner_contact1_setting");
	}
	add_shortcode("cts_site_owner_contact1", "ujcfe_getSiteOwnerContact1");
}

if (!function_exists('ujcfe_getSiteOwnerContact1Email')) {
	function ujcfe_getSiteOwnerContact1Email($atts) {
		$email = get_theme_mod("site_owner_contact1_email_setting");

		return ujcfe_formatEmail($email);
	}
	add_shortcode("cts_site_owner_contact1_email", "ujcfe_getSiteOwnerContact1Email");
}

if (!function_exists('ujcfe_getSiteOwnerContact1Phone')) {
	function ujcfe_getSiteOwnerContact1Phone($atts) {
		$phone = get_theme_mod("site_owner_contact1_phone_setting");
		
		return ujcfe_formatPhone($phone);
	}
	add_shortcode("cts_site_owner_contact1_phone", "ujcfe_getSiteOwnerContact1Phone");
}

if (!function_exists('ujcfe_getSiteOwnerContact2')) {
	function ujcfe_getSiteOwnerContact2($atts) {
		return get_theme_mod("site_owner_contact2_setting");
	}
	add_shortcode("cts_site_owner_contact2", "ujcfe_getSiteOwnerContact2");
}

if (!function_exists('ujcfe_getSiteOwnerContact2Email')) {
	function ujcfe_getSiteOwnerContact2Email($atts) {
		$email = get_theme_mod("site_owner_contact2_email_setting");

		return ujcfe_formatEmail($email);
	}
	add_shortcode("cts_site_owner_contact2_email", "ujcfe_getSiteOwnerContact2Email");
}

if (!function_exists('ujcfe_getSiteOwnerContact2Phone')) {
	function ujcfe_getSiteOwnerContact2Phone($atts) {
		$phone = get_theme_mod("site_owner_contact2_phone_setting");
		
		return ujcfe_formatPhone($phone);
	}
	add_shortcode("cts_site_owner_contact2_phone", "ujcfe_getSiteOwnerContact2Phone");
}

if (!function_exists('ujcfe_getSiteOwnerContact3')) {
	function ujcfe_getSiteOwnerContact3($atts) {
		return get_theme_mod("site_owner_contact3_setting");
	}
	add_shortcode("cts_site_owner_contact3", "ujcfe_getSiteOwnerContact3");
}

if (!function_exists('ujcfe_getSiteOwnerContact3Email')) {
	function ujcfe_getSiteOwnerContact3Email($atts) {
		$email = get_theme_mod("site_owner_contact3_email_setting");

		return ujcfe_formatEmail($email);
	}
	add_shortcode("cts_site_owner_contact3_email", "ujcfe_getSiteOwnerContact3Email");
}

if (!function_exists('ujcfe_getSiteOwnerContact3Phone')) {
	function ujcfe_getSiteOwnerContact3Phone($atts) {
		$phone = get_theme_mod("site_owner_contact3_phone_setting");
		
		return ujcfe_formatPhone($phone);
	}
	add_shortcode("cts_site_owner_contact3_phone", "ujcfe_getSiteOwnerContact3Phone");
}

if (!function_exists('ujcfe_getFullContacts')) {
	function ujcfe_getFullContacts($atts) {
		$s = '<div class="contacts">';
		$contacts = [];
		for ($i=1; $i<=3; $i++) {
			$contacts[] = array (
			'name' => do_shortcode('[cts_site_owner_contact'.$i.']'),
			'email' => do_shortcode('[cts_site_owner_contact'.$i.'_email]'),
			'phone' => do_shortcode('[cts_site_owner_contact'.$i.'_phone]')
			);
		}
		
		foreach($contacts as $contact) {
			if (!empty($contact['name'])) {
				$s .= '<div class="contact">';
				if (!empty($contact['name'])) {
					$s .= '<span class="mr-2">' . $contact['name'] . '</span>';
					$s .= '<br class="d-md-block d-lg-none d-none" />';			
				}
				if (!empty($contact['email'])) {
					$s .= '<span class="mr-2">' . $contact['email'] . '</span>';
					$s .= '<br class="d-md-block d-lg-none d-none" />';			
				}
				if (!empty($contact['phone'])) {
					$s .= '<span>' . $contact['phone'] . '</span>';
				}
				$s .= '</div>';
			}
		}
		
		$s .= '</div>';
		
		return do_shortcode($s);
	}
	add_shortcode("cts_full_contacts", "ujcfe_getFullContacts");
}

if (!function_exists('ujcfe_getGoogleMyBusinessIcon')) {
	function ujcfe_getGoogleMyBusinessIcon($atts) {
		$url = get_theme_mod("social_google_my_business_setting");
		$s = '';
		if (!empty($url)) {
			$s = '<a class="mx-2" href="' . esc_url_raw($url) . '" target="_blank" rel="noopener" data-target="tooltip" title="Google My Business"><svg height="48px" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 1600 1600"><defs><style>.cls-1{fill:#fff;}.cls-2{fill:#4989f5;}.cls-3{fill:url(#linear-gradient-gmb);}.cls-4,.cls-8{fill:#3c4ba6;}.cls-5{fill:#7babf7;}.cls-6{fill:#3f51b5;}.cls-7{fill:#709be0;}.cls-7,.cls-8{fill-rule:evenodd;}</style><linearGradient id="linear-gradien-gmbt" x1="321.97" y1="913.43" x2="1251.93" y2="913.43" gradientUnits="userSpaceOnUse"><stop offset="0.03" stop-color="#4079d8"/><stop offset="1" stop-color="#4989f5"/></linearGradient></defs><rect class="cls-2" x="321.45" y="567.98" width="931" height="696.14" rx="36.88" ry="36.88"/><path class="cls-3" d="M1204.81,562.75H368.06c-25.92,0-46.09,200.6-46.09,226.52L780.2,1264.12h424.61a47.26,47.26,0,0,0,47.13-47.13V609.87A47.26,47.26,0,0,0,1204.81,562.75Z"/><polygon class="cls-4" points="534.03 684.56 800.03 684.56 800.03 335.44 573.86 335.44 534.03 684.56"/><polygon class="cls-5" points="1066.03 684.56 800.03 684.56 800.03 335.44 1026.2 335.44 1066.03 684.56"/><path class="cls-5" d="M1252.45,401.62l.33,1.19C1252.7,402.39,1252.54,402,1252.45,401.62Z"/><path class="cls-6" d="M1252.78,402.8l-.33-1.19a84.13,84.13,0,0,0-82.14-66.18H1026.2L1066,684.56h266Z"/><path class="cls-5" d="M347.61,401.62l-.33,1.19C347.36,402.39,347.52,402,347.61,401.62Z"/><path class="cls-5" d="M347.27,402.8l.33-1.19a84.13,84.13,0,0,1,82.14-66.18H573.86L534,684.56H268Z"/><path class="cls-7" d="M534.48,684.47a132.92,132.92,0,0,1-265.85,0Z"/><path class="cls-8" d="M800.33,684.47a132.92,132.92,0,0,1-265.85,0Z"/><path class="cls-7" d="M1066.18,684.47a132.92,132.92,0,0,1-265.85,0Z"/><path class="cls-8" d="M1332,684.47a132.92,132.92,0,1,1-265.85,0Z"/><path class="cls-1" d="M1199.08,1044.6c-.47-6.33-1.25-12.11-2.36-19.49h-145c0,20.28,0,42.41-.08,62.7h84a73.05,73.05,0,0,1-30.75,46.89s0-.35-.06-.36a88,88,0,0,1-34,13.27,99.85,99.85,0,0,1-36.79-.16,91.9,91.9,0,0,1-34.31-14.87A95.72,95.72,0,0,1,966,1089.48c-.52-1.35-1-2.71-1.49-4.09l0-.15.13-.1a93,93,0,0,1-.05-59.84A96.27,96.27,0,0,1,986.9,989a90.63,90.63,0,0,1,91.32-23.78,83,83,0,0,1,33.23,19.56l28.34-28.34c5-5.05,10.19-9.94,15-15.16l0,0,0,0a149.78,149.78,0,0,0-49.64-30.74,156.08,156.08,0,0,0-103.83-.91q-1.76.6-3.5,1.25A155.18,155.18,0,0,0,914,986a152.61,152.61,0,0,0-13.42,38.78,154.25,154.25,0,0,0,111.21,179.4c25.69,6.88,53,6.71,78.89.83a139.88,139.88,0,0,0,63.14-32.81c18.64-17.15,32-40,39-64.27A179,179,0,0,0,1199.08,1044.6Z"/></svg></a>';
		}
		return do_shortcode($s);
	}
	add_shortcode("cts_social_google_my_business", "ujcfe_getGoogleMyBusinessIcon");
}

if (!function_exists('ujcfe_getFacebookIcon')) {
	function ujcfe_getFacebookIcon($atts) {
		$url = get_theme_mod("social_facebook_setting");
		$s = '';
		if (!empty($url)) {
			$s = '<a class="mx-2" href="' . esc_url_raw($url) . '" target="_blank" rel="noopener" data-target="tooltip" title="Facebook"><svg height="28px" viewBox="0 0 256 256" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" preserveAspectRatio="xMidYMid">
		<g>
			<path d="M241.871,256.001 C249.673,256.001 256,249.675 256,241.872 L256,14.129 C256,6.325 249.673,0 241.871,0 L14.129,0 C6.324,0 0,6.325 0,14.129 L0,241.872 C0,249.675 6.324,256.001 14.129,256.001 L241.871,256.001" fill="#395185"></path>
			<path d="M176.635,256.001 L176.635,156.864 L209.912,156.864 L214.894,118.229 L176.635,118.229 L176.635,93.561 C176.635,82.375 179.742,74.752 195.783,74.752 L216.242,74.743 L216.242,40.188 C212.702,39.717 200.558,38.665 186.43,38.665 C156.932,38.665 136.738,56.67 136.738,89.736 L136.738,118.229 L103.376,118.229 L103.376,156.864 L136.738,156.864 L136.738,256.001 L176.635,256.001" fill="#FFFFFF"></path>
		</g>
	</svg></a>';
		}
		return do_shortcode($s);
	}
	add_shortcode("cts_social_facebook", "ujcfe_getFacebookIcon");
}

if (!function_exists('ujcfe_getBingPlacesIcon')) {
	function ujcfe_getBingPlacesIcon($atts) {
		$url = get_theme_mod("social_bing_places_setting");
		$s = '';
		if (!empty($url)) {
			$s = '<a class="mx-2" href="' . esc_url_raw($url) . '" target="_blank" rel="noopener" data-target="tooltip" title="Microsoft Bing Places"><svg viewBox="-29.62167543756803 0.1 574.391675437568 799.8100000000002" xmlns="http://www.w3.org/2000/svg" height="28px"><linearGradient id="a-mbp" gradientUnits="userSpaceOnUse" x1="286.383" x2="542.057" y1="284.169" y2="569.112"><stop offset="0" stop-color="#37bdff"/><stop offset=".25" stop-color="#26c6f4"/><stop offset=".5" stop-color="#15d0e9"/><stop offset=".75" stop-color="#3bd6df"/><stop offset="1" stop-color="#62dcd4"/></linearGradient><linearGradient id="b-mbp" gradientUnits="userSpaceOnUse" x1="108.979" x2="100.756" y1="675.98" y2="43.669"><stop offset="0" stop-color="#1b48ef"/><stop offset=".5" stop-color="#2080f1"/><stop offset="1" stop-color="#26b8f4"/></linearGradient><linearGradient id="c-mbp" gradientUnits="userSpaceOnUse" x1="256.823" x2="875.632" y1="649.719" y2="649.719"><stop offset="0" stop-color="#39d2ff"/><stop offset=".5" stop-color="#248ffa"/><stop offset="1" stop-color="#104cf5"/></linearGradient><linearGradient id="d-mbp" gradientUnits="userSpaceOnUse" x1="256.823" x2="875.632" y1="649.719" y2="649.719"><stop offset="0" stop-color="#fff"/><stop offset="1"/></linearGradient><path d="M249.97 277.48c-.12.96-.12 2.05-.12 3.12 0 4.16.83 8.16 2.33 11.84l1.34 2.76 5.3 13.56 27.53 70.23 24.01 61.33c6.85 12.38 17.82 22.1 31.05 27.28l4.11 1.51c.16.05.43.05.65.11l65.81 22.63v.05l25.16 8.64 1.72.58c.06 0 .16.06.22.06 4.96 1.25 9.82 2.93 14.46 4.98 10.73 4.63 20.46 11.23 28.77 19.28 3.35 3.2 6.43 6.65 9.28 10.33a88.64 88.64 0 0 1 6.64 9.72c8.78 14.58 13.82 31.72 13.82 49.97 0 3.26-.16 6.41-.49 9.61-.11 1.41-.28 2.77-.49 4.12v.11c-.22 1.43-.49 2.91-.76 4.36-.28 1.41-.54 2.81-.86 4.21-.05.16-.11.33-.17.49-.3 1.42-.68 2.82-1.07 4.23-.35 1.33-.79 2.7-1.28 3.99a42.96 42.96 0 0 1-1.51 4.16c-.49 1.4-1.07 2.82-1.72 4.16-1.78 4.11-3.9 8.06-6.28 11.83a97.889 97.889 0 0 1-10.47 13.95c30.88-33.2 51.41-76.07 56.52-123.51.86-7.78 1.3-15.67 1.3-23.61 0-5.07-.22-10.09-.55-15.13-3.89-56.89-29.79-107.77-69.32-144.08-10.9-10.09-22.81-19.07-35.62-26.69l-24.2-12.37-122.63-62.93a30.15 30.15 0 0 0-11.93-2.44c-15.88 0-28.99 12.11-30.55 27.56z" fill="#7f7f7f"/><path d="M249.97 277.48c-.12.96-.12 2.05-.12 3.12 0 4.16.83 8.16 2.33 11.84l1.34 2.76 5.3 13.56 27.53 70.23 24.01 61.33c6.85 12.38 17.82 22.1 31.05 27.28l4.11 1.51c.16.05.43.05.65.11l65.81 22.63v.05l25.16 8.64 1.72.58c.06 0 .16.06.22.06 4.96 1.25 9.82 2.93 14.46 4.98 10.73 4.63 20.46 11.23 28.77 19.28 3.35 3.2 6.43 6.65 9.28 10.33a88.64 88.64 0 0 1 6.64 9.72c8.78 14.58 13.82 31.72 13.82 49.97 0 3.26-.16 6.41-.49 9.61-.11 1.41-.28 2.77-.49 4.12v.11c-.22 1.43-.49 2.91-.76 4.36-.28 1.41-.54 2.81-.86 4.21-.05.16-.11.33-.17.49-.3 1.42-.68 2.82-1.07 4.23-.35 1.33-.79 2.7-1.28 3.99a42.96 42.96 0 0 1-1.51 4.16c-.49 1.4-1.07 2.82-1.72 4.16-1.78 4.11-3.9 8.06-6.28 11.83a97.889 97.889 0 0 1-10.47 13.95c30.88-33.2 51.41-76.07 56.52-123.51.86-7.78 1.3-15.67 1.3-23.61 0-5.07-.22-10.09-.55-15.13-3.89-56.89-29.79-107.77-69.32-144.08-10.9-10.09-22.81-19.07-35.62-26.69l-24.2-12.37-122.63-62.93a30.15 30.15 0 0 0-11.93-2.44c-15.88 0-28.99 12.11-30.55 27.56z" fill="url(#a-mbp)"/><path d="M31.62.1C14.17.41.16 14.69.16 32.15v559.06c.07 3.9.29 7.75.57 11.66.25 2.06.52 4.2.9 6.28 7.97 44.87 47.01 78.92 94.15 78.92 16.53 0 32.03-4.21 45.59-11.53.08-.06.22-.14.29-.14l4.88-2.95 19.78-11.64 25.16-14.93.06-496.73c0-33.01-16.52-62.11-41.81-79.4-.6-.36-1.18-.74-1.71-1.17L50.12 5.56C45.16 2.28 39.18.22 32.77.1z" fill="#7f7f7f"/><path d="M31.62.1C14.17.41.16 14.69.16 32.15v559.06c.07 3.9.29 7.75.57 11.66.25 2.06.52 4.2.9 6.28 7.97 44.87 47.01 78.92 94.15 78.92 16.53 0 32.03-4.21 45.59-11.53.08-.06.22-.14.29-.14l4.88-2.95 19.78-11.64 25.16-14.93.06-496.73c0-33.01-16.52-62.11-41.81-79.4-.6-.36-1.18-.74-1.71-1.17L50.12 5.56C45.16 2.28 39.18.22 32.77.1z" fill="url(#b-mbp)"/><path d="M419.81 510.84L194.72 644.26l-3.24 1.95v.71l-25.16 14.9-19.77 11.67-4.85 2.93-.33.16c-13.53 7.35-29.04 11.51-45.56 11.51-47.13 0-86.22-34.03-94.16-78.92 3.77 32.84 14.96 63.41 31.84 90.04 34.76 54.87 93.54 93.04 161.54 99.67h41.58c36.78-3.84 67.49-18.57 99.77-38.46l49.64-30.36c22.36-14.33 83.05-49.58 100.93-69.36 3.89-4.33 7.4-8.97 10.47-13.94 2.38-3.78 4.5-7.73 6.28-11.84.6-1.4 1.17-2.76 1.72-4.15.52-1.38 1.01-2.77 1.51-4.18.93-2.7 1.67-5.41 2.38-8.2.36-1.59.69-3.16 1.02-4.72 1.08-5.89 1.67-11.94 1.67-18.21 0-18.25-5.04-35.39-13.77-49.95-2-3.4-4.2-6.65-6.64-9.72-2.85-3.7-5.93-7.13-9.28-10.33-8.31-8.05-18.01-14.65-28.77-19.29-4.64-2.05-9.48-3.74-14.46-4.97-.06 0-.16-.06-.22-.06l-1.72-.58z" fill="#7f7f7f"/><path d="M419.81 510.84L194.72 644.26l-3.24 1.95v.71l-25.16 14.9-19.77 11.67-4.85 2.93-.33.16c-13.53 7.35-29.04 11.51-45.56 11.51-47.13 0-86.22-34.03-94.16-78.92 3.77 32.84 14.96 63.41 31.84 90.04 34.76 54.87 93.54 93.04 161.54 99.67h41.58c36.78-3.84 67.49-18.57 99.77-38.46l49.64-30.36c22.36-14.33 83.05-49.58 100.93-69.36 3.89-4.33 7.4-8.97 10.47-13.94 2.38-3.78 4.5-7.73 6.28-11.84.6-1.4 1.17-2.76 1.72-4.15.52-1.38 1.01-2.77 1.51-4.18.93-2.7 1.67-5.41 2.38-8.2.36-1.59.69-3.16 1.02-4.72 1.08-5.89 1.67-11.94 1.67-18.21 0-18.25-5.04-35.39-13.77-49.95-2-3.4-4.2-6.65-6.64-9.72-2.85-3.7-5.93-7.13-9.28-10.33-8.31-8.05-18.01-14.65-28.77-19.29-4.64-2.05-9.48-3.74-14.46-4.97-.06 0-.16-.06-.22-.06l-1.72-.58z" fill="url(#c-mbp)"/><path d="M512 595.46c0 6.27-.59 12.33-1.68 18.22-.32 1.56-.65 3.12-1.02 4.7-.7 2.8-1.44 5.51-2.37 8.22-.49 1.4-.99 2.8-1.51 4.16-.54 1.4-1.12 2.76-1.73 4.16a87.873 87.873 0 0 1-6.26 11.83 96.567 96.567 0 0 1-10.48 13.94c-17.88 19.79-78.57 55.04-100.93 69.37l-49.64 30.36c-36.39 22.42-70.77 38.29-114.13 39.38-2.05.06-4.06.11-6.05.11-2.8 0-5.56-.05-8.33-.16-73.42-2.8-137.45-42.25-174.38-100.54a213.368 213.368 0 0 1-31.84-90.04c7.94 44.89 47.03 78.92 94.16 78.92 16.52 0 32.03-4.17 45.56-11.51l.33-.17 4.85-2.92 19.77-11.67 25.16-14.9v-.71l3.24-1.95 225.09-133.43 17.33-10.27 1.72.58c.05 0 .16.06.22.06 4.98 1.23 9.83 2.92 14.46 4.97 10.76 4.64 20.45 11.24 28.77 19.29a92.13 92.13 0 0 1 9.28 10.33c2.44 3.07 4.64 6.32 6.64 9.72 8.73 14.56 13.77 31.7 13.77 49.95z" fill="#7f7f7f" opacity=".15"/><path d="M512 595.46c0 6.27-.59 12.33-1.68 18.22-.32 1.56-.65 3.12-1.02 4.7-.7 2.8-1.44 5.51-2.37 8.22-.49 1.4-.99 2.8-1.51 4.16-.54 1.4-1.12 2.76-1.73 4.16a87.873 87.873 0 0 1-6.26 11.83 96.567 96.567 0 0 1-10.48 13.94c-17.88 19.79-78.57 55.04-100.93 69.37l-49.64 30.36c-36.39 22.42-70.77 38.29-114.13 39.38-2.05.06-4.06.11-6.05.11-2.8 0-5.56-.05-8.33-.16-73.42-2.8-137.45-42.25-174.38-100.54a213.368 213.368 0 0 1-31.84-90.04c7.94 44.89 47.03 78.92 94.16 78.92 16.52 0 32.03-4.17 45.56-11.51l.33-.17 4.85-2.92 19.77-11.67 25.16-14.9v-.71l3.24-1.95 225.09-133.43 17.33-10.27 1.72.58c.05 0 .16.06.22.06 4.98 1.23 9.83 2.92 14.46 4.97 10.76 4.64 20.45 11.24 28.77 19.29a92.13 92.13 0 0 1 9.28 10.33c2.44 3.07 4.64 6.32 6.64 9.72 8.73 14.56 13.77 31.7 13.77 49.95z" fill="url(#d-mbp)" opacity=".15"/></svg></a>';
		}
		return do_shortcode($s);
	}
	add_shortcode("cts_social_bing_places", "ujcfe_getBingPlacesIcon");
}

if (!function_exists('ujcfe_getYelpIcon')) {
	function ujcfe_getYelpIcon($atts) {
		$url = get_theme_mod("social_yelp_setting");
		$s = '';
		if (!empty($url)) {
			$s = '<a class="mx-2" href="' . esc_url_raw($url) . '" target="_blank" rel="noopener" data-target="tooltip" title="Yelp"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 926.7 1220" height="28"><style>.st0{fill:#bf2519}</style><path class="st0" d="M23.6 587.4C3.8 619.1-4.5 718.8 2.4 784.9c2.4 21.8 6.4 40 12.1 50.9 7.9 15 21.2 24 36.3 24.5 9.7.5 15.8-1.2 198.3-59.9 0 0 81.1-25.9 81.5-26.1 20.2-5.2 33.9-23.8 35.2-47.5 1.3-24.4-11.2-45.9-32-53.6 0 0-57.2-23.3-57.3-23.3-196.2-80.9-205-84.1-214.9-84.2-15.2-.5-28.6 7.1-38 21.7m438.8 602.9c3.2-9.2 3.6-15.5 4.1-207.3 0 0 .4-84.7.5-85.6 1.3-20.8-12.1-39.7-34.1-48.2-22.7-8.7-47.1-3.3-60.8 13.7 0 0-40 47.5-40.2 47.5-137.4 161.4-143.2 168.9-146.5 178.4-2.1 5.6-2.8 11.6-2.2 17.6.8 8.6 4.7 17 11.1 24.9 31.9 37.9 184.7 94.1 233.5 85.7 17.1-2.9 29.4-12.4 34.6-26.7m310.1-66.7c46.1-18.4 146.6-146.2 153.7-195.5 2.5-17.1-2.9-31.9-14.7-41.3-7.7-5.8-13.6-8.1-196.1-68 0 0-80-26.4-81.1-26.9-19.4-7.5-41.5-.5-56.3 17.8-15.5 18.8-17.8 43.7-5.4 62.4l32.2 52.4c108.3 175.9 116.6 188.3 124.4 194.4 12 9.5 27.3 11.1 43.3 4.7m-94.3-452.8c207.3-50.2 215.4-52.9 223.5-58.3 12.6-8.5 18.9-22.6 17.8-39.8 0-.5.1-1.1 0-1.7-5.3-51-94.5-183.4-138.5-204.9-15.6-7.5-31.2-7-44.1 1.7-8 5.2-13.9 13.1-124.9 165 0 0-50.1 68.3-50.7 69-13.2 16.1-13.4 39.1-.5 58.9 13.4 20.5 36 30.4 56.7 24.7 0 0-.8 1.5-1 1.7 10.2-3.9 28.4-8.4 61.7-16.3M470.1 499.6c-3.6-82.2-28.3-448.1-31.2-465-4.2-15.4-16.2-26.3-33.4-30.7-53-13.1-255.3 43.6-292.8 82.2-12.1 12.6-16.5 28-12.9 41.7 5.9 12.1 256.6 406.5 256.6 406.5 37 60.1 67.3 50.7 77.2 47.6 9.8-2.9 39.9-12.3 36.5-82.3"/></svg></a>';
		}
		return do_shortcode($s);
	}
	add_shortcode("cts_social_yelp", "ujcfe_getYelpIcon");
}

if (!function_exists('ujcfe_getInstagramIcon')) {
	function ujcfe_getInstagramIcon($atts) {
		$url = get_theme_mod("social_instagram_setting");
		$s = '';
		if (!empty($url)) {
			$s = '<a class="mx-2" href="' . esc_url_raw($url) . '" target="_blank" rel="noopener" data-target="tooltip" title="Instagram"><svg height="28px" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
		 viewBox="0 0 500 500" style="enable-background:new 0 0 500 500;" xml:space="preserve">
	<style type="text/css">
		.st0{fill:url(#SVGID_1__in);}
		.st1{fill:url(#SVGID_2__in);}
		.st2{fill:#BC30A0;}
		.st3{fill:url(#SVGID_3__in);}
	</style>
	<g>
		<g>
			
				<linearGradient id="SVGID_1__in" gradientUnits="userSpaceOnUse" x1="422.7381" y1="463.5972" x2="61.3533" y2="20.564" gradientTransform="matrix(1 0 0 -1 0 502)">
				<stop  offset="0" style="stop-color:#AE3DAE"/>
				<stop  offset="4.687214e-02" style="stop-color:#B23BA6"/>
				<stop  offset="0.1216" style="stop-color:#BD368E"/>
				<stop  offset="0.2148" style="stop-color:#CE2E69"/>
				<stop  offset="0.3216" style="stop-color:#E62335"/>
				<stop  offset="0.418" style="stop-color:#FF1800"/>
			</linearGradient>
			<path class="st0" d="M498.5,147c-1.2-26.6-5.5-44.8-11.6-60.7c-6.4-16.4-14.9-30.4-28.8-44.2s-27.8-22.5-44.2-28.8
				c-15.9-6.2-34.1-10.4-60.7-11.6c-26.7-1.2-35.2-1.5-103-1.5c-67.9,0-76.4,0.3-103,1.5s-44.8,5.5-60.7,11.6
				C70,19.7,56,28.2,42.2,42.1S19.7,69.9,13.4,86.3C7.3,102.2,3,120.4,1.8,147c-1.2,26.7-1.5,35.2-1.5,103c0,67.9,0.3,76.4,1.5,103
				c1.2,26.6,5.5,44.8,11.6,60.7c6.4,16.4,14.9,30.4,28.8,44.2C56,471.8,70,480.4,86.4,486.7c15.9,6.2,34.1,10.4,60.7,11.6
				c26.7,1.2,35.2,1.5,103,1.5c67.9,0,76.4-0.3,103-1.5c26.6-1.2,44.8-5.5,60.7-11.6c16.4-6.4,30.4-14.9,44.2-28.8
				s22.5-27.8,28.8-44.2c6.2-15.9,10.4-34.1,11.6-60.7c1.2-26.7,1.5-35.2,1.5-103S499.7,173.6,498.5,147z M453.6,351
				c-1.1,24.4-5.2,37.7-8.6,46.4c-4.5,11.6-10,20-18.8,28.8s-17.1,14.1-28.8,18.8c-8.8,3.4-22.1,7.5-46.4,8.6
				c-26.3,1.2-34.2,1.5-101,1.5s-74.7-0.3-101-1.5c-24.4-1.1-37.7-5.2-46.4-8.6c-11.6-4.5-20-10-28.8-18.8
				c-8.8-8.8-14.1-17.1-18.8-28.8c-3.4-8.8-7.5-22.1-8.6-46.4c-1.2-26.3-1.5-34.2-1.5-101s0.3-74.7,1.5-101
				c1.1-24.4,5.2-37.7,8.6-46.4c4.5-11.6,10-20,18.8-28.8c8.8-8.8,17.1-14.1,28.8-18.8c8.8-3.4,22.1-7.5,46.4-8.6
				c26.3-1.2,34.2-1.5,101-1.5s74.7,0.3,101,1.5c24.4,1.1,37.7,5.2,46.4,8.6c11.6,4.5,20,10,28.8,18.8s14.1,17.1,18.8,28.8
				c3.4,8.8,7.5,22.1,8.6,46.4c1.2,26.3,1.5,34.2,1.5,101S454.7,324.7,453.6,351z"/>
			
				<linearGradient id="SVGID_2__in" gradientUnits="userSpaceOnUse" x1="311.2346" y1="354.983" x2="179.9739" y2="134.2875" gradientTransform="matrix(1 0 0 -1 0 502)">
				<stop  offset="0" style="stop-color:#E12F6A"/>
				<stop  offset="0.1705" style="stop-color:#EA3751"/>
				<stop  offset="0.3563" style="stop-color:#F13D3E"/>
				<stop  offset="0.5467" style="stop-color:#F64133"/>
				<stop  offset="0.7469" style="stop-color:#F7422F"/>
				<stop  offset="0.7946" style="stop-color:#F74C2F"/>
				<stop  offset="0.8743" style="stop-color:#F7652F"/>
				<stop  offset="0.9757" style="stop-color:#F78F2E"/>
				<stop  offset="1" style="stop-color:#F79A2E"/>
			</linearGradient>
			<path class="st1" d="M250,121.6c-71,0-128.4,57.5-128.4,128.4c0,71,57.5,128.4,128.4,128.4S378.4,320.8,378.4,250
				C378.4,179,321,121.6,250,121.6z M250,333.3c-46,0-83.3-37.3-83.3-83.3s37.3-83.3,83.3-83.3s83.3,37.3,83.3,83.3
				S296,333.3,250,333.3z"/>
			<circle class="st2" cx="383.4" cy="116.6" r="30"/>
		</g>
		
			<linearGradient id="SVGID_3__in" gradientUnits="userSpaceOnUse" x1="-431.2209" y1="522.3675" x2="-210.1535" y2="-4.8958" gradientTransform="matrix(-1 0 0 -1 -68 502)">
			<stop  offset="0.2341" style="stop-color:#9E35A5;stop-opacity:0"/>
			<stop  offset="0.4512" style="stop-color:#D42F7F;stop-opacity:0.5"/>
			<stop  offset="0.7524" style="stop-color:#F7772E"/>
			<stop  offset="0.9624" style="stop-color:#FEF780"/>
		</linearGradient>
		<path class="st3" d="M0,250c0,67.9,0.3,76.4,1.5,103c1.2,26.6,5.5,44.8,11.6,60.7c6.4,16.4,14.9,30.4,28.8,44.2
			c13.8,13.8,27.8,22.5,44.2,28.8c15.9,6.2,34.1,10.4,60.7,11.6c26.7,1.2,35.2,1.5,103,1.5c67.9,0,76.4-0.3,103-1.5
			c26.6-1.2,44.8-5.5,60.7-11.6c16.4-6.4,30.4-14.9,44.2-28.8c13.8-13.8,22.5-27.8,28.8-44.2c6.2-15.9,10.4-34.1,11.6-60.7
			c1.2-26.7,1.5-35.2,1.5-103c0-67.9-0.3-76.4-1.5-103s-5.5-44.8-11.6-60.7c-6.4-16.4-14.9-30.4-28.8-44.2
			C444,28.2,430,19.6,413.6,13.3c-15.9-6.2-34.1-10.4-60.7-11.6c-26.7-1.2-35.2-1.5-103-1.5c-67.9,0-76.4,0.3-103,1.5
			s-44.8,5.5-60.7,11.6c-16.4,6.4-30.4,14.9-44.2,28.8S19.5,69.9,13.2,86.3C7,102.2,2.7,120.4,1.5,147C0.3,173.6,0,182.1,0,250z
			 M45.1,250c0-66.7,0.3-74.7,1.5-101c1.1-24.4,5.2-37.7,8.6-46.4c4.5-11.6,10-20,18.8-28.8s17.1-14.1,28.8-18.8
			c8.8-3.4,22.1-7.5,46.4-8.6c26.3-1.2,34.2-1.5,101-1.5s74.7,0.3,101,1.5c24.4,1.1,37.7,5.2,46.4,8.6c11.6,4.5,20,10,28.8,18.8
			c8.8,8.8,14.1,17.1,18.8,28.8c3.4,8.8,7.5,22.1,8.6,46.4c1.2,26.3,1.5,34.2,1.5,101s-0.3,74.7-1.5,101c-1.1,24.4-5.2,37.7-8.6,46.4
			c-4.5,11.6-10,20-18.8,28.8c-8.8,8.8-17.1,14.1-28.8,18.8c-8.8,3.4-22.1,7.5-46.4,8.6c-26.3,1.2-34.2,1.5-101,1.5
			s-74.7-0.3-101-1.5c-24.4-1.1-37.7-5.2-46.4-8.6c-11.6-4.5-20-10-28.8-18.8c-8.8-8.8-14.1-17.1-18.8-28.8
			c-3.4-8.8-7.5-22.1-8.6-46.4C45.3,324.7,45.1,316.7,45.1,250z"/>
	</g>
	</svg>
	</a>';
		}
		return do_shortcode($s);
	}
	add_shortcode("cts_social_instagram", "ujcfe_getInstagramIcon");
}

if (!function_exists('ujcfe_getYoutubeIcon')) {
	function ujcfe_getYoutubeIcon($atts) {
		$url = get_theme_mod("social_youtube_setting");
		$s = '';
		if (!empty($url)) {
			$s = '<a class="mx-2" href="' . esc_url_raw($url) . '" target="_blank" rel="noopener" data-target="tooltip" title="Youtube"><svg height="28px" viewBox="0 0 256 180" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" preserveAspectRatio="xMidYMid">
		<defs>
			<linearGradient x1="49.9804764%" y1="8.68053889e-07%" x2="49.9804764%" y2="100.030167%" id="linearGradient-1_yt">
				<stop stop-color="#E52D27" offset="0%"></stop>
				<stop stop-color="#BF171D" offset="100%"></stop>
			</linearGradient>
		</defs>
		<g>
			<g>
				<path d="M101.6,123.2 L170.8,87.4 L101.6,51.3 L101.6,123.2 L101.6,123.2 Z" fill="#FFFFFF"></path>
				<path d="M101.6,51.3 L162.3,91.8 L170.8,87.4 L101.6,51.3 L101.6,51.3 Z" opacity="0.12" fill="#420000"></path>
				<path d="M253.301054,38.8 C253.301054,38.8 250.80203,21.2 243.105037,13.4 C233.408825,3.2 222.513081,3.2 217.415072,2.6 C181.729012,0 128.04998,0 128.04998,0 L127.95002,0 C127.95002,0 74.2709879,0 38.3850059,2.6 C33.3869582,3.2 22.4912144,3.2 12.695041,13.4 C5.09800859,21.2 2.59898477,38.8 2.59898477,38.8 C2.59898477,38.8 0,59.6 0,80.3 L0,99.7 C0,120.4 2.59898477,141.1 2.59898477,141.1 C2.59898477,141.1 5.09800859,158.7 12.795002,166.5 C22.4912144,176.7 35.2862163,176.4 40.9839906,177.4 C61.4759859,179.4 127.95002,180 127.95002,180 C127.95002,180 181.729012,179.9 217.515033,177.3 C222.513081,176.7 233.408825,176.7 243.204998,166.5 C250.901991,158.7 253.401015,141.1 253.401015,141.1 C253.401015,141.1 256,120.4 256,99.7 L256,80.3 C255.900039,59.6 253.301054,38.8 253.301054,38.8 L253.301054,38.8 Z M101.560328,123.2 L101.560328,51.3 L170.733307,87.4 L101.560328,123.2 L101.560328,123.2 Z" fill="url(#linearGradient-1_yt)"></path>
			</g>
		</g>
	</svg></a>';
		}
		return do_shortcode($s);
	}
	add_shortcode("cts_social_youtube", "ujcfe_getYoutubeIcon");
}

if (!function_exists('ujcfe_getTwitterIcon')) {
	function ujcfe_getTwitterIcon($atts) {
		$url = get_theme_mod("social_twitter_setting");
		$s = '';
		if (!empty($url)) {
			$s = '<a class="mx-2" href="' . esc_url_raw($url) . '" target="_blank" rel="noopener" data-target="tooltip" title="Twitter"><svg width="32px" height="32px" viewBox="0 0 256 209" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" preserveAspectRatio="xMidYMid">
		<g>
			<path d="M256,25.4500259 C246.580841,29.6272672 236.458451,32.4504868 225.834156,33.7202333 C236.678503,27.2198053 245.00583,16.9269929 248.927437,4.66307685 C238.779765,10.6812633 227.539325,15.0523376 215.57599,17.408298 C205.994835,7.2006971 192.34506,0.822 177.239197,0.822 C148.232605,0.822 124.716076,24.3375931 124.716076,53.3423116 C124.716076,57.4586875 125.181462,61.4673784 126.076652,65.3112644 C82.4258385,63.1210453 43.7257252,42.211429 17.821398,10.4359288 C13.3005011,18.1929938 10.710443,27.2151234 10.710443,36.8402889 C10.710443,55.061526 19.9835254,71.1374907 34.0762135,80.5557137 C25.4660961,80.2832239 17.3681846,77.9207088 10.2862577,73.9869292 C10.2825122,74.2060448 10.2825122,74.4260967 10.2825122,74.647085 C10.2825122,100.094453 28.3867003,121.322443 52.413563,126.14673 C48.0059695,127.347184 43.3661509,127.988612 38.5755734,127.988612 C35.1914554,127.988612 31.9009766,127.659938 28.694773,127.046602 C35.3777973,147.913145 54.7742053,163.097665 77.7569918,163.52185 C59.7820257,177.607983 37.1354036,186.004604 12.5289147,186.004604 C8.28987161,186.004604 4.10888474,185.75646 0,185.271409 C23.2431033,200.173139 50.8507261,208.867532 80.5109185,208.867532 C177.116529,208.867532 229.943977,128.836982 229.943977,59.4326002 C229.943977,57.1552968 229.893412,54.8901664 229.792282,52.6381454 C240.053257,45.2331635 248.958338,35.9825545 256,25.4500259" fill="#55acee"></path>
		</g>
	</svg></a>';
		}
		return do_shortcode($s);
	}
	add_shortcode("cts_social_twitter", "ujcfe_getTwitterIcon");
}

if (!function_exists('ujcfe_getLinkedInIcon')) {
	function ujcfe_getLinkedInIcon($atts) {
		$url = get_theme_mod("social_linkedin_setting");
		$s = '';
		if (!empty($url)) {
			$s = '<a class="mx-2" href="' . esc_url_raw($url) . '" target="_blank" rel="noopener" data-target="tooltip" title="LinkedIn"><svg width="32px" height="32px" viewBox="0 0 256 256" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" preserveAspectRatio="xMidYMid">
		<g>
			<path d="M218.123122,218.127392 L180.191928,218.127392 L180.191928,158.724263 C180.191928,144.559023 179.939053,126.323993 160.463756,126.323993 C140.707926,126.323993 137.685284,141.757585 137.685284,157.692986 L137.685284,218.123441 L99.7540894,218.123441 L99.7540894,95.9665207 L136.168036,95.9665207 L136.168036,112.660562 L136.677736,112.660562 C144.102746,99.9650027 157.908637,92.3824528 172.605689,92.9280076 C211.050535,92.9280076 218.138927,118.216023 218.138927,151.114151 L218.123122,218.127392 Z M56.9550587,79.2685282 C44.7981969,79.2707099 34.9413443,69.4171797 34.9391618,57.260052 C34.93698,45.1029244 44.7902948,35.2458562 56.9471566,35.2436736 C69.1040185,35.2414916 78.9608713,45.0950217 78.963054,57.2521493 C78.9641017,63.090208 76.6459976,68.6895714 72.5186979,72.8184433 C68.3913982,76.9473153 62.7929898,79.26748 56.9550587,79.2685282 M75.9206558,218.127392 L37.94995,218.127392 L37.94995,95.9665207 L75.9206558,95.9665207 L75.9206558,218.127392 Z M237.033403,0.0182577091 L18.8895249,0.0182577091 C8.57959469,-0.0980923971 0.124827038,8.16056231 -0.001,18.4706066 L-0.001,237.524091 C0.120519052,247.839103 8.57460631,256.105934 18.8895249,255.9977 L237.033403,255.9977 C247.368728,256.125818 255.855922,247.859464 255.999,237.524091 L255.999,18.4548016 C255.851624,8.12438979 247.363742,-0.133792868 237.033403,0.000790807055" fill="#0A66C2"></path>
		</g>
	</svg>
	</a>';
		}
		return do_shortcode($s);
	}
	add_shortcode("cts_social_linkedin", "ujcfe_getLinkedInIcon");
}

if (!function_exists('ujcfe_getNextdoorIcon')) {
	function ujcfe_getNextdoorIcon($atts) {
		$url = get_theme_mod("social_nextdoor_setting");
		$s = '';
		if (!empty($url)) {
			$s = '<a class="mx-2" href="' . esc_url_raw($url) . '" target="_blank" rel="noopener" data-target="tooltip" title="Nextdoor"><img style="max-height:32px;" src="data:image/png;base64,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" alt="Nextdoor logo"></a>';
		}
		return do_shortcode($s);
	}
	add_shortcode("cts_social_nextdoor", "ujcfe_getNextdoorIcon");
}

if (!function_exists('ujcfe_getSocialIcons')) {
	function ujcfe_getSocialIcons($atts) {
		$shortcodes = array("cts_social_google_my_business",
							"cts_social_facebook",
							"cts_social_bing_places",
							"cts_social_yelp",
							"cts_social_instagram",
							"cts_social_youtube",
							"cts_social_twitter",
							"cts_social_linkedin",
							"cts_social_nextdoor");
		$s = '<div class="social-icons">';
		
		foreach($shortcodes as $shortcode) {
			$s .= '<span class="social-icon">';
			$s .= '[' . $shortcode . ']';
			$s .= '</span>';
		}

		$s .= '</div>';

		return do_shortcode($s);
	}
	add_shortcode("cts_social", "ujcfe_getSocialIcons");
}

if (!function_exists('ujcfe_getRecaptchaV2')) {
	function ujcfe_getRecaptchaV2($atts) {
		return get_theme_mod("recaptcha_key_v2_setting");
	}
	add_shortcode("cts_recaptcha_key_v2", "ujcfe_getRecaptchaV2");
}

if (!function_exists('ujcfe_getRecaptchaV3')) {
	function ujcfe_getRecaptchaV3($atts) {
		return get_theme_mod("recaptcha_key_v3_setting");
	}
	add_shortcode("cts_recaptcha_key_v3", "ujcfe_getRecaptchaV3");
}

if (!function_exists('ujcfe_getPostCreationDate')) {
	function ujcfe_getPostCreationDate($atts) {
		return get_the_time('F j, Y');
	}
	add_shortcode("cts_creation_date", "ujcfe_getPostCreationDate");
}

if (!function_exists('ujcfe_getPostChangeDate')) {
	function ujcfe_getPostChangeDate($atts) {
		return get_the_modified_time('F j, Y');
	}
	add_shortcode("cts_modification_date", "ujcfe_getPostChangeDate");
}

if (!function_exists('ujcfe_formatEmail')) {
	function ujcfe_formatEmail($email) {
		if (!empty($email)) {
			return '<i class="fas fa-envelope fa-fw mr-2"></i><a href="mailto:' . esc_attr($email) . '">'. esc_html($email) . '</a>';
		}
		
		return '';
	}
}

if (!function_exists('ujcfe_formatPhone')) {
	function ujcfe_formatPhone($phone) {
		if (!empty($phone)) {
			return '<i class="fas fa-mobile-alt fa-fw mr-2"></i><a href="tel:' . esc_attr(preg_replace('/[^0-9]/', '', $phone)) . '">'. esc_html($phone). '</a>';
		}
		
		return '';
	}
}
