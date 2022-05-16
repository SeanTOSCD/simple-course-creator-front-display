<?php
/**
 * SCCFD_Display_Course class
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) exit; // No accessing this file directly


class SCCFD_Display_Course {


	/**
	 * constructor for SCCFD_Display_Course class
	 */
	public function __construct() {

		// display course on blog, archives, and search
		add_filter( 'the_content', array( $this, 'scc_front_display' ) );
	}


	/**
	 * add front display course indicator
	 */
	public function scc_front_display( $content ) {
		global $post;

		// get the name of the course if it exists
		$course_info = get_the_term_list( $post->ID, 'course' );

		// bail if there is no course
		if ( ! $course_info ) {
			return $content;
		}

		// get the front display output
		$course_output = apply_filters( 'scc_front_display_output',
			sprintf( __( 'This post is part of the %s course.', 'scc_front_display' ), $course_info )
		);

		// only display the output on blog home, archive, and search results
		if ( ( is_home() || is_archive() || is_search() ) ) :
			$content = '<p class="scc-front-display">' . $course_output . '</p> ' . $content;
		endif;

		return $content;
	}
}
new SCCFD_Display_Course();