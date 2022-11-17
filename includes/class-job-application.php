<?php

/*
 *
 * Class to render job aplication form
 */

class Job_Application_Form {

	public function __construct() {
		add_shortcode( 'applicant_form', array( $this, 'render_form' ) );
	}

	public function render_form() {

		ob_start();

		include_once JA_PLUGIN_DIR . 'templates/job-application-form.php';

		return ob_get_clean();


	}
}

