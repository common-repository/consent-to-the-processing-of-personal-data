<?php
/**
 * Plugin Name: Consent to the processing of personal data
 * Description: Adds consent to the processing of personal data in the comment form for Wordpress for unauthorized users
 * Plugin URI:  https://ardeya.ru/product/dobavlenie-galochki-soglasie-na-obrabotku-personalnyh-dannyh-v-kommentarii-wordpress/
 * Author URI:  https://ardeya.ru/
 * Author:      Pavel Kokhno
 * Version:     0.8.2
 *
 * Text Domain: consent-to-the-processing-of-personal-data
 *
 * License:     GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 *
 * Network: true
 */

function cttpopd_init(){
    load_plugin_textdomain( 'consent-to-the-processing-of-personal-data', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}

add_action('plugins_loaded', 'cttpopd_init');

function cttpopd_added_checkbox( $fields ) {
    $fields['checkboxpersonal'] = '<p class="comment-form-checkboxpersonal">' .
        '<input id="checkboxpersonal" name="checkboxpersonal" type="checkbox"/>' .
        '<label for="checkboxpersonal">' . __( 'Consent to the processing of personal data', 'consent-to-the-processing-of-personal-data' ) . ' </label></p>';

    return $fields;
}

add_filter( 'comment_form_default_fields', 'cttpopd_added_checkbox' );

function cttpopd_verify_comment_meta_data( $commentdata ) {
    if ( ! isset( $_POST['checkboxpersonal'] ) and ! is_user_logged_in() )
        wp_die( __( '<p>We can not accept the comment. You have not confirmed consent to the processing of personal data... Go back and tick off "Consent to the processing of personal data"</p>
					<p><a href="javascript:history.back()">← Go back</a></p>
        ', 'consent-to-the-processing-of-personal-data' ) );
    return $commentdata;
}

add_filter( 'preprocess_comment', 'cttpopd_verify_comment_meta_data' );