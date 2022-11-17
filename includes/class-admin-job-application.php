<?php

/**
 * The admin-specific functionality of the plugin.
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
*  Admin Page Functionality
*/

class Job_Application_Admin {


	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'add_menu_pages' ) );
		add_action( 'admin_enqueue_scripts',
			array( $this, 'enqueue_admin_scripts' ) );
		add_action( 'admin_enqueue_scripts',
			array( $this, 'enqueue_admin_styles' ) );
	}

	/**
	 * Create the Admin menu and submenu and assign their links to global varibles.
	 *
	 * @return void
	 * @since 1.0
	 */
	public function add_menu_pages() {
		add_menu_page( __( 'Job Application', 'job-application' ),
			__( 'Job Application Settings', 'job-application' ),
			'manage_options', 'job_application_page',
			array( $this, 'admin_page' ), 'dashicons-portfolio', '30' );
	}

	/**
	 * Load Admin page.
	 *
	 * @return void
	 * @since 1.0
	 */
	public function admin_page() {
		?>
        <div class="job-application-admin-container">
            <div class="job-application-admin-row">
                <h3>Admin Page</h3>
                <div class="topnav">
                    <input type="text" id="myInput" onkeyup="search()"
                           placeholder="Search..">
                    <button class="sort-entry  sort-entry--start">Sort By Newest
                        Submission
                    </button>
                </div>
                <div class="job-application-admin-table">
					<?php
					global $wpdb;

					$table_name = $wpdb->prefix . 'applicant_submissions';


					$application_data = $wpdb->get_results(
						$wpdb->prepare( "SELECT * FROM $table_name " ), ARRAY_A
					);

					if ( isset( $_POST['delete'] ) ) {
						$the_application_id = $_POST['delete'];
						$wpdb->delete( $table_name, array(
							'Application_id' => $the_application_id
						) );
						//	echo $the_application_id;

					}


					?>
                    <form method="post" action="<?php echo admin_url()
					                                       . 'admin.php?page=job_application_page'; ?>">
                        <table id="ja-table" class="ja-details-admin-table">
                            <thead>
                            <tr>
								<?php
								foreach (
									$wpdb->get_col( "DESC " . $table_name, 0 )
									as
									$column_name
								) {
									echo '<th>' . $column_name . '</th>';
								}

								echo '<th>' . 'Action' . '</th>';
								?>
                            </tr>
                            </thead>
                            <tbody>
							<?php
							if ( ! empty( $application_data ) ) {
								for (
									$row = 0; $row < count( $application_data );
									$row ++
								) {
									echo '<tr>';
									echo "<td>"
									     . $application_data[ $row ]['Application_id']
									     . "</td>";
									echo "<td>"
									     . $application_data[ $row ]['Date']
									     . "</td>";
									echo "<td>"
									     . $application_data[ $row ]['FirstName']
									     . "</td>";
									echo "<td>"
									     . $application_data[ $row ]['LastName']
									     . "</td>";
									echo "<td>"
									     . $application_data[ $row ]['Address']
									     . "</td>";
									echo "<td>"
									     . $application_data[ $row ]['Email']
									     . "</td>";
									echo "<td>"
									     . $application_data[ $row ]['Mobile']
									     . "</td>";
									echo "<td>"
									     . $application_data[ $row ]['Post']
									     . "</td>";
									echo "<td>"
									     . $application_data[ $row ]['CV']
									     . "</td>";

									echo '<td><button class="ja-delete" name="delete" value="'
									     . $application_data[ $row ]['Application_id']
									     . ' ">' . 'Delete' . '</button></td>';
									echo '</tr>';
								}
							}

							?>
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
		<?php


		?>
		<?php

	}

	/**
	 * Load Admin Styles.
	 *
	 * Enqueues the required admin styles.
	 *
	 * @param  string  $hook  Page hook.
	 *
	 * @return void
	 * @since 1.0
	 */
	public function enqueue_admin_styles( $hook ) {

		$css_dir = JA_PLUGIN_URL . 'assets/css/';
		wp_enqueue_style( 'admin-style', $css_dir . 'admin-main.css', false,
			'1.12.0' );

	}

	/**
	 * Load Admin Scripts
	 *
	 * Enqueues the required admin scripts.
	 *
	 * @param  string  $hook  Page hook.
	 *
	 * @return void
	 * @since 1.0
	 */
	public function enqueue_admin_scripts( $hook ) {

		$js_dir = JA_PLUGIN_URL . 'assets/js/';
		wp_register_script( 'admin-table-script', $js_dir . 'admin-table-ja.js',
			array(), JA_VERSION, true );
		wp_enqueue_script( 'admin-table-script' );

	}


}

