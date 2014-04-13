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
				'description' 	=> __( 'Use this section to style the course indicator output. For complete SCC output style options, you should install the ', 'scc_front_display' ) . '<a href="http://buildwpyourself.com/downloads/scc-customizer/" target="_blank">' . 'SCC Customizer' . __( ' plugin', 'scc_front_display' ) . '</a>.',
				'priority'   	=> 100,
			) );
			
		}

		// font size
		$wp_customize->add_setting( 'sccfd_font_size', array( 'default' => '' ) );		
		$wp_customize->add_control( 'sccfd_font_size', array(
		    'label' 	=> __( 'Front Display Font Size', 'scc_front_display' ),
		    'section' 	=> $sccfd_customizer,
			'settings' 	=> 'sccfd_font_size',
			'priority'	=> 82,
		) );
		
		// font color
		$colors[] = array(
			'slug'		=>'sccfd_text_color', 
			'label'		=> __( 'Front Display Text Color', 'scc_front_display' ),
			'priority'	=> 83
		);
		
		// background color
		$colors[] = array(
			'slug'		=>'sccfd_background', 
			'label'		=> __( 'Front Display Background Color', 'scc_front_display' ),
			'priority'	=> 84
		);

		// border pixels top/bottom
		$wp_customize->add_setting( 'sccfd_border_top_bottom', array( 'default' => '' ) );		
		$wp_customize->add_control( 'sccfd_border_top_bottom', array(
		    'label' 	=> __( 'Front Display Border Width (Top/Bottom)', 'scc_front_display' ),
		    'section' 	=> $sccfd_customizer,
			'settings' 	=> 'sccfd_border_top_bottom',
			'priority'	=> 85,
		) );

		// border pixels left/right
		$wp_customize->add_setting( 'sccfd_border_left_right', array( 'default' => '' ) );		
		$wp_customize->add_control( 'sccfd_border_left_right', array(
		    'label' 	=> __( 'Front Display Border Width (Left/Right)', 'scc_front_display' ),
		    'section' 	=> $sccfd_customizer,
			'settings' 	=> 'sccfd_border_left_right',
			'priority'	=> 86,
		) );
		
		// border color
		$colors[] = array(
			'slug'		=>'sccfd_border_color', 
			'label'		=> __( 'Front Display Border Color', 'scc_front_display' ),
			'priority'	=> 87
		);

		// border radius
		$wp_customize->add_setting( 'sccfd_border_radius', array( 'default' => '' ) );		
		$wp_customize->add_control( 'sccfd_border_radius', array(
		    'label' 	=> __( 'Front Display Border Radius', 'scc_front_display' ),
		    'section' 	=> $sccfd_customizer,
			'settings' 	=> 'sccfd_border_radius',
			'priority'	=> 88,
		) );

		// padding
		$wp_customize->add_setting( 'sccfd_padding', array( 'default' => '' ) );		
		$wp_customize->add_control( 'sccfd_padding', array(
		    'label' 	=> __( 'Front Display Padding', 'scc_front_display' ),
		    'section' 	=> $sccfd_customizer,
			'settings' 	=> 'sccfd_padding',
			'priority'	=> 89,
		) );

		// margin bottom
		$wp_customize->add_setting( 'sccfd_margin_bottom', array( 'default' => '' ) );		
		$wp_customize->add_control( 'sccfd_margin_bottom', array(
		    'label' 	=> __( 'Front Display Bottom Margin', 'scc_front_display' ),
		    'section' 	=> $sccfd_customizer,
			'settings' 	=> 'sccfd_margin_bottom',
			'priority'	=> 89,
		) );
		
		// build settings from $colors array
		foreach( $colors as $color ) {
	
			// customizer settings
			$wp_customize->add_setting( $color['slug'], array(
				'default'		=> $color['default'],
				'type'			=> 'option', 
				'capability'	=>  'edit_theme_options'
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
	 * styles for the customizer settings
	 */
	public function customizer_styles() { ?>
		<style type="text/css">
			#customize-control-sccfd_border input[type="text"],
			#customize-control-sccfd_border_top_bottom input[type="text"],
			#customize-control-sccfd_border_left_right input[type="text"],
			#customize-control-sccfd_border_radius input[type="text"],
			#customize-control-sccfd_padding input[type="text"],
			#customize-control-sccfd_font_size input[type="text"],
			#customize-control-sccfd_margin_bottom input[type="text"] { width: 50px; }
			#customize-control-sccfd_border input[type="text"]:after,
			#customize-control-sccfd_border_top_bottom input[type="text"]:after,
			#customize-control-sccfd_border_left_right input[type="text"]:after,
			#customize-control-sccfd_border_radius input[type="text"]:after,
			#customize-control-sccfd_padding input[type="text"]:after,
			#customize-control-sccfd_font_size input[type="text"]:after,
			#customize-control-sccfd_margin_bottom input[type="text"]:after { content: "px"; }
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
		$sccfd_font_size = get_theme_mod( 'sccfd_font_size' );
		$sccfd_background = get_option( 'sccfd_background' );
		$sccfd_border_top_bottom = get_theme_mod( 'sccfd_border_top_bottom' );
		$sccfd_border_left_right = get_theme_mod( 'sccfd_border_left_right' );
		$sccfd_border_color = get_option( 'sccfd_border_color' );
		$sccfd_border_radius = get_theme_mod( 'sccfd_border_radius' );
		$sccfd_padding = get_theme_mod( 'sccfd_padding' );
		$sccfd_text_color = get_option( 'sccfd_text_color' );
		$sccfd_margin_bottom = get_theme_mod( 'sccfd_margin_bottom' );

		echo ! $this->sccc_active ? '<style type="text/css">' : ''; // do we need a new <style> tag?
			echo '.scc-front-display{';
			
				echo 'display: inline-block;';
					
				// font size
				if ( $sccfd_font_size ) :
					echo "font-size:" . intval( $sccfd_font_size ) . "px;";	
				endif;
					
				// background
				if ( $sccfd_background ) :
					echo "background:{$sccfd_background};";	
				endif;
					
				// border width
				if ( $sccfd_border != '' ) :
					echo "border:" . intval( $sccfd_border ) . "px solid {$sccfd_border_color};";		
				endif;

				// border radius
				if ( $sccfd_border_radius != '' ) :
					echo "border-radius:" . intval( $sccfd_border_radius ) . "px;";
				endif;

				// padding top/bottom
				if ( $sccfd_border_top_bottom != '' ) :
					echo "padding-top:" . intval( $sccfd_border_top_bottom ) . "px;";
					echo "padding-bottom:" . intval( $sccfd_border_top_bottom ) . "px;";
				endif;

				// padding left/right
				if ( $sccfd_border_left_right != '' ) :
					echo "padding-right:" . intval( $sccfd_border_left_right ) . "px;";
					echo "padding-left:" . intval( $sccfd_border_left_right ) . "px;";
				endif;
				
				// course indicator text color
				if ( $sccfd_text_color ) :
					echo "color:{$sccfd_text_color};";		
				endif;

				// margin bottom
				if ( $sccfd_padding != '' ) :
					echo "margin-bottom:" . intval( $sccfd_margin_bottom ) . "px;";
				endif;
		
			echo '}';			
		echo ! $this->sccc_active ? '</style>' : '';
	}
}
new SCC_Front_Display_Customizer();