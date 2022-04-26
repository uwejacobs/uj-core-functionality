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
					$s .= '<span class="me-2">' . $contact['name'] . '</span>';
					$s .= '<br class="d-md-block d-lg-none d-none" />';			
				}
				if (!empty($contact['email'])) {
					$s .= '<span class="me-2">' . $contact['email'] . '</span>';
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
			$s = '<a class="mx-2" href="' . esc_url_raw($url) . '" target="_blank" rel="noopener" data-bs-target="tooltip" title="Google My Business"><svg height="48px" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 1600 1600"><defs><style>.cls-1{fill:#fff;}.cls-2{fill:#4989f5;}.cls-3{fill:url(#linear-gradient-gmb);}.cls-4,.cls-8{fill:#3c4ba6;}.cls-5{fill:#7babf7;}.cls-6{fill:#3f51b5;}.cls-7{fill:#709be0;}.cls-7,.cls-8{fill-rule:evenodd;}</style><linearGradient id="linear-gradien-gmbt" x1="321.97" y1="913.43" x2="1251.93" y2="913.43" gradientUnits="userSpaceOnUse"><stop offset="0.03" stop-color="#4079d8"/><stop offset="1" stop-color="#4989f5"/></linearGradient></defs><rect class="cls-2" x="321.45" y="567.98" width="931" height="696.14" rx="36.88" ry="36.88"/><path class="cls-3" d="M1204.81,562.75H368.06c-25.92,0-46.09,200.6-46.09,226.52L780.2,1264.12h424.61a47.26,47.26,0,0,0,47.13-47.13V609.87A47.26,47.26,0,0,0,1204.81,562.75Z"/><polygon class="cls-4" points="534.03 684.56 800.03 684.56 800.03 335.44 573.86 335.44 534.03 684.56"/><polygon class="cls-5" points="1066.03 684.56 800.03 684.56 800.03 335.44 1026.2 335.44 1066.03 684.56"/><path class="cls-5" d="M1252.45,401.62l.33,1.19C1252.7,402.39,1252.54,402,1252.45,401.62Z"/><path class="cls-6" d="M1252.78,402.8l-.33-1.19a84.13,84.13,0,0,0-82.14-66.18H1026.2L1066,684.56h266Z"/><path class="cls-5" d="M347.61,401.62l-.33,1.19C347.36,402.39,347.52,402,347.61,401.62Z"/><path class="cls-5" d="M347.27,402.8l.33-1.19a84.13,84.13,0,0,1,82.14-66.18H573.86L534,684.56H268Z"/><path class="cls-7" d="M534.48,684.47a132.92,132.92,0,0,1-265.85,0Z"/><path class="cls-8" d="M800.33,684.47a132.92,132.92,0,0,1-265.85,0Z"/><path class="cls-7" d="M1066.18,684.47a132.92,132.92,0,0,1-265.85,0Z"/><path class="cls-8" d="M1332,684.47a132.92,132.92,0,1,1-265.85,0Z"/><path class="cls-1" d="M1199.08,1044.6c-.47-6.33-1.25-12.11-2.36-19.49h-145c0,20.28,0,42.41-.08,62.7h84a73.05,73.05,0,0,1-30.75,46.89s0-.35-.06-.36a88,88,0,0,1-34,13.27,99.85,99.85,0,0,1-36.79-.16,91.9,91.9,0,0,1-34.31-14.87A95.72,95.72,0,0,1,966,1089.48c-.52-1.35-1-2.71-1.49-4.09l0-.15.13-.1a93,93,0,0,1-.05-59.84A96.27,96.27,0,0,1,986.9,989a90.63,90.63,0,0,1,91.32-23.78,83,83,0,0,1,33.23,19.56l28.34-28.34c5-5.05,10.19-9.94,15-15.16l0,0,0,0a149.78,149.78,0,0,0-49.64-30.74,156.08,156.08,0,0,0-103.83-.91q-1.76.6-3.5,1.25A155.18,155.18,0,0,0,914,986a152.61,152.61,0,0,0-13.42,38.78,154.25,154.25,0,0,0,111.21,179.4c25.69,6.88,53,6.71,78.89.83a139.88,139.88,0,0,0,63.14-32.81c18.64-17.15,32-40,39-64.27A179,179,0,0,0,1199.08,1044.6Z"/></svg></a>';
		}
		return $s;
	}
	add_shortcode("cts_social_google_my_business", "ujcfe_getGoogleMyBusinessIcon");
}

if (!function_exists('ujcfe_getFacebookIcon')) {
	function ujcfe_getFacebookIcon($atts) {
		$url = get_theme_mod("social_facebook_setting");
		$s = '';
		if (!empty($url)) {
			$s = '<a class="mx-2" href="' . esc_url_raw($url) . '" target="_blank" rel="noopener" data-bs-target="tooltip" title="Facebook"><svg height="28px" viewBox="0 0 256 256" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" preserveAspectRatio="xMidYMid">
		<g>
			<path d="M241.871,256.001 C249.673,256.001 256,249.675 256,241.872 L256,14.129 C256,6.325 249.673,0 241.871,0 L14.129,0 C6.324,0 0,6.325 0,14.129 L0,241.872 C0,249.675 6.324,256.001 14.129,256.001 L241.871,256.001" fill="#395185"></path>
			<path d="M176.635,256.001 L176.635,156.864 L209.912,156.864 L214.894,118.229 L176.635,118.229 L176.635,93.561 C176.635,82.375 179.742,74.752 195.783,74.752 L216.242,74.743 L216.242,40.188 C212.702,39.717 200.558,38.665 186.43,38.665 C156.932,38.665 136.738,56.67 136.738,89.736 L136.738,118.229 L103.376,118.229 L103.376,156.864 L136.738,156.864 L136.738,256.001 L176.635,256.001" fill="#FFFFFF"></path>
		</g>
	</svg></a>';
		}
		return $s;
	}
	add_shortcode("cts_social_facebook", "ujcfe_getFacebookIcon");
}

if (!function_exists('ujcfe_getBingPlacesIcon')) {
	function ujcfe_getBingPlacesIcon($atts) {
		$url = get_theme_mod("social_bing_places_setting");
		$s = '';
		if (!empty($url)) {
			$s = '<a class="mx-2" href="' . esc_url_raw($url) . '" target="_blank" rel="noopener" data-bs-target="tooltip" title="Microsoft Bing Places"><svg viewBox="-29.62167543756803 0.1 574.391675437568 799.8100000000002" xmlns="http://www.w3.org/2000/svg" height="28px"><linearGradient id="a-mbp" gradientUnits="userSpaceOnUse" x1="286.383" x2="542.057" y1="284.169" y2="569.112"><stop offset="0" stop-color="#37bdff"/><stop offset=".25" stop-color="#26c6f4"/><stop offset=".5" stop-color="#15d0e9"/><stop offset=".75" stop-color="#3bd6df"/><stop offset="1" stop-color="#62dcd4"/></linearGradient><linearGradient id="b-mbp" gradientUnits="userSpaceOnUse" x1="108.979" x2="100.756" y1="675.98" y2="43.669"><stop offset="0" stop-color="#1b48ef"/><stop offset=".5" stop-color="#2080f1"/><stop offset="1" stop-color="#26b8f4"/></linearGradient><linearGradient id="c-mbp" gradientUnits="userSpaceOnUse" x1="256.823" x2="875.632" y1="649.719" y2="649.719"><stop offset="0" stop-color="#39d2ff"/><stop offset=".5" stop-color="#248ffa"/><stop offset="1" stop-color="#104cf5"/></linearGradient><linearGradient id="d-mbp" gradientUnits="userSpaceOnUse" x1="256.823" x2="875.632" y1="649.719" y2="649.719"><stop offset="0" stop-color="#fff"/><stop offset="1"/></linearGradient><path d="M249.97 277.48c-.12.96-.12 2.05-.12 3.12 0 4.16.83 8.16 2.33 11.84l1.34 2.76 5.3 13.56 27.53 70.23 24.01 61.33c6.85 12.38 17.82 22.1 31.05 27.28l4.11 1.51c.16.05.43.05.65.11l65.81 22.63v.05l25.16 8.64 1.72.58c.06 0 .16.06.22.06 4.96 1.25 9.82 2.93 14.46 4.98 10.73 4.63 20.46 11.23 28.77 19.28 3.35 3.2 6.43 6.65 9.28 10.33a88.64 88.64 0 0 1 6.64 9.72c8.78 14.58 13.82 31.72 13.82 49.97 0 3.26-.16 6.41-.49 9.61-.11 1.41-.28 2.77-.49 4.12v.11c-.22 1.43-.49 2.91-.76 4.36-.28 1.41-.54 2.81-.86 4.21-.05.16-.11.33-.17.49-.3 1.42-.68 2.82-1.07 4.23-.35 1.33-.79 2.7-1.28 3.99a42.96 42.96 0 0 1-1.51 4.16c-.49 1.4-1.07 2.82-1.72 4.16-1.78 4.11-3.9 8.06-6.28 11.83a97.889 97.889 0 0 1-10.47 13.95c30.88-33.2 51.41-76.07 56.52-123.51.86-7.78 1.3-15.67 1.3-23.61 0-5.07-.22-10.09-.55-15.13-3.89-56.89-29.79-107.77-69.32-144.08-10.9-10.09-22.81-19.07-35.62-26.69l-24.2-12.37-122.63-62.93a30.15 30.15 0 0 0-11.93-2.44c-15.88 0-28.99 12.11-30.55 27.56z" fill="#7f7f7f"/><path d="M249.97 277.48c-.12.96-.12 2.05-.12 3.12 0 4.16.83 8.16 2.33 11.84l1.34 2.76 5.3 13.56 27.53 70.23 24.01 61.33c6.85 12.38 17.82 22.1 31.05 27.28l4.11 1.51c.16.05.43.05.65.11l65.81 22.63v.05l25.16 8.64 1.72.58c.06 0 .16.06.22.06 4.96 1.25 9.82 2.93 14.46 4.98 10.73 4.63 20.46 11.23 28.77 19.28 3.35 3.2 6.43 6.65 9.28 10.33a88.64 88.64 0 0 1 6.64 9.72c8.78 14.58 13.82 31.72 13.82 49.97 0 3.26-.16 6.41-.49 9.61-.11 1.41-.28 2.77-.49 4.12v.11c-.22 1.43-.49 2.91-.76 4.36-.28 1.41-.54 2.81-.86 4.21-.05.16-.11.33-.17.49-.3 1.42-.68 2.82-1.07 4.23-.35 1.33-.79 2.7-1.28 3.99a42.96 42.96 0 0 1-1.51 4.16c-.49 1.4-1.07 2.82-1.72 4.16-1.78 4.11-3.9 8.06-6.28 11.83a97.889 97.889 0 0 1-10.47 13.95c30.88-33.2 51.41-76.07 56.52-123.51.86-7.78 1.3-15.67 1.3-23.61 0-5.07-.22-10.09-.55-15.13-3.89-56.89-29.79-107.77-69.32-144.08-10.9-10.09-22.81-19.07-35.62-26.69l-24.2-12.37-122.63-62.93a30.15 30.15 0 0 0-11.93-2.44c-15.88 0-28.99 12.11-30.55 27.56z" fill="url(#a-mbp)"/><path d="M31.62.1C14.17.41.16 14.69.16 32.15v559.06c.07 3.9.29 7.75.57 11.66.25 2.06.52 4.2.9 6.28 7.97 44.87 47.01 78.92 94.15 78.92 16.53 0 32.03-4.21 45.59-11.53.08-.06.22-.14.29-.14l4.88-2.95 19.78-11.64 25.16-14.93.06-496.73c0-33.01-16.52-62.11-41.81-79.4-.6-.36-1.18-.74-1.71-1.17L50.12 5.56C45.16 2.28 39.18.22 32.77.1z" fill="#7f7f7f"/><path d="M31.62.1C14.17.41.16 14.69.16 32.15v559.06c.07 3.9.29 7.75.57 11.66.25 2.06.52 4.2.9 6.28 7.97 44.87 47.01 78.92 94.15 78.92 16.53 0 32.03-4.21 45.59-11.53.08-.06.22-.14.29-.14l4.88-2.95 19.78-11.64 25.16-14.93.06-496.73c0-33.01-16.52-62.11-41.81-79.4-.6-.36-1.18-.74-1.71-1.17L50.12 5.56C45.16 2.28 39.18.22 32.77.1z" fill="url(#b-mbp)"/><path d="M419.81 510.84L194.72 644.26l-3.24 1.95v.71l-25.16 14.9-19.77 11.67-4.85 2.93-.33.16c-13.53 7.35-29.04 11.51-45.56 11.51-47.13 0-86.22-34.03-94.16-78.92 3.77 32.84 14.96 63.41 31.84 90.04 34.76 54.87 93.54 93.04 161.54 99.67h41.58c36.78-3.84 67.49-18.57 99.77-38.46l49.64-30.36c22.36-14.33 83.05-49.58 100.93-69.36 3.89-4.33 7.4-8.97 10.47-13.94 2.38-3.78 4.5-7.73 6.28-11.84.6-1.4 1.17-2.76 1.72-4.15.52-1.38 1.01-2.77 1.51-4.18.93-2.7 1.67-5.41 2.38-8.2.36-1.59.69-3.16 1.02-4.72 1.08-5.89 1.67-11.94 1.67-18.21 0-18.25-5.04-35.39-13.77-49.95-2-3.4-4.2-6.65-6.64-9.72-2.85-3.7-5.93-7.13-9.28-10.33-8.31-8.05-18.01-14.65-28.77-19.29-4.64-2.05-9.48-3.74-14.46-4.97-.06 0-.16-.06-.22-.06l-1.72-.58z" fill="#7f7f7f"/><path d="M419.81 510.84L194.72 644.26l-3.24 1.95v.71l-25.16 14.9-19.77 11.67-4.85 2.93-.33.16c-13.53 7.35-29.04 11.51-45.56 11.51-47.13 0-86.22-34.03-94.16-78.92 3.77 32.84 14.96 63.41 31.84 90.04 34.76 54.87 93.54 93.04 161.54 99.67h41.58c36.78-3.84 67.49-18.57 99.77-38.46l49.64-30.36c22.36-14.33 83.05-49.58 100.93-69.36 3.89-4.33 7.4-8.97 10.47-13.94 2.38-3.78 4.5-7.73 6.28-11.84.6-1.4 1.17-2.76 1.72-4.15.52-1.38 1.01-2.77 1.51-4.18.93-2.7 1.67-5.41 2.38-8.2.36-1.59.69-3.16 1.02-4.72 1.08-5.89 1.67-11.94 1.67-18.21 0-18.25-5.04-35.39-13.77-49.95-2-3.4-4.2-6.65-6.64-9.72-2.85-3.7-5.93-7.13-9.28-10.33-8.31-8.05-18.01-14.65-28.77-19.29-4.64-2.05-9.48-3.74-14.46-4.97-.06 0-.16-.06-.22-.06l-1.72-.58z" fill="url(#c-mbp)"/><path d="M512 595.46c0 6.27-.59 12.33-1.68 18.22-.32 1.56-.65 3.12-1.02 4.7-.7 2.8-1.44 5.51-2.37 8.22-.49 1.4-.99 2.8-1.51 4.16-.54 1.4-1.12 2.76-1.73 4.16a87.873 87.873 0 0 1-6.26 11.83 96.567 96.567 0 0 1-10.48 13.94c-17.88 19.79-78.57 55.04-100.93 69.37l-49.64 30.36c-36.39 22.42-70.77 38.29-114.13 39.38-2.05.06-4.06.11-6.05.11-2.8 0-5.56-.05-8.33-.16-73.42-2.8-137.45-42.25-174.38-100.54a213.368 213.368 0 0 1-31.84-90.04c7.94 44.89 47.03 78.92 94.16 78.92 16.52 0 32.03-4.17 45.56-11.51l.33-.17 4.85-2.92 19.77-11.67 25.16-14.9v-.71l3.24-1.95 225.09-133.43 17.33-10.27 1.72.58c.05 0 .16.06.22.06 4.98 1.23 9.83 2.92 14.46 4.97 10.76 4.64 20.45 11.24 28.77 19.29a92.13 92.13 0 0 1 9.28 10.33c2.44 3.07 4.64 6.32 6.64 9.72 8.73 14.56 13.77 31.7 13.77 49.95z" fill="#7f7f7f" opacity=".15"/><path d="M512 595.46c0 6.27-.59 12.33-1.68 18.22-.32 1.56-.65 3.12-1.02 4.7-.7 2.8-1.44 5.51-2.37 8.22-.49 1.4-.99 2.8-1.51 4.16-.54 1.4-1.12 2.76-1.73 4.16a87.873 87.873 0 0 1-6.26 11.83 96.567 96.567 0 0 1-10.48 13.94c-17.88 19.79-78.57 55.04-100.93 69.37l-49.64 30.36c-36.39 22.42-70.77 38.29-114.13 39.38-2.05.06-4.06.11-6.05.11-2.8 0-5.56-.05-8.33-.16-73.42-2.8-137.45-42.25-174.38-100.54a213.368 213.368 0 0 1-31.84-90.04c7.94 44.89 47.03 78.92 94.16 78.92 16.52 0 32.03-4.17 45.56-11.51l.33-.17 4.85-2.92 19.77-11.67 25.16-14.9v-.71l3.24-1.95 225.09-133.43 17.33-10.27 1.72.58c.05 0 .16.06.22.06 4.98 1.23 9.83 2.92 14.46 4.97 10.76 4.64 20.45 11.24 28.77 19.29a92.13 92.13 0 0 1 9.28 10.33c2.44 3.07 4.64 6.32 6.64 9.72 8.73 14.56 13.77 31.7 13.77 49.95z" fill="url(#d-mbp)" opacity=".15"/></svg></a>';
		}
		return $s;
	}
	add_shortcode("cts_social_bing_places", "ujcfe_getBingPlacesIcon");
}

if (!function_exists('ujcfe_getYelpIcon')) {
	function ujcfe_getYelpIcon($atts) {
		$url = get_theme_mod("social_yelp_setting");
		$s = '';
		if (!empty($url)) {
			$s = '<a class="mx-2" href="' . esc_url_raw($url) . '" target="_blank" rel="noopener" data-bs-target="tooltip" title="Yelp"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 926.7 1220" height="28"><style>.st0{fill:#bf2519}</style><path class="st0" d="M23.6 587.4C3.8 619.1-4.5 718.8 2.4 784.9c2.4 21.8 6.4 40 12.1 50.9 7.9 15 21.2 24 36.3 24.5 9.7.5 15.8-1.2 198.3-59.9 0 0 81.1-25.9 81.5-26.1 20.2-5.2 33.9-23.8 35.2-47.5 1.3-24.4-11.2-45.9-32-53.6 0 0-57.2-23.3-57.3-23.3-196.2-80.9-205-84.1-214.9-84.2-15.2-.5-28.6 7.1-38 21.7m438.8 602.9c3.2-9.2 3.6-15.5 4.1-207.3 0 0 .4-84.7.5-85.6 1.3-20.8-12.1-39.7-34.1-48.2-22.7-8.7-47.1-3.3-60.8 13.7 0 0-40 47.5-40.2 47.5-137.4 161.4-143.2 168.9-146.5 178.4-2.1 5.6-2.8 11.6-2.2 17.6.8 8.6 4.7 17 11.1 24.9 31.9 37.9 184.7 94.1 233.5 85.7 17.1-2.9 29.4-12.4 34.6-26.7m310.1-66.7c46.1-18.4 146.6-146.2 153.7-195.5 2.5-17.1-2.9-31.9-14.7-41.3-7.7-5.8-13.6-8.1-196.1-68 0 0-80-26.4-81.1-26.9-19.4-7.5-41.5-.5-56.3 17.8-15.5 18.8-17.8 43.7-5.4 62.4l32.2 52.4c108.3 175.9 116.6 188.3 124.4 194.4 12 9.5 27.3 11.1 43.3 4.7m-94.3-452.8c207.3-50.2 215.4-52.9 223.5-58.3 12.6-8.5 18.9-22.6 17.8-39.8 0-.5.1-1.1 0-1.7-5.3-51-94.5-183.4-138.5-204.9-15.6-7.5-31.2-7-44.1 1.7-8 5.2-13.9 13.1-124.9 165 0 0-50.1 68.3-50.7 69-13.2 16.1-13.4 39.1-.5 58.9 13.4 20.5 36 30.4 56.7 24.7 0 0-.8 1.5-1 1.7 10.2-3.9 28.4-8.4 61.7-16.3M470.1 499.6c-3.6-82.2-28.3-448.1-31.2-465-4.2-15.4-16.2-26.3-33.4-30.7-53-13.1-255.3 43.6-292.8 82.2-12.1 12.6-16.5 28-12.9 41.7 5.9 12.1 256.6 406.5 256.6 406.5 37 60.1 67.3 50.7 77.2 47.6 9.8-2.9 39.9-12.3 36.5-82.3"/></svg></a>';
		}
		return $s;
	}
	add_shortcode("cts_social_yelp", "ujcfe_getYelpIcon");
}

if (!function_exists('ujcfe_getInstagramIcon')) {
	function ujcfe_getInstagramIcon($atts) {
		$url = get_theme_mod("social_instagram_setting");
		$s = '';
		if (!empty($url)) {
			$s = '<a class="mx-2" href="' . esc_url_raw($url) . '" target="_blank" rel="noopener" data-bs-target="tooltip" title="Instagram"><svg height="28px" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
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
		return $s;
	}
	add_shortcode("cts_social_instagram", "ujcfe_getInstagramIcon");
}

if (!function_exists('ujcfe_getYoutubeIcon')) {
	function ujcfe_getYoutubeIcon($atts) {
		$url = get_theme_mod("social_youtube_setting");
		$s = '';
		if (!empty($url)) {
			$s = '<a class="mx-2" href="' . esc_url_raw($url) . '" target="_blank" rel="noopener" data-bs-target="tooltip" title="Youtube"><svg height="28px" viewBox="0 0 256 180" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" preserveAspectRatio="xMidYMid">
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
		return $s;
	}
	add_shortcode("cts_social_youtube", "ujcfe_getYoutubeIcon");
}

if (!function_exists('ujcfe_getTwitterIcon')) {
	function ujcfe_getTwitterIcon($atts) {
		$url = get_theme_mod("social_twitter_setting");
		$s = '';
		if (!empty($url)) {
			$s = '<a class="mx-2" href="' . esc_url_raw($url) . '" target="_blank" rel="noopener" data-bs-target="tooltip" title="Twitter"><svg width="32px" height="32px" viewBox="0 0 256 209" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" preserveAspectRatio="xMidYMid">
		<g>
			<path d="M256,25.4500259 C246.580841,29.6272672 236.458451,32.4504868 225.834156,33.7202333 C236.678503,27.2198053 245.00583,16.9269929 248.927437,4.66307685 C238.779765,10.6812633 227.539325,15.0523376 215.57599,17.408298 C205.994835,7.2006971 192.34506,0.822 177.239197,0.822 C148.232605,0.822 124.716076,24.3375931 124.716076,53.3423116 C124.716076,57.4586875 125.181462,61.4673784 126.076652,65.3112644 C82.4258385,63.1210453 43.7257252,42.211429 17.821398,10.4359288 C13.3005011,18.1929938 10.710443,27.2151234 10.710443,36.8402889 C10.710443,55.061526 19.9835254,71.1374907 34.0762135,80.5557137 C25.4660961,80.2832239 17.3681846,77.9207088 10.2862577,73.9869292 C10.2825122,74.2060448 10.2825122,74.4260967 10.2825122,74.647085 C10.2825122,100.094453 28.3867003,121.322443 52.413563,126.14673 C48.0059695,127.347184 43.3661509,127.988612 38.5755734,127.988612 C35.1914554,127.988612 31.9009766,127.659938 28.694773,127.046602 C35.3777973,147.913145 54.7742053,163.097665 77.7569918,163.52185 C59.7820257,177.607983 37.1354036,186.004604 12.5289147,186.004604 C8.28987161,186.004604 4.10888474,185.75646 0,185.271409 C23.2431033,200.173139 50.8507261,208.867532 80.5109185,208.867532 C177.116529,208.867532 229.943977,128.836982 229.943977,59.4326002 C229.943977,57.1552968 229.893412,54.8901664 229.792282,52.6381454 C240.053257,45.2331635 248.958338,35.9825545 256,25.4500259" fill="#55acee"></path>
		</g>
	</svg></a>';
		}
		return $s;
	}
	add_shortcode("cts_social_twitter", "ujcfe_getTwitterIcon");
}

if (!function_exists('ujcfe_getLinkedInIcon')) {
	function ujcfe_getLinkedInIcon($atts) {
		$url = get_theme_mod("social_linkedin_setting");
		$s = '';
		if (!empty($url)) {
			$s = '<a class="mx-2" href="' . esc_url_raw($url) . '" target="_blank" rel="noopener" data-bs-target="tooltip" title="LinkedIn"><svg width="32px" height="32px" viewBox="0 0 256 256" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" preserveAspectRatio="xMidYMid">
		<g>
			<path d="M218.123122,218.127392 L180.191928,218.127392 L180.191928,158.724263 C180.191928,144.559023 179.939053,126.323993 160.463756,126.323993 C140.707926,126.323993 137.685284,141.757585 137.685284,157.692986 L137.685284,218.123441 L99.7540894,218.123441 L99.7540894,95.9665207 L136.168036,95.9665207 L136.168036,112.660562 L136.677736,112.660562 C144.102746,99.9650027 157.908637,92.3824528 172.605689,92.9280076 C211.050535,92.9280076 218.138927,118.216023 218.138927,151.114151 L218.123122,218.127392 Z M56.9550587,79.2685282 C44.7981969,79.2707099 34.9413443,69.4171797 34.9391618,57.260052 C34.93698,45.1029244 44.7902948,35.2458562 56.9471566,35.2436736 C69.1040185,35.2414916 78.9608713,45.0950217 78.963054,57.2521493 C78.9641017,63.090208 76.6459976,68.6895714 72.5186979,72.8184433 C68.3913982,76.9473153 62.7929898,79.26748 56.9550587,79.2685282 M75.9206558,218.127392 L37.94995,218.127392 L37.94995,95.9665207 L75.9206558,95.9665207 L75.9206558,218.127392 Z M237.033403,0.0182577091 L18.8895249,0.0182577091 C8.57959469,-0.0980923971 0.124827038,8.16056231 -0.001,18.4706066 L-0.001,237.524091 C0.120519052,247.839103 8.57460631,256.105934 18.8895249,255.9977 L237.033403,255.9977 C247.368728,256.125818 255.855922,247.859464 255.999,237.524091 L255.999,18.4548016 C255.851624,8.12438979 247.363742,-0.133792868 237.033403,0.000790807055" fill="#0A66C2"></path>
		</g>
	</svg>
	</a>';
		}
		return $s;
	}
	add_shortcode("cts_social_linkedin", "ujcfe_getLinkedInIcon");
}

if (!function_exists('ujcfe_getNextdoorIcon')) {
	function ujcfe_getNextdoorIcon($atts) {
		$url = get_theme_mod("social_nextdoor_setting");
		$s = '';
		if (!empty($url)) {
			$s = '<a class="mx-2" href="' . esc_url_raw($url) . '" target="_blank" rel="noopener" data-bs-target="tooltip" title="Nextdoor"><svg height="36px" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:2;" version="1.1" viewBox="0 0 64 64"  xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:serif="http://www.serif.com/" xmlns:xlink="http://www.w3.org/1999/xlink"><g transform="matrix(1,0,0,1,0,-240)"><g id="nextdoor-apps-platform" transform="matrix(1,0,0,1,0,240)"><rect height="64" style="fill:none;" width="64" x="0" y="0"/><g transform="matrix(1,0,0,1,-400,-160)"><circle cx="432" cy="192" r="26" style="fill:rgb(204,244,159);"/></g><g transform="matrix(1,0,0,1,-400,-160)"><path d="M414.646,172.646C410.515,177.249 408,183.333 408,190C408,204.35 419.65,216 434,216C440.667,216 446.751,213.485 451.354,209.354C446.592,214.66 439.683,218 432,218C417.65,218 406,206.35 406,192C406,184.317 409.34,177.408 414.646,172.646Z" style="fill:rgb(149,214,164);"/></g><g transform="matrix(1,0,0,1,-400,-160)"><path d="M432,165.5C417.374,165.5 405.5,177.374 405.5,192C405.5,206.626 417.374,218.5 432,218.5C446.626,218.5 458.5,206.626 458.5,192C458.5,177.374 446.626,165.5 432,165.5ZM432,166.5C446.074,166.5 457.5,177.926 457.5,192C457.5,206.074 446.074,217.5 432,217.5C417.926,217.5 406.5,206.074 406.5,192C406.5,177.926 417.926,166.5 432,166.5Z"/></g><g transform="matrix(1,0,0,1,2.5,-239)"><path d="M22.109,263.899C24.429,260.348 28.44,258 33,258L33,258C40.18,258 46,263.82 46,271L46,283C46,283.552 45.552,284 45,284C43.463,284 40.537,284 39,284C38.735,284 38.48,283.895 38.293,283.707C38.105,283.52 38,283.265 38,283C38,280.75 38,275.159 38,271C38,269.674 37.473,268.402 36.536,267.464C35.598,266.527 34.326,266 33,266C33,266 33,266 33,266C31.674,266 30.402,266.527 29.464,267.464C28.527,268.402 28,269.674 28,271C28,275.159 28,280.75 28,283C28,283.265 27.895,283.52 27.707,283.707C27.52,283.895 27.265,284 27,284C25.463,284 22.537,284 21,284C20.448,284 20,283.552 20,283C20,280.933 20,275.967 20,271C20,270.663 20.013,270.33 20.038,270L20,270C16.582,270 13,266.418 13,262C13,261.219 13,260.524 13,260C13,259.448 13.448,259 14,259C15.11,259 16.89,259 18,259C18.265,259 18.52,259.105 18.707,259.293C18.895,259.48 19,259.735 19,260C19,260 19,260 19,260C19,261.061 19.421,262.078 20.172,262.828C20.708,263.365 21.381,263.733 22.109,263.899Z" style="fill:rgb(249,246,249);"/></g><g transform="matrix(1,0,0,1,2.5,-239)"><path d="M21.895,263.321C24.331,259.804 28.397,257.5 33,257.5L33,257.5C40.456,257.5 46.5,263.544 46.5,271C46.5,275.967 46.5,280.933 46.5,283C46.5,283.828 45.828,284.5 45,284.5C43.463,284.5 40.537,284.5 39,284.5C38.602,284.5 38.221,284.342 37.939,284.061C37.658,283.779 37.5,283.398 37.5,283C37.5,280.75 37.5,275.159 37.5,271C37.5,269.807 37.026,268.662 36.182,267.818C35.338,266.974 34.193,266.5 33,266.5L33,266.5C31.807,266.5 30.662,266.974 29.818,267.818C28.974,268.662 28.5,269.807 28.5,271C28.5,275.159 28.5,280.75 28.5,283C28.5,283.398 28.342,283.779 28.061,284.061C27.779,284.342 27.398,284.5 27,284.5C25.463,284.5 22.537,284.5 21,284.5C20.172,284.5 19.5,283.828 19.5,283C19.5,280.933 19.5,275.967 19.5,271C19.5,270.825 19.503,270.651 19.51,270.477C16.018,270.159 12.5,266.501 12.5,262C12.5,261.219 12.5,260.524 12.5,260C12.5,259.172 13.172,258.5 14,258.5C15.11,258.5 16.89,258.5 18,258.5C18.398,258.5 18.779,258.658 19.061,258.939C19.342,259.221 19.5,259.602 19.5,260C19.5,260.928 19.869,261.819 20.525,262.475C20.914,262.863 21.384,263.151 21.895,263.321ZM21.997,264.387C22.201,264.433 22.413,264.348 22.527,264.173C24.758,260.758 28.615,258.5 33,258.5L33,258.5C39.904,258.5 45.5,264.096 45.5,271L45.5,283C45.5,283.276 45.276,283.5 45,283.5L39,283.5C38.867,283.5 38.74,283.447 38.646,283.354C38.553,283.26 38.5,283.133 38.5,283C38.5,280.75 38.5,275.159 38.5,271C38.5,269.541 37.921,268.142 36.889,267.111C35.858,266.079 34.459,265.5 33,265.5L33,265.5C31.541,265.5 30.142,266.079 29.111,267.111C28.079,268.142 27.5,269.541 27.5,271C27.5,275.159 27.5,280.75 27.5,283C27.5,283.133 27.447,283.26 27.354,283.354C27.26,283.447 27.133,283.5 27,283.5C25.463,283.5 22.537,283.5 21,283.5C20.724,283.5 20.5,283.276 20.5,283C20.5,280.933 20.5,275.967 20.5,271C20.5,270.676 20.512,270.355 20.536,270.038C20.547,269.899 20.499,269.762 20.405,269.66C20.31,269.558 20.177,269.5 20.038,269.5L20,269.5C16.809,269.5 13.5,266.125 13.5,262C13.5,261.219 13.5,260.524 13.5,260C13.5,259.724 13.724,259.5 14,259.5C15.11,259.5 16.89,259.5 18,259.5C18.133,259.5 18.26,259.553 18.354,259.646C18.447,259.74 18.5,259.867 18.5,260L18.5,260C18.5,261.193 18.974,262.338 19.818,263.182C20.421,263.785 21.179,264.2 21.997,264.387Z"/></g></g></g></svg></a>';
		}
		return $s;
	}
	add_shortcode("cts_social_nextdoor", "ujcfe_getNextdoorIcon");
}

if (!function_exists('ujcfe_getAngiIcon')) {
	function ujcfe_getAngiIcon($atts) {
		$url = get_theme_mod("social_angi_setting");
		$s = '';
		if (!empty($url)) {
			$s = '<a class="mx-2" href="' . esc_url_raw($url) . '" target="_blank" rel="noopener" data-bs-target="tooltip" title="Angi"><img style="height:30px;" src="data:image/jpg;base64,'.ujcfe_angi_logo().'"></a>';
		}
		return $s;
	}
	add_shortcode("cts_social_angi", "ujcfe_getAngiIcon");
}

if (!function_exists('ujcfe_getGoogleReviewIcon')) {
	function ujcfe_getGoogleReviewIcon($atts) {
		$url = get_theme_mod("review_google_setting");
		$s = '';
		if (!empty($url)) {
			$s = '<a class="mx-3" href="' . esc_url_raw($url) . '" target="_blank" rel="noopener" data-bs-target="tooltip" title="Google"><i class="fab fa-google-plus-square fa-5x" style="color:#4285F4;"></i></a>';
		}
		return $s;
	}
	add_shortcode("cts_review_google", "ujcfe_getGoogleReviewIcon");
}

if (!function_exists('ujcfe_getFacebookReviewIcon')) {
	function ujcfe_getFacebookReviewIcon($atts) {
		$url = get_theme_mod("review_facebook_setting");
		$s = '';
		if (!empty($url)) {
			$s = '<a class="mx-3" href="' . esc_url_raw($url) . '" target="_blank" rel="noopener" data-bs-target="tooltip" title="Facebook"><i class="fab fa-facebook-square fa-5x" style="color:#1778F2;"></i></a>';
		}
		return $s;
	}
	add_shortcode("cts_review_facebook", "ujcfe_getFacebookReviewIcon");
}

if (!function_exists('ujcfe_getYelpReviewIcon')) {
	function ujcfe_getYelpReviewIcon($atts) {
		$url = get_theme_mod("review_yelp_setting");
		$s = '';
		if (!empty($url)) {
			$s = '<a class="mx-3" href="' . esc_url_raw($url) . '" target="_blank" rel="noopener" data-bs-target="tooltip" title="Yelp"><i class="fab fa-yelp fa-5x" style="color:#E00707;"></i></a>';
		}
		return $s;
	}
	add_shortcode("cts_review_yelp", "ujcfe_getYelpReviewIcon");
}

if (!function_exists('ujcfe_getAngiReviewIcon')) {
	function ujcfe_getAngiReviewIcon($atts) {
		$url = get_theme_mod("review_angi_setting");
		$s = '';
		if (!empty($url)) {
			$s = '<a class="mx-3" href="' . esc_url_raw($url) . '" target="_blank" rel="noopener" data-bs-target="tooltip" title="Angi"><img style="height:80px;vertical-align: top;" src="data:image/jpg;base64,'.ujcfe_angi_logo().'"></a>';
		}
		return $s;
	}
	add_shortcode("cts_review_angi", "ujcfe_getAngiReviewIcon");
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
							"cts_social_nextdoor",
							"cts_social_angi");

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

if (!function_exists('ujcfe_getReviewIcons')) {
	function ujcfe_getReviewIcons($atts) {
		$shortcodes = array("cts_review_google",
							"cts_review_facebook",
							"cts_review_yelp",
							"cts_review_angi");

		$s = '<div class="review-icons">';
		
		foreach($shortcodes as $shortcode) {
			$s .= '<span class="review-icon">';
			$s .= '[' . $shortcode . ']';
			$s .= '</span>';
		}

		$s .= '</div>';

		return do_shortcode($s);
	}
	add_shortcode("cts_review", "ujcfe_getReviewIcons");
}

if (!function_exists('ujcfe_getRecaptchaV2')) {
	function ujcfe_getRecaptchaV2($atts) {
		return get_theme_mod("recaptcha_site_key_v2_setting");
	}
	add_shortcode("cts_recaptcha_key_v2", "ujcfe_getRecaptchaV2");
}

if (!function_exists('ujcfe_getRecaptchaV3')) {
	function ujcfe_getRecaptchaV3($atts) {
		return get_theme_mod("recaptcha_site_key_v3_setting");
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
			return '<i class="fas fa-envelope fa-fw me-2"></i><a href="mailto:' . esc_attr($email) . '">'. esc_html($email) . '</a>';
		}
		
		return '';
	}
}

if (!function_exists('ujcfe_formatPhone')) {
	function ujcfe_formatPhone($phone) {
		if (!empty($phone)) {
			return '<i class="fas fa-mobile-alt fa-fw me-2"></i><a href="tel:' . esc_attr(preg_replace('/[^0-9]/', '', $phone)) . '">'. esc_html($phone). '</a>';
		}
		
		return '';
	}
}

if (!function_exists('ujcfe_angi_logo')) {
	function ujcfe_angi_logo() {
	return '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
			k/5v/9k=';
	}
}
