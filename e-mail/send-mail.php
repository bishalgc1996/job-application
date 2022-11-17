<?php

/*
 * Email Functionality
 */




global $wpdb;
$table_ja = $wpdb->prefix.'applicant_submissions';





$to_send_email = $wpdb->get_var(
	$wpdb->prepare(
		"
			SELECT Email 
			FROM $table_ja
			
		"

	)
);

$first_name = $wpdb->get_var(
	$wpdb->prepare(
		"
			SELECT FirstName
			FROM $table_ja
			
		"

	)
);

$text = 'Hi'. $first_name . 'Your application has been recieved';



$to = $to_send_email;
$subject = "Job Application";


/* mail($to,$subject,$text); */





