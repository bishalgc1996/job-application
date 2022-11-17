<?php
/**
 * Plugin Name:       Job Application
 * Plugin URI:        https://bishalgc.com/plugins/job-application/
 * Description:       Makes job application send easily.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Bishal GC
 * Author URI:        https://bishalgc.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://example.com/my-plugin/
 * Text Domain:       job-application
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


class Job_Application_Driver {

	/** Singleton *************************************************************/

	private static $instance;


	private function __construct() {
		/* Do nothing here */
	}

	public static function instance() {

		if ( ! isset( self::$instance )
		     && ! ( self::$instance instanceof Job_Application_Driver )
		) {
			self::$instance = new Job_Application_Driver();
			self::$instance->setup_constants();


			add_action( 'wp_enqueue_scripts',
				array( self::$instance, 'ja_enqueue_style' ) );
			add_action( 'wp_enqueue_scripts',
				array( self::$instance, 'ja_enqueue_script' ) );


			self::$instance->includes();
			self::$instance->form                = new Job_Application_Form();
			self::$instance->database            = new Database();
			self::$instance->jobapplicationadmin = new Job_Application_Admin();
			self::$instance->jobapplicationwidget
			                                     = new Job_Application_Widget();


		}

		return self::$instance;
	}

	/**
	 * Setup plugins constants.
	 *
	 * @access private
	 * @return void
	 * @since  1.0.0
	 */
	private function setup_constants() {
		// Plugin version.
		if ( ! defined( 'JA_VERSION' ) ) {
			define( 'JA_VERSION', '1.0' );
		}

		// Plugin folder Path.
		if ( ! defined( 'JA_PLUGIN_DIR' ) ) {
			define( 'JA_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
		}

		// Plugin folder URL.
		if ( ! defined( 'JA_PLUGIN_URL' ) ) {
			define( 'JA_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
		}

		// Plugin root file.
		if ( ! defined( 'JA_PLUGIN_FILE' ) ) {
			define( 'JA_PLUGIN_FILE', __FILE__ );
		}

	}

	/**
	 * Include required files.
	 *
	 * @access private
	 * @return void
	 * @since  1.0.0
	 */

	private function includes() {
		require_once JA_PLUGIN_DIR . 'includes/class-job-application.php';
		require_once JA_PLUGIN_DIR . 'includes/database.php';
		require_once JA_PLUGIN_DIR . 'includes/class-admin-job-application.php';
		require_once JA_PLUGIN_DIR . 'includes/class-widget-submission.php';
	}

	public function ja_enqueue_style() {
		$css_dir = JA_PLUGIN_URL . 'assets/css/';
		wp_enqueue_style( 'job-application-style', $css_dir . 'main.css', false,
			'1.0' );

	}

	/**
	 * Enqueue script front-end
	 *
	 * @access public
	 * @return void
	 * @since  1.0.0
	 */
	public function ja_enqueue_script() {
		$js_dir = JA_PLUGIN_URL . 'assets/js/';
		wp_enqueue_script( 'job-application-js', $js_dir . 'main.js', array(),
			'1.0', true );
	}


}


function run_job_application() {
	return Job_Application_Driver::instance();
}

global $ja_driver;
$ja_driver = run_job_application();


