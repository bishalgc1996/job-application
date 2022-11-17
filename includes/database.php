<?php

/*
 * Database Class
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
 *  Database Class
 */

class Database {

	public function __construct() {
		$this->create_db_table();
	}


	public function create_db_table() {

		global $wpdb;

		$table_name = $wpdb->prefix . 'applicant_submissions';

		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE $table_name (
  Application_id mediumint(9) NOT NULL AUTO_INCREMENT,
  Date date,
   FirstName varchar(255),
  LastName varchar(255),
    Address varchar(255),
    Email  varchar(255),
    Mobile  varchar(255),
    Post  varchar(255),
    CV varchar(255),
    
  PRIMARY KEY  (Application_id)
) $charset_collate;";


		if ( $wpdb->get_var( "SHOW TABLES LIKE '$table_name'" )
		     != $table_name
		) {
			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

			dbDelta( $sql );
		}


	}
}
