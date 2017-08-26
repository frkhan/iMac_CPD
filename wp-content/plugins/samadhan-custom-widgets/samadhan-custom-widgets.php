<?php
/**
 * The plugin bootstrap file
 *
 *
 * @link              https://Samadhan.com.au
 * @since             1.0.0
 * @package           Samadhan_Custom_Widgets_For_Corporate_Clients
 * @wordpress-plugin
 * Plugin Name:       Samadhan Custom Widgets For Corporate Clients
 * Plugin URI:        http://samadhan.com.au
 * Description:       This plugin create some custom made widget for CPD.
 * Version:           1.0.1
 * Author:            Samadhan
 * Author URI:        http://samadhan.com.au
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

require_once( dirname( __FILE__ ).'/includes/toolbar.php' );
require_once( dirname( __FILE__ ).'/includes/my_courses.php' );
require_once( dirname( __FILE__ ).'/includes/my_courses_hri.php' );
require_once( dirname( __FILE__ ).'/includes/my_credits.php' );
require_once( dirname( __FILE__ ).'/includes/my_course_progress.php' );

// If this file is called directly, abort.
if (! defined('WPINC')) {
    die;
}



add_action( 'widgets_init', 'samadhan_toolbar_widgets_init' );

function samadhan_toolbar_widgets_init() {
    register_widget( 'smdn_toolbar_class' );
    register_widget( 'smdn_mycourses_class' );
    register_widget( 'smdn_mycourses_hri_class' );
    register_widget( 'smdn_mycredits_class' );
    register_widget( 'smdn_mycourse_progress_class' );
}



