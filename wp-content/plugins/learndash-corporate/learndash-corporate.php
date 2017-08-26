<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://Samadhan.com.au
 * @since             1.0.0
 * @package           LearnDash_Multi_Corporate_Branding
 * @wordpress-plugin
 * Plugin Name:       LearnDash Multi Corporate Branding
 * Plugin URI:        http://samadhan.com.au
 * Description:       This plugin create Corporate Landing Page LearnDash Groups.
 * Version:           1.0.1
 * Author:            Samadhan
 * Author URI:        http://samadhan.com.au
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       Learndash-multi-corporate-branding
 * Domain Path:       /languages
 */


// If this file is called directly, abort.
if (! defined('WPINC')) {  die;}

//require_once ( 'E:\Projects\iMac_CPD\wp-content\plugins\posts-to-posts\vendor\scribu\lib-posts-to-posts\api.php');
//require_once dirname( __FILE__ ) . '../posts-to-posts/vendor/scribu/lib-posts-to-posts/api.php';

//require_once( dirname( __FILE__ ).'/login-redirect.php' );
//require_once( dirname( __FILE__ ).'/logout-redirect.php' );

//new learndash_corporate\SMDN_LoginRedirect();

function join_groups_to_page() {
    if(!function_exists( 'p2p_register_connection_type' )) return ;
    p2p_register_connection_type( array(
        'name'  => 'group_to_page',
        'from'  => 'groups',
        'to'    => 'page',
        'cardinality' => 'many-to-one',
        'admin_dropdown' => 'any',
        'admin_box' => array(
            'show' => 'any',
            'context' => 'advanced'
        ),
        'admin_column' => 'any',
        'title' => array(
            'from' =>  'Landing page for this group (after login and logout)',
            'to' =>  'Associated groups that use this Brand Landing Page',
        ),
        'from_labels' => array(
            'column_title' => 'Landing page'
        ),
        'to_labels' => array(
            'column_title' => 'Associated groups'
        ),
    ) );


}


function smdn_www_login_redirect($redirect_to, $userID){
    $landing_page = smdn_get_landing_page_from_user_id($userID);
    if( isset($landing_page)) return $landing_page;
    else return $redirect_to;
}

function smdn_www_logout_redirect($redirect_to, $userID){
    $landing_page = smdn_get_landing_page_from_user_id($userID);
    if( isset($landing_page)) return $landing_page;
    else return $redirect_to;
}


function smdn_get_landing_page_from_user_id($user_id){

    /*************** CORPORATE USER LOGIN PAGE ********************** new line added */
    join_groups_to_page();
    if(!function_exists( 'p2p_type' )) return ;

    $page_id = 0;

    if($user_id > 0) {
        $user_groups_id = learndash_get_users_group_ids( $user_id, true );
        if (isset($user_groups_id[0] )) {
            if ((int)$user_groups_id[0] > 0) {
                    // https://github.com/scribu/wp-posts-to-posts/wiki/Query-vars
                $connected = new WP_Query( array(
                    'connected_type' => 'group_to_page',
                    'connected_items' => $user_groups_id[0],
                    'connected_direction' => 'from',
                    'post_status' => 'published',
                    'nopaging' => true,
                ) );


                if ( $connected->have_posts()) {
                    if (isset($connected->posts[0]) && isset( $connected->posts[0]->ID)) {
                        $page_id = $connected->posts[0]->ID;
                        return get_permalink( $page_id );
                    }
                }

            }
        }
    }

}

function smdn_run_frontend_hooks() {
    add_action( 'p2p_init', 'join_groups_to_page' );
    //add_filter( 'login_redirect',  'smdn_login_redirect', 10, 1 );
    add_filter( 'lwws_login_redirect',  'smdn_www_login_redirect', 10, 2 );
    add_filter( 'lwws_logout_redirect',  'smdn_www_logout_redirect', 10, 2 );
}


add_action( 'plugins_loaded','smdn_run_frontend_hooks' );

