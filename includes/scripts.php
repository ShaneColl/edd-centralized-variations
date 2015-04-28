<?php
/**
 * Scripts
 *
 * @package     EDD\EDDCENTRALIZEDVARIATIONS\Scripts
 * @since       0.1
 */


// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;


/**
 * Load admin scripts
 *
 * @since       0.1
 * @global      array $edd_settings_page The slug for the EDD settings page
 * @global      string $post_type The type of post that we are editing
 * @return      void
 */
function edd_centralized_variations_admin_scripts( $hook ) {
    global $edd_settings_page, $post_type;

    // Use minified libraries if SCRIPT_DEBUG is turned off
	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

    /**
     * @todo		This block loads styles or scripts explicitly on the
     *				EDD settings page.
     */
    if( $hook == $edd_settings_page ) {
        wp_enqueue_script( 'edd_centralized_variations_admin_js', EDD_CENTRALIZED_VARIATIONS_URL . '/assets/js/admin' . $suffix . '.js', array( 'jquery' ) );
        wp_enqueue_style( 'edd_centralized_variations_admin_css', EDD_CENTRALIZED_VARIATIONS_URL . '/assets/css/admin' . $suffix . '.css' );
    }
}
add_action( 'admin_enqueue_scripts', 'edd_centralized_variations_admin_scripts', 100 );


/**
 * Load frontend scripts
 *
 * @since       0.1
 * @return      void
 */
function edd_centralized_variations_scripts( $hook ) {
    // Use minified libraries if SCRIPT_DEBUG is turned off
	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

    wp_enqueue_script( 'edd_centralized_variations_js', EDD_CENTRALIZED_VARIATIONS_URL . '/assets/js/scripts' . $suffix . '.js', array( 'jquery' ) );
    wp_enqueue_style( 'edd_centralized_variations_css', EDD_CENTRALIZED_VARIATIONS_URL . '/assets/css/styles' . $suffix . '.css' );
}
add_action( 'wp_enqueue_scripts', 'edd_centralized_variations_scripts' );
