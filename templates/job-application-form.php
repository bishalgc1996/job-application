<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


if ( isset( $_POST['submit-ja-form'] ) ) {

	$first_name      = sanitize_text_field( $_POST['firstname'] );
	$last_name       = sanitize_text_field( $_POST['lastname'] );
	$address         = sanitize_text_field( $_POST['address'] );
	$email_address   = sanitize_email( $_POST['email-address'] );
	$mobile_number   = sanitize_text_field( $_POST['phone'] );
	$post_name       = sanitize_text_field( $_POST['job-post-name'] );
	$submission_date = date( "Y-m-d" );
	$cv              = $_FILES['application_cv']['name'];
	$cv_temp_file    = $_FILES['application_cv']['tmp_name'];
	move_uploaded_file( $cv_temp_file, JA_PLUGIN_DIR . "files/$cv" );

	/*
	$query
		= "INSERT INTO $table(application_id, FirstName, LastName, Address, Email, Mobile,Post,CV) ";
	$query             .= "VALUES('{$application_id}', '{$first_name}', '{$last_name}',  '{$address}', '{$email_address}','{$mobile_number}', {$post_name}, '{$cv}')";
	*/


	global $wpdb;
	$table_ja = $wpdb->prefix . 'applicant_submissions';

	$data = array(
		'Date'      => $submission_date,
		'FirstName' => $first_name,
		'LastName'  => $last_name,
		'Address'   => $address,
		'Email'     => $email_address,
		'Mobile'    => $mobile_number,
		'Post'      => $post_name,
		'CV'        => $cv
	);
	$wpdb->insert( $table_ja, $data );


	include_once JA_PLUGIN_DIR . 'templates/thankyou.php';
	include_once JA_PLUGIN_DIR . 'e-mail/send-mail.php';


} else {

	?>

    <div class="container-ja">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="row-ja">
                <div class="col-25">
                    <label for="fname">First Name</label>
                </div>
                <div class="col-75">
                    <input type="text" id="fname" name="firstname"
                           placeholder="Your name..">
                </div>
            </div>
            <div class="row-ja">
                <div class="col-25">
                    <label for="lname">Last Name</label>
                </div>
                <div class="col-75">
                    <input type="text" id="lname" name="lastname"
                           placeholder="Your last name..">
                </div>
            </div>
            <div class="row-ja">
                <div class="col-25">
                    <label for="country">Address</label>
                </div>
                <div class="col-75">
                    <input type="text" name="address" class="form-control"
                           id="inputAddress" placeholder="1234 Main St">
                </div>
            </div>
            <div class="row-ja">
                <div class="col-25">
                    <label for="subject">Email Address</label>
                </div>
                <div class="col-75">
                    <input id="subject" type="email" name="email-address"
                           placeholder="Email..."></input>
                </div>
            </div>
            <br>
            <div class="row-ja">
                <div class="col-25">
                    <label for="subject">Mobile Number</label>
                </div>
                <div class="col-75">
                    <input type="tel" id="phone" name="phone">
                </div>
            </div>
            <br>
            <div class="row-ja">
                <div class="col-25">
                    <label for="subject">Post Name</label>
                </div>
                <div class="col-75">
                    <input id="post-name" type="text" name="job-post-name"
                           placeholder="Post Name..."></input>
                </div>
            </div>
            <br>
            <div class="row-ja">
                <div class="col-25">
                    <label for="file">CV Upload</label>
                </div>

                <div class="col-75">
                    <input type="file" name="application_cv">
                </div>


            </div>
            <br>
            <div class="row">
                <input type="submit" value="Submit" name="submit-ja-form">
            </div>
        </form>
    </div>
	<?php
}
