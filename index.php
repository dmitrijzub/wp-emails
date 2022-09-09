<?php
/*
Plugin Name: Emails Templates
Description: Change default registration emails notifications.
Version: 1.0
*/

define(  'EMAIL_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define('EMAIL_PLUGIN_URL', plugins_url( 'wp-emails' ) );

include EMAIL_PLUGIN_DIR . '/inc/send-email.php';


if ( !function_exists('wp_new_user_notification') ) {
	function wp_new_user_notification( $user_id, $plaintext_pass = '' ) {
		$new_pass = wp_generate_password( 8, false );
		
		wp_set_password( $new_pass, $user_id );
		$user = new WP_User($user_id);

		send_email_template( 'register', $user->user_email, null, $user->display_name, $new_pass );
	}
}

add_filter( 'wp_mail_from_name', 'vortal_wp_mail_from_name' );
function vortal_wp_mail_from_name( $email_from ) {
	return 'Arthritis Australia';
}

add_filter( 'wp_mail_content_type', 'set_html_content_type' );
function set_html_content_type() {
	return 'text/html';
}