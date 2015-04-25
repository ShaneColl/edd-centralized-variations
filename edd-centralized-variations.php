<?php
/**
 * Plugin Name:     EDD Centralized Variations
 * Plugin URI:      http://easydigitaldownloads.com
 * Description:     Allow for centralized product variation templates
 * Version:         0.1
 * Author:          Shane Coll
 * Author URI:      http://shanecoll.com
 * Text Domain:     edd-centralized-variations
 *
 * @package         EDD\EDD Centralized Variations
 * @author          Shane Coll
 * @copyright       Copyright (c) 2015 Shane Coll
 *
 * IMPORTANT! Ensure that you make the following adjustments
 * before releasing your extension:
 *
 * - Replace all instances of plugin-name with the name of your plugin.
 *   By WordPress coding standards, the folder name, plugin file name,
 *   and text domain should all match. For the purposes of standardization,
 *   the folder name, plugin file name, and text domain are all the
 *   lowercase form of the actual plugin name, replacing spaces with
 *   hyphens.
 *
 * - Replace all instances of Plugin_Name with the name of your plugin.
 *   For the purposes of standardization, the camel case form of the plugin
 *   name, replacing spaces with underscores, is used to define classes
 *   in your extension.
 *
 * - Replace all instances of PLUGINNAME with the name of your plugin.
 *   For the purposes of standardization, the uppercase form of the plugin
 *   name, removing spaces, is used to define plugin constants.
 *
 * - Replace all instances of Plugin Name with the actual name of your
 *   plugin. This really doesn't need to be anywhere other than in the
 *   EDD Licensing call in the hooks method.
 *
 * - Find all instances of @todo in the plugin and update the relevant
 *   areas as necessary.
 *
 * - All functions that are not class methods MUST be prefixed with the
 *   plugin name, replacing spaces with underscores. NOT PREFIXING YOUR
 *   FUNCTIONS CAN CAUSE PLUGIN CONFLICTS!
 */


// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

if( !class_exists( 'EDD_Centralized_Variations' ) ) {

    /**
     * Main EDD_Centralized_Variations class
     *
     * @since       1.0.0
     */
    class EDD_Centralized_Variations {

        /**
         * @var         EDD_Centralized_Variations $instance The one true EDD_Centralized_Variations
         * @since       1.0.0
         */
        private static $instance;


        /**
         * Get active instance
         *
         * @access      public
         * @since       1.0.0
         * @return      object self::$instance The one true EDD_Centralized_Variations
         */
        public static function instance() {
            if( !self::$instance ) {
                self::$instance = new EDD_Centralized_Variations();
                self::$instance->setup_constants();
                self::$instance->includes();
                self::$instance->load_textdomain();
                self::$instance->hooks();
            }

            return self::$instance;
        }


        /**
         * Setup plugin constants
         *
         * @access      private
         * @since       1.0.0
         * @return      void
         */
        private function setup_constants() {
            // Plugin version
            define( 'EDD_CENTRALIZED_VARIATIONS_VER', '1.0.0' );

            // Plugin path
            define( 'EDD_CENTRALIZED_VARIATIONS_DIR', plugin_dir_path( __FILE__ ) );

            // Plugin URL
            define( 'EDD_CENTRALIZED_VARIATIONS_URL', plugin_dir_url( __FILE__ ) );
        }


        /**
         * Include necessary files
         *
         * @access      private
         * @since       1.0.0
         * @return      void
         */
        private function includes() {
            // Include scripts
            require_once EDD_CENTRALIZED_VARIATIONS_DIR . 'includes/scripts.php';
            require_once EDD_CENTRALIZED_VARIATIONS_DIR . 'includes/functions.php';

            /**
             * @todo        The following files are not included in the boilerplate, but
             *              the referenced locations are listed for the purpose of ensuring
             *              path standardization in EDD extensions. Uncomment any that are
             *              relevant to your extension, and remove the rest.
             */
            // require_once EDD_CENTRALIZED_VARIATIONS_DIR . 'includes/shortcodes.php';
            // require_once EDD_CENTRALIZED_VARIATIONS_DIR . 'includes/widgets.php';
        }


        /**
         * Run action and filter hooks
         *
         * @access      private
         * @since       1.0.0
         * @return      void
         *
         * @todo        The hooks listed in this section are a guideline, and
         *              may or may not be relevant to your particular extension.
         *              Please remove any unnecessary lines, and refer to the
         *              WordPress codex and EDD documentation for additional
         *              information on the included hooks.
         *
         *              This method should be used to add any filters or actions
         *              that are necessary to the core of your extension only.
         *              Hooks that are relevant to meta boxes, widgets and
         *              the like can be placed in their respective files.
         *
         *              IMPORTANT! If you are releasing your extension as a
         *              commercial extension in the EDD store, DO NOT remove
         *              the license check!
         */
        private function hooks() {
            // Register settings
            add_filter( 'edd_settings_extensions', array( $this, 'settings' ), 1 );

            // Handle licensing
            // @todo        Replace the Plugin Name and Your Name with your data
            if( class_exists( 'EDD_License' ) ) {
                $license = new EDD_License( __FILE__, 'Plugin Name', EDD_CENTRALIZED_VARIATIONS_VER, 'Your Name' );
            }
        }


        /**
         * Internationalization
         *
         * @access      public
         * @since       1.0.0
         * @return      void
         */
        public function load_textdomain() {
            // Set filter for language directory
            $lang_dir = EDD_CENTRALIZED_VARIATIONS_DIR . '/languages/';
            $lang_dir = apply_filters( 'edd_centralized_variations_languages_directory', $lang_dir );

            // Traditional WordPress plugin locale filter
            $locale = apply_filters( 'plugin_locale', get_locale(), 'edd-centralized-variations' );
            $mofile = sprintf( '%1$s-%2$s.mo', 'edd-centralized-variations', $locale );

            // Setup paths to current locale file
            $mofile_local   = $lang_dir . $mofile;
            $mofile_global  = WP_LANG_DIR . '/edd-centralized-variations/' . $mofile;

            if( file_exists( $mofile_global ) ) {
                // Look in global /wp-content/languages/edd-centralized-variations/ folder
                load_textdomain( 'edd-centralized-variations', $mofile_global );
            } elseif( file_exists( $mofile_local ) ) {
                // Look in local /wp-content/plugins/edd-centralized-variations/languages/ folder
                load_textdomain( 'edd-centralized-variations', $mofile_local );
            } else {
                // Load the default language files
                load_plugin_textdomain( 'edd-centralized-variations', false, $lang_dir );
            }
        }


        /**
         * Add settings
         *
         * @access      public
         * @since       1.0.0
         * @param       array $settings The existing EDD settings array
         * @return      array The modified EDD settings array
         */
        public function settings( $settings ) {
            $new_settings = array(
                array(
                    'id'    => 'edd_centralized_variations_settings',
                    'name'  => '<strong>' . __( 'Plugin Name Settings', 'edd-centralized-variations' ) . '</strong>',
                    'desc'  => __( 'Configure Plugin Name Settings', 'edd-centralized-variations' ),
                    'type'  => 'header',
                )
            );

            return array_merge( $settings, $new_settings );
        }
    }
} // End if class_exists check


/**
 * The main function responsible for returning the one true EDD_Centralized_Variations
 * instance to functions everywhere
 *
 * @since       1.0.0
 * @return      \EDD_Centralized_Variations The one true EDD_Centralized_Variations
 *
 * @todo        Inclusion of the activation code below isn't mandatory, but
 *              can prevent any number of errors, including fatal errors, in
 *              situations where your extension is activated but EDD is not
 *              present.
 */
function EDD_Centralized_Variations_load() {
    if( ! class_exists( 'Easy_Digital_Downloads' ) ) {
        if( ! class_exists( 'EDD_Extension_Activation' ) ) {
            require_once 'includes/class.extension-activation.php';
        }

        $activation = new EDD_Extension_Activation( plugin_dir_path( __FILE__ ), basename( __FILE__ ) );
        $activation = $activation->run();
        return EDD_Centralized_Variations::instance();
    } else {
        return EDD_Centralized_Variations::instance();
    }
}
add_action( 'plugins_loaded', 'EDD_Centralized_Variations_load' );


/**
 * The activation hook is called outside of the singleton because WordPress doesn't
 * register the call from within the class, since we are preferring the plugins_loaded
 * hook for compatibility, we also can't reference a function inside the plugin class
 * for the activation function. If you need an activation function, put it here.
 *
 * @since       1.0.0
 * @return      void
 */
function edd_centralized_variations_activation() {
    /* Activation functions here */
}
register_activation_hook( __FILE__, 'edd_centralized_variations_activation' );
