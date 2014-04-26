<?php
/**
 * Plugin Name: SCC - Front Display
 * Plugin URI: http://buildwpyourself.com/downloads/scc-front-display/
 * Description: On the blog home, archives, and search results, indicate that posts are part of a course.
 * Version: 1.0.0
 * Author: Sean Davis
 * Author URI: http://seandavis.co
 * License: GPL2
 * Requires at least: 3.8
 * Tested up to: 3.9
 * Text Domain: scc_front_display
 * Domain Path: /languages/
 * 
 * This plugin is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2, as 
 * published by the Free Software Foundation.
 * 
 * This plugin is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, see http://www.gnu.org/licenses/.
 *
 * @package Simple Course Creator
 * @category Output
 * @author Sean Davis
 * @license GNU GENERAL PUBLIC LICENSE Version 2 - /license.txt
 */


// No accessing this file directly
if ( ! defined( 'ABSPATH' ) ) exit;

// make sure SCC is activated
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
if ( is_plugin_active( 'simple-course-creator/simple-course-creator.php' ) ) :

	/**
	 * primary class for Simple Course Creator Front Display
	 *
	 * @since 1.0.0
	 */
	class Simple_Course_Creator_Front_Display {
	
			
		/**
		 * constructor for Simple_Course_Creator_Front_Display class
		 */
		public function __construct() {
			
			// define plugin directory
			define( 'SCCFD_DIR', trailingslashit( plugin_dir_path( __FILE__ ) ) );

			// load text domain
			add_action( 'init', array( $this, 'load_textdomain' ) );
	
			// require additional plugin files
			$this->includes();
		}


		/**
		 * load SCC Front Display text domain
		 */
		public function load_textdomain() {
			load_plugin_textdomain( 'scc_front_display', false, SCCFD_DIR . "languages" );
		}


		/**
		 * require additional plugin files
		 */
		private function includes() {
			require_once( SCCFD_DIR . 'includes/admin/class-scc-front-display-customizer.php' );
			require_once( SCCFD_DIR . 'includes/display/class-sccfd-display-course.php' );
		}
	}
	new Simple_Course_Creator_Front_Display();
endif; // end check to see if SCC is activated