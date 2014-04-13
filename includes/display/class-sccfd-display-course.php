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
	
		// set leading text and filter it
		$course_leading_text = apply_filters( 'course_leading_text', __( 'This post is part of the', 'scc_front_display' ) );
		$course_trailing_text = apply_filters( 'course_trailing_text', 'course.' );
		
		// what's the name of the course?
		$course_info = get_the_term_list( $post->ID, 'course', $course_leading_text . ' ', '', ' ' . $course_trailing_text );
		
		// don't link to the course's archive page... just display its name
		$course_info = strip_tags( $course_info );
		
		// only display the course output if it exists and it's the 
		// blog home, archive, or search results
		if ( is_home() || is_archive() || is_search() ) :
			echo $course_info != '' ? '<span class="scc-front-display">' . $course_info . '</span>' : '';
		endif;
			
		return $content;
	}
}
new SCCFD_Display_Course();