<?php

namespace learndash_corporate;

if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Class LoginRedirect
 * @package uncanny_custom_toolkit
 */
class SMDN_LoginRedirect{

	/**
	 * Class constructor
	 */
	public function __construct() {
		add_action( 'plugins_loaded', array( __CLASS__, 'run_frontend_hooks' ) );
	}

	/*
	 * Initialize frontend actions and filters
	 */
	public static function run_frontend_hooks() {
			/* Hide admin bar on frontend for the user role */
			add_filter( 'login_redirect', array( __CLASS__, 'login_redirect' ), 10, 1 );
		    add_filter( 'lwws_login_redirect', array( __CLASS__, 'lwws_login_redirect' ), 10, 2 );

		//	add_action( 'wp_logout', array( __CLASS__, 'logout_redirect' ), 10, 1 );

	}



	/**
	 * Redirect user after successful login.
	 *
	 * @param string $redirect_to URL to redirect to.
	 *
	 * @return string
	 */

	public static function get_landing_page_from_user_id($user_id){

		/*************** CORPORATE USER LOGIN PAGE ********************** new line added */
		$page_id = 0;

		if($user_id > 0) {
			$user_groups_id = learndash_get_users_group_ids( $user_id, true );
			if (isset($user_groups_id[0] )) {
				if ((int)$user_groups_id[0] > 0) {

					$connected = new \WP_Query( array(
						'connected_type' => 'group_to_page',
						'connected_items' => $user_groups_id,
						'nopaging' => true,
					) );


					if ( $connected->have_posts()) {
						if (isset($connected->posts[0]) && isset( $connected->posts[0]->ID)) {
							$page_id = $connected->posts[0]->ID;
							return get_permalink( $page_id );
						}
					}


					/*
					$my_query = new \WP_Query( array('post_type' => 'groups'));
					\p2p_type( 'group_to_page' )->each_connected( $my_query, array(), 'page' );
					if ( $my_query->have_posts()) {
						if (isset($my_query->posts[0]) && isset( $my_query->posts[0]->ID)) {
							$page_id = $my_query->posts[0]->ID;
							return get_permalink( $page_id );
						}
					}
					*/

				}
			}
		}

	}

	public static function lwws_login_redirect($redirect_to, $userID){
		$landing_page = self::get_landing_page_from_user_id($userID);
		if( isset($landing_page)) return $landing_page;
		else return $redirect_to;
	}

	/**
	 * Redirect user after successful login.
	 *
	 * @param string $redirect_to URL to redirect to.
	 *
	 * @return string
	 */
	public static function login_redirect( $redirect_to ) {

		$login_redirect = false;

		$settings = get_option( 'LoginRedirect', Array() );

		foreach ( $settings as $setting ) {

			if ( 'login_redirect' === $setting['name'] ) {
				$login_redirect = $setting['value'];
			}
		}

		//is there a user to check?
		global $user;

		if ( isset( $user->roles ) && is_array( $user->roles ) ) {
			//check for admins
			if ( in_array( 'administrator', $user->roles ) ) {
				// redirect them to the default place
				return $redirect_to;
			}

			//Check for corporate user
			$landing_page = self::get_landing_page_from_user_id($user->ID);
			if( isset($landing_page)) return $landing_page;


			if ( ! $login_redirect || '' === $login_redirect ) {
				// if redirect is not set than send them home
				return home_url();
			} else {
				return $login_redirect;
			}
		} else {
			return $redirect_to;
		}
	}


	/**
	 * Redirect from wp-login.php to custom login page if user logged out
	 */
	public static function logout_redirect() {

		$login_redirect = false;

		$settings = get_option( 'LoginRedirect', Array() );

		foreach ( $settings as $setting ) {

			if ( 'logout_redirect' === $setting['name'] ) {
				$login_redirect = $setting['value'];
			}
		}

		if ( ! $login_redirect || '' === $login_redirect ) {
			// if redirect is not set than do nothing for now
		} else {
			wp_safe_redirect( $login_redirect );
			exit;
		}


	}


}
