<?php
/**
 * Getting started introduction guide.
 *
 * @package   @@pkg.name
 * @author    @@pkg.author
 * @license   @@pkg.license
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Login_Designer_Intro' ) ) :

	/**
	 * Enqueues JS & CSS assets
	 */
	class Login_Designer_Intro {

		/**
		 * The class constructor.
		 * Adds actions to enqueue our assets.
		 */
		public function __construct() {

			$options = get_option( 'login_designer_settings' );

			// Check if any saved options exist. If they do return early and don't show the intro.
			if ( $options ) {
				return false;
			}

			add_action( 'login_enqueue_scripts', array( $this, 'styles' ), 99 );
			add_action( 'customize_preview_init', array( $this, 'scripts' ) );
		}

		/**
		 * Enqueue the styles for Intro.js.
		 *
		 * @access public
		 */
		public function styles() {

			if ( ! is_customize_preview() ) {
				return;
			}

			$css_dir = LOGIN_DESIGNER_PLUGIN_URL . 'assets/css/';

			// Use minified libraries if SCRIPT_DEBUG is turned off.
			$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

			wp_enqueue_style( 'login-designer-intro', $css_dir . 'login-designer-intro' . $suffix . '.css', LOGIN_DESIGNER_VERSION, 'all' );
		}

		/**
		 * Enqueues Intro.JS in the Customizer.
		 */
		public function scripts() {
			wp_enqueue_script( 'login-designer-intro', LOGIN_DESIGNER_PLUGIN_URL . 'assets/js/dist/intro.min.js', array( 'customize-preview' ), LOGIN_DESIGNER_VERSION, true );
			wp_add_inline_script( 'login-designer-intro', 'introJs().addHints();' );
		}

		/**
		 * Initializes Intro.js within the Customizer.
		 */
		public function inline_scripts() {
			echo "<script>( function ( $ ) { introJs().addHints(); } )( jQuery );</script>\n";
		}
	}

endif;

new Login_Designer_Intro();
