<?php


/*
 * Class to register widget
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


function ja_register_widget() {
	register_widget( 'Job_Application_Widget' );
}

add_action( 'widgets_init', 'ja_register_widget' );


class Job_Application_Widget extends WP_Widget {
//Insert functions here


	function __construct() {
		parent::__construct(
// widget ID
			'ja_widget',
// widget name
			__( 'Job Application  Submission Widget', 'ja_widget_domain' ),
// widget description
			array(
				'description' => __( 'Job Application  Submission Widget',
					'ja_widget_domain' ),
			)
		);
	}

	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );
		//	echo $args['before widget'];
//if title is present
		if ( ! empty ( $title ) ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}
//output
		echo __( 'Greetings from Bishal GC!', 'ja_widget_domain' );
		echo $args['after_widget'];

		echo '<br>';

		global $wpdb;
		$table_name = $wpdb->prefix . 'applicant_submissions';

		$widget_data = $wpdb->get_results(
			$wpdb->prepare( "SELECT Application_id , FirstName , LastName, Address,Email,Mobile,Post FROM $table_name ORDER BY Date DESC LIMIT 2" ),
			ARRAY_A
		);


		//   var_dump($widget_data);


		echo '<div  class="job-submission-widget">';
		for (
			$row = 0; $row < count( $widget_data );
			$row ++
		) {
			echo '<div class="widget-box">';
			echo '<ul class="details-list">';
			echo '<div class="frontend-icon-image">';
			echo '<img src="' . JA_PLUGIN_URL . 'assets\images\person-ja.jpg'
			     . '">';
			echo '</div>';
			echo '<li> Application Id : '
			     . $widget_data[ $row ]['Application_id'] . '</li>';
			echo '<li> First Name : ' . $widget_data[ $row ]['FirstName']
			     . '</li>';
			echo '<li> Last Name : ' . $widget_data[ $row ]['LastName']
			     . '</li>';
			echo '<li> Address : ' . $widget_data[ $row ]['Address'] . '</li>';
			echo '<li> Email :' . $widget_data[ $row ]['Email'] . '</li>';
			echo '<li> Mobile : ' . $widget_data[ $row ]['Mobile'] . '</li>';
			echo '<li>Post : ' . $widget_data[ $row ]['Post'] . '</li>';
			echo '</ul>';
			echo '</div>';
		}
		echo '</div>';
	}

	public function form( $instance ) {
		if ( isset( $instance['title'] ) ) {
			$title = $instance['title'];
		} else {
			$title = __( 'Job Application Submission', 'ja_widget_domain' );
		}
		?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
            <input class="widefat"
                   id="<?php echo $this->get_field_id( 'title' ); ?>"
                   name="<?php echo $this->get_field_name( 'title' ); ?>"
                   type="text" value="<?php echo esc_attr( $title ); ?>"/>
        </p>
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance          = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) )
			? strip_tags( $new_instance['title'] ) : '';

		return $instance;
	}

}