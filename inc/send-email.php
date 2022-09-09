<?php
if ( ! function_exists( 'send_email_template' ) ) {
	function send_email_template( $type, $email, $data ) {
		$template = get_email_template( $type );
		if ( ! empty( $email ) && ! empty( $template ) ) {
			if ( file_exists( $template['content'] ) ) {
				$message = get_email_message( $data, file_get_contents( $template['content'] ) );

				return wp_mail( $email, $template['subject'], $message );
			}
		}

		return false;
	}
}

function get_shortcodes_list() {
	return array(
		'activation_link',
		'activation_link_recovery',
		'site_link',
		'user_email',
		'confirm_email_link',
		'new_user_email',
		'packaging_product_name',
		'packaging_product_size',
		'packaging_product_brand_name',
		'packaging_product_manufacturer_name',
		'packaging_experience',
		'packaging_experience_text_area',
		'packaging_image',
		'packaging_experience_couse',
		'packaging_experience_make',
		'packaging_product_again',
		'honours_date',
		'honours_made',
		'honours_number',
		'honours_delivery_contact',
		'honours_delivery_organisation',
		'honours_delivery_address',
		'honours_delivery_address_line',
		'honours_delivery_suburb',
		'honours_delivery_state',
		'honours_delivery_postcode',
		'honours_next_kin',
		'honours_next_kin_relationship',
		'honours_next_kin_address',
		'honours_next_kin_address_line',
		'honours_next_kin_suburb',
		'honours_next_kin_state',
		'honours_next_kin_postcode',
		'honours_order_number',
		'booklets_first_name',
		'booklets_entry_id',
		'booklets_last_name',
		'booklets_address_line1',
		'booklets_address_line2',
		'booklets_suburb',
		'booklets_state',
		'booklets_postcode',
		'booklets_items',
		'booklets_items_living',
		'booklets_items_other',
		'dvd_first_name',
		'dvd_last_name',
		'dvd_address_line1',
		'dvd_address_line2',
		'dvd_suburb',
		'dvd_state',
		'dvd_postcode',
		'dvd_entry_id'
	);
}

function get_email_message( $data, $message = '' ) {
	foreach ( $data as $key => $value ) {
		if ( in_array( $key, get_shortcodes_list() ) ) {
			$message = str_replace( '[' . $key . ']', $value, $message );
		}
	}
	$message = str_replace( '[image_path]', get_image_path(), $message );

	return $message;
}

function get_email_template( $type ) {
	$templates = get_emails_templates();
	if ( isset( $templates[ $type ] ) ) {
		return $templates[ $type ];
	}

	return false;
}

function get_emails_templates() {
	return array(
		'confirm_account' => array(
			'subject' => 'Confirm your Account',
			'content' => EMAIL_PLUGIN_DIR . 'email-templates/confirm-account.html'
		),
		'welcome'         => array(
			'subject' => 'Welcome to Arthritis Australia',
			'content' => EMAIL_PLUGIN_DIR . 'email-templates/welcome.html'
		),
		'reset_pass'      => array(
			'subject' => 'Your password was changed',
			'content' => EMAIL_PLUGIN_DIR . 'email-templates/reset.html'
		),
		'updated'         => array(
			'subject' => 'Your profile updated',
			'content' => EMAIL_PLUGIN_DIR . 'email-templates/updated.html'
		),
		'delete'          => array(
			'subject' => 'Account deleted',
			'content' => EMAIL_PLUGIN_DIR . 'email-templates/delete.html'
		),
		'honours'         => array(
			'subject' => 'Arthritis donation envelopes - Order confirmation',
			'content' => EMAIL_PLUGIN_DIR . 'email-templates/honours.html'
		),
		'packaging'       => array(
			'subject' => 'Arthritis packaging feedback',
			'content' => EMAIL_PLUGIN_DIR . 'email-templates/packaging.html'
		),
		'thanks'          => array(
			'subject' => 'Arthritis booklets - Order confirmation',
			'content' => EMAIL_PLUGIN_DIR . 'email-templates/thanks.html'
		),
		'thanks_dvd'          => array(
			'subject' => 'Michael Slater DVD - Order confirmation',
			'content' => EMAIL_PLUGIN_DIR . 'email-templates/thanks-dvd.html'
		),
		'confirm_email' => array(
			'subject' => 'Conirm your email',
			'content' => EMAIL_PLUGIN_DIR . 'email-templates/confirm.html'
		),
	);
}

function get_image_path() {
	return get_site_url() . '/wp-content/plugins/wp-emails/email-templates/images/';
}