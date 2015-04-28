<?php
/**
 * Helper Functions
 *
 * @package     EDD\EDDCENTRALIZEDVARIATIONS\Functions
 * @since       0.1
 */


/**
 * Create settings menu
 *
 * Creates the settings menu within the EDD settings
 *
 * @since 0.1
 * @return settings
 */
function edd_centralized_variations_add_settings($settings) {
 
	$centralized_variations_settings = array(
		array(
			'id' => 'centralized_variations_settings',
			'name' => '<strong>' . __('Centralized Variations Settings', 'edds') . '</strong>',
			'desc' => __('Configure the Centralized Variations settings', 'edds'),
			'type' => 'header'
		),
		array(
			'id' => 'add_new',
			'name' => __('Live Secret Key', 'edds'),
			'desc' => __('Enter your live secret key, found in your Stripe Account Settins', 'edds'),
			'type' => 'text',
			'size' => 'regular'
		)
	);
	return array_merge($settings, $centralized_variations_settings);

}
add_filter('edd_settings_misc', 'edd_centralized_variations_add_settings');

/**
 * Trying to decide wheteher to use an exclusive admin settings page
 *
 * Creates a submeu underneath downloads
 *
 * @since 0.1
 * @return void
 */
function edd_centralized_variations_submenu() {
		add_submenu_page( 'edit.php?post_type=download', 'Centralized Variations', 'Centralized Variations', 'manage_options', 'Centralized Variations' );
}
add_filter('admin_menu', 'edd_centralized_variations_submenu');