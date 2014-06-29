<?php
/**
 * SCC_Front_Display_Customizer class
 *
 * The plugin will first check to see if Simple Course Creator Customizer
 * is activated (http://buildwpyourself.com/downloads/scc-customizer/) and
 * if so, add settings to the "Simple Course Creator Design" section.
 *
 * If Simple Course Creator Customizer is not installed, a new section will
 * be created with style options.
 *
 * None of this is done if Simple Course Creator is not activated.
 * (http://buildwpyourself.com/downloads/simple-course-creator/)
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) exit; // No accessing this file directly


class SCC_Front_Display_Customizer {

		
	/**
	 * check for Simple Course Creator Customizer plugin
	 */
	private $sccc_active;

		
	/**
	 * constructor for SCC_Front_Display_Customizer class
	 */
	public function __construct() {
	
		// is Simple Course Creator Customizer active?
		$this->sccc_active = class_exists( 'Simple_Course_Creator_Customizer' );
	
		// load customizer functionality
		add_action( 'customize_register', array( $this, 'settings' ) );

		// customizer styles
		add_action( 'customize_controls_print_styles', array( $this, 'customizer_styles' ) );
		
		// If Simple Course Creator Customizer is installed, hook into
		// its <style> section of the head. If not, go for wp_head(). 
		$scc_styles_loc = $this->sccc_active ? 'scc_add_to_styles' : 'wp_head';
		add_action( $scc_styles_loc, array( $this, 'head_styles' ) );
	}


	/** 
	 * create customizer settings
	 */
	public function settings( $wp_customize ) {
		
		// color customization options
		$colors = array();
		
		// which section do we use? well... what plugins are installed?
		$sccfd_customizer = $this->sccc_active ? 'scc_customizer' : 'scc_front_display_customizer';
		
		if ( ! $this->sccc_active ) {
		
			$wp_customize->add_section( 'scc_front_display_customizer', array(
		    	'title'       	=> 'SCC Front Display ' . __( 'Design', 'scc_front_display' ),
				'description' 	=> sprintf( __( 'Use this section to style the course indicator output. For complete SCC output style options, you should install the %s plugin.', 'scc_front_display' ), '<a href="http://buildwpyourself.com/downloads/scc-customizer/" target="_blank">SCC Customizer</a>' ),
				'priority'   	=> 100,
			) );
			
		}

		// font size
		$wp_customize->add_setting( 'sccfd_font_size', array(
			'default'			=> '',
			'sanitize_callback'	=> array( $this, 'scc_front_display_sanitize_integer' ),
		) );		
		$wp_customize->add_control( 'sccfd_font_size', array(
		    'label' 	=> __( 'Front Display Font Size', 'scc_front_display' ),
		    'section' 	=> $sccfd_customizer,
			'settings' 	=> 'sccfd_font_size',
			'priority'	=> 201
		) );
		
		// font weight
		$wp_customize->add_setting( 'sccfd_font_weight', array(
			'default'			=> 0,
			'sanitize_callback'	=> array( $this, 'scc_front_display_sanitize_checkbox' ),
		) );
		$wp_customize->add_control( 'sccfd_font_weight', array(
			'label'		=> __( 'Front Display Bold Font', 'scc_front_display' ),
			'section'	=> $sccfd_customizer,
			'type'      => 'checkbox',
			'priority'	=> 202
		) );
		
		// font color
		$colors[] = array(
			'slug'		=>'sccfd_text_color', 
			'label'		=> __( 'Front Display Text Color', 'scc_front_display' ),
			'priority'	=> 203
		);
		
		// background color
		$colors[] = array(
			'slug'		=>'sccfd_background', 
			'label'		=> __( 'Front Display Background Color', 'scc_front_display' ),
			'priority'	=> 204
		);

		// padding top/bottom
		$wp_customize->add_setting( 'sccfd_padding_top_bottom', array(
			'default'			=> '',
			'sanitize_callback'	=> array( $this, 'scc_front_display_sanitize_integer' ),
		) );		
		$wp_customize->add_control( 'sccfd_padding_top_bottom', array(
		    'label' 	=> __( 'Front Display Padding (Top/Bottom)', 'scc_front_display' ),
		    'section' 	=> $sccfd_customizer,
			'settings' 	=> 'sccfd_padding_top_bottom',
			'priority'	=> 205
		) );

		// padding left/right
		$wp_customize->add_setting( 'sccfd_padding_left_right', array(
			'default'			=> '',
			'sanitize_callback'	=> array( $this, 'scc_front_display_sanitize_integer' ),
		) );		
		$wp_customize->add_control( 'sccfd_padding_left_right', array(
		    'label' 	=> __( 'Front Display Padding (Left/Right)', 'scc_front_display' ),
		    'section' 	=> $sccfd_customizer,
			'settings' 	=> 'sccfd_padding_left_right',
			'priority'	=> 206
		) );

		// border
		$wp_customize->add_setting( 'sccfd_border', array(
			'default'			=> '',
			'sanitize_callback'	=> array( $this, 'scc_front_display_sanitize_integer' ),
		) );	
		$wp_customize->add_control( 'sccfd_border', array(
		    'label' 	=> __( 'Front Display Border Width', 'scc_front_display' ),
		    'section' 	=> $sccfd_customizer,
			'settings' 	=> 'sccfd_border',
			'priority'	=> 207
		) );
		
		// border color
		$colors[] = array(
			'slug'		=>'sccfd_border_color', 
			'label'		=> __( 'Front Display Border Color', 'scc_front_display' ),
			'priority'	=> 208
		);

		// border radius
		$wp_customize->add_setting( 'sccfd_border_radius', array(
			'default'			=> '',
			'sanitize_callback'	=> array( $this, 'scc_front_display_sanitize_integer' ),
		) );		
		$wp_customize->add_control( 'sccfd_border_radius', array(
		    'label' 	=> __( 'Front Display Border Radius', 'scc_front_display' ),
		    'section' 	=> $sccfd_customizer,
			'settings' 	=> 'sccfd_border_radius',
			'priority'	=> 209
		) );

		// margin bottom
		$wp_customize->add_setting( 'sccfd_margin_bottom', array(
			'default'			=> '',
			'sanitize_callback'	=> array( $this, 'scc_front_display_sanitize_integer' ),
		) );	
		$wp_customize->add_control( 'sccfd_margin_bottom', array(
		    'label' 	=> __( 'Front Display Bottom Margin', 'scc_front_display' ),
		    'section' 	=> $sccfd_customizer,
			'settings' 	=> 'sccfd_margin_bottom',
			'priority'	=> 210
		) );
		
		// build settings from $colors array
		foreach( $colors as $color ) {
	
			// customizer settings
			$wp_customize->add_setting( $color['slug'], array(
				'default'		=> $color['default'],
				'type'			=> 'option', 
				'capability'	=> 'edit_theme_options'
			) );
	
			// customizer controls
			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $color['slug'], array(
				'label'		=> $color['label'], 
				'section'	=> $sccfd_customizer,
				'settings'	=> $color['slug'],
				'priority'	=> $color['priority']
			) ) );
		}
	}


	/** 
	 * sanitize checkbox options
	 */
	function scc_front_display_sanitize_checkbox( $input ) {
	    if ( 1 == $input ) :
	        return 1;
	    else :
	        return 0;
	    endif;
	}


	/**
	 * sanitize integer input
	 */
	public function scc_front_display_sanitize_integer( $input ) {
		if ( '' == $input ) :
			return '';
		endif;
		
		return absint( $input );
	}


	/**
	 * sanitize hex colors
	 */
	public function scc_front_display_sanitize_hex_color( $color ) {
		if ( '' === $color ) :
			return '';
	    endif;
	
		// 3 or 6 hex digits, or the empty string.
		if ( preg_match('|^#([A-Fa-f0-9]{3}){1,2}$|', $color ) ) :
			return $color;
	    endif;
	
		return null;
	}


	/**
	 * styles for the customizer settings
	 */
	public function customizer_styles() { ?>
		<style type="text/css">
			#customize-control-sccfd_border input[type="text"],
			#customize-control-sccfd_border_radius input[type="text"],
			#customize-control-sccfd_padding_top_bottom input[type="text"],
			#customize-control-sccfd_padding_left_right input[type="text"],
			#customize-control-sccfd_font_size input[type="text"],
			#customize-control-sccfd_margin_bottom input[type="text"] { width: 50px; }
			#customize-control-sccfd_font_weight { display: inline-block; margin-top: 20px; }
			#customize-control-sccfd_border label:after,
			#customize-control-sccfd_border_radius label:after,
			#customize-control-sccfd_padding_top_bottom label:after,
			#customize-control-sccfd_padding_left_right label:after,
			#customize-control-sccfd_font_size label:after,
			#customize-control-sccfd_margin_bottom label:after { content: "px"; }
		</style>
	<?php }
	
	
	/**
	 * add customizer styles to <head>
	 *
	 * If Simple Course Creator Customizer is installed, hook into
	 * its <style> section of the head using the "scc_add_to_styles"
	 * hook. If not, create a new one <style> section through wp_head().
	 */
	public function head_styles() {
		$sccfd_font_size			= get_theme_mod( 'sccfd_font_size' );
		$sccfd_font_weight			= get_theme_mod( 'sccfd_font_weight' );
		$sccfd_background			= get_option( 'sccfd_background' );
		$sccfd_border				= get_theme_mod( 'sccfd_border' );
		$sccfd_border_color			= get_option( 'sccfd_border_color' );
		$sccfd_border_radius		= get_theme_mod( 'sccfd_border_radius' );
		$sccfd_padding_top_bottom	= get_theme_mod( 'sccfd_padding_top_bottom' );
		$sccfd_padding_left_right	= get_theme_mod( 'sccfd_padding_left_right' );
		$sccfd_text_color			= get_option( 'sccfd_text_color' );
		$sccfd_margin_bottom		= get_theme_mod( 'sccfd_margin_bottom' );

		echo ! $this->sccc_active ? '<style type="text/css">' : ''; // do we need a new <style> tag?
			echo '.scc-front-display{';
			
				echo 'display: inline-block;';
					
				// font size
				if ( $sccfd_font_size ) :
					echo 'font-size:' . intval( $sccfd_font_size ) . 'px;';
				endif;
				
				// font weight
				if ( 1 == $sccfd_font_weight ) :
					echo 'font-weight:bold;';
				endif;
					
				// background
				if ( $sccfd_background ) :
					echo 'background:' . $this->scc_front_display_sanitize_hex_color( $sccfd_background ) . ';';
				endif;
					
				// border width
				if ( $sccfd_border != '' ) :
					echo 'border:' . intval( $sccfd_border ) . 'px solid ' . $this->scc_front_display_sanitize_hex_color( $sccfd_border_color ) . ';';
				endif;

				// border radius
				if ( $sccfd_border_radius != '' ) :
					echo 'border-radius:' . intval( $sccfd_border_radius ) . 'px;';
				endif;

				// padding top/bottom
				if ( $sccfd_padding_top_bottom != '' ) :
					echo 'padding-top:' . intval( $sccfd_padding_top_bottom ) . 'px;';
					echo 'padding-bottom:' . intval( $sccfd_padding_top_bottom ) . 'px;';
				endif;

				// padding left/right
				if ( $sccfd_padding_left_right != '' ) :
					echo 'padding-right:' . intval( $sccfd_padding_left_right ) . 'px;';
					echo 'padding-left:' . intval( $sccfd_padding_left_right ) . 'px;';
				endif;
				
				// course indicator text color
				if ( $sccfd_text_color ) :
					echo 'color:' . $this->scc_front_display_sanitize_hex_color( $sccfd_text_color ) . ';';		
				endif;

				// margin bottom
				if ( $sccfd_margin_bottom != '' ) :
					echo 'margin-bottom:' . intval( $sccfd_margin_bottom ) . 'px;';
				endif;
		
			echo '}';			
		echo ! $this->sccc_active ? '</style>' : '';
	}
}
new SCC_Front_Display_Customizer();