<?php
/**
 * Created by PhpStorm.
 * User: Fazlur R Khan
 * Url: www.samadhan.com.au
 * Date: 11-08-17
 * Time: 9:03 AM
 */



// Creating the widget
class smdn_toolbar_class extends WP_Widget {

    function __construct() {
        parent::__construct(
                // Base ID of your widget
                'samadhan_corporate_toolbar_widget',
                // Widget name will appear in UI
                __('Corporate User Toolbar', 'samadhan_widget_domain'),
                // Widget description
                array( 'description' => __( 'A toolbar titled "Corporate user toolbar" to appear where you want', 'samadhan_widget_domain' ), )
        );
    }

// Creating widget front-end

    public function widget( $args, $instance ) {
        if(is_user_logged_in()) {


 	        $current_user = wp_get_current_user();
	        $userid = $current_user->ID;

		$is_admin = current_user_can('administrator');
                $is_group_admin = learndash_is_group_leader_user($userid);
 		


            $account_url = get_site_url(null,"my-account");
            $courses_url = get_site_url(null,"my-courses-corporate");
            $course_progress = get_site_url(null,"course-progress");
            $submit_ticket_url = get_site_url(null,"submit-ticket");
            $my_tickets_url = get_site_url(null,"my-tickets");

            $admin_button_html = '';

            if( $is_group_admin || $is_admin ) {
                $admin_url = get_site_url(null,"wp-admin");
                $group_management_url = get_site_url(null,"group-registration");

                $admin_button_html = ' ' .
                    '<div class="post-entry post-entry-type-page">' . '<div class="entry-content-wrapper flex-row">'  .

                  
                    '<div>' .
                        '<a target="_blank" href="' . $admin_url . '" class="avia-link">' .
                        '<span class="avia_iconbox_title">Group Reports</span>' .
                        '</a>' .
                    '</div>' .
		  
                  
                    '<div>' .
                        '<a target="_blank" href="' . $group_management_url . '" class="avia-link">' .
                        '<span class="avia_iconbox_title">Group Management</span>' .
                        '</a>' .                       
                    '</div>' .
		  

                    '</div></div>' .
                    '<hr/>';
            }

            echo __( $admin_button_html );

            echo __(  '<div class="post-entry post-entry-type-page post-entry-16068">' . '<div class="entry-content-wrapper clearfix">' .
                         '<div class="flex_column av_one_fifth  flex_column_div av-zero-column-padding first  avia-builder-el-2  el_before_av_one_fifth  avia-builder-el-first  " style="border-radius:0px; ">' .
                            '<div class="avia-button-wrap avia-button-center  avia-builder-el-3  avia-builder-el-no-sibling ">' .
                               '<a href="' . $account_url . '" class="avia-button  avia-icon_select-no avia-color-light avia-size-large avia-position-center ">' .
                                    '<span class="avia_iconbox_title">My Account</span>' .
                               '</a>' .
                            '</div>' .
                         '</div>' .
                '<div class="flex_column av_one_fifth  flex_column_div av-zero-column-padding   avia-builder-el-4  el_after_av_one_fifth  el_before_av_one_fifth  " style="border-radius:0px; ">' .
                '<div class="avia-button-wrap avia-button-center  avia-builder-el-5  avia-builder-el-no-sibling ">' .
                            '<a href="' . $courses_url . '" class="avia-button  avia-icon_select-no avia-color-light avia-size-large avia-position-center ">' .
                '<span class="avia_iconbox_title">My Courses</span></a></div></div>' .

                '<div class="flex_column av_one_fifth  flex_column_div av-zero-column-padding   avia-builder-el-6  el_after_av_one_fifth  el_before_av_one_fifth  " style="border-radius:0px; ">' .
                '<div class="avia-button-wrap avia-button-center  avia-builder-el-7  avia-builder-el-no-sibling ">' .
                            '<a href="' . $course_progress . '" class="avia-button  avia-icon_select-no avia-color-light avia-size-large avia-position-center ">' .
                '<span class="avia_iconbox_title">Course Progress</span></a></div></div>' .

                '<div class="flex_column av_one_fifth  flex_column_div av-zero-column-padding   avia-builder-el-8  el_after_av_one_fifth  el_before_av_one_fifth  " style="border-radius:0px; ">' .
                '<div class="avia-button-wrap avia-button-center  avia-builder-el-9  avia-builder-el-no-sibling ">' .
                            '<a href="' . $submit_ticket_url . '" class="avia-button  avia-icon_select-no avia-color-light avia-size-large avia-position-center ">' .
                '<span class="avia_iconbox_title">Submit A Ticket</span></a></div></div>' .

                '<div class="flex_column av_one_fifth  flex_column_div av-zero-column-padding   avia-builder-el-10  el_after_av_one_fifth  avia-builder-el-last  " style="border-radius:0px; ">' .
                '<div class="avia-button-wrap avia-button-center  avia-builder-el-11  avia-builder-el-no-sibling ">' .
                            '<a href="' . $my_tickets_url . '" class="avia-button  avia-icon_select-no avia-color-light avia-size-large avia-position-center ">' .
                '<span class="avia_iconbox_title">My Tickets</span></a>' .
                '</div></div></div></div>');
        }

    }

// Widget Backend
    public function form( $instance ) { return '';}



// Updating widget replacing old instances with new
    public function update( $new_instance, $old_instance ) {
        return $new_instance;
    }
} // Class  ends here
