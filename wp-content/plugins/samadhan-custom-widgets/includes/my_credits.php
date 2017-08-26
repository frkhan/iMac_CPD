<?php
/**
 * Created by PhpStorm.
 * User: Fazlur R Khan
 * Url: www.samadhan.com.au
 * Date: 28-May-17
 * Time: 9:03 AM
 */



// Creating the widget
class smdn_mycredits_class extends WP_Widget {

    function __construct() {
        parent::__construct(
        // Base ID of your widget
            'samadhan_corporate_mycredit_widget',
            // Widget name will appear in UI
            __('Corporate User Credits', 'samadhan_widget_domain'),
            // Widget description
            array( 'description' => __( 'A widget titled “Corporate User Credits” to appear where you want', 'samadhan_widget_domain' ), )
        );
    }

// Creating widget front-end

    public function widget( $args, $instance ) {
        echo $args['before_widget'];
        
        if(is_user_logged_in()) {
            $html ='<div class="flex_column av_one_full  flex_column_div first  avia-builder-el-10  el_after_av_one_half  el_before_av_one_full  column-top-margin" style="border-width:1px; border-color:#efefef; border-style:solid; padding:30px; background-color:#ffffff; border-radius:10px; ">'
                  . '<section class="av_textblock_section" itemscope="itemscope" itemtype="https://schema.org/CreativeWork">'
                     . '<div class="avia_textblock " itemprop="text">'
                       . '<h2>My Credits</h2>'
                     . '</div>'
                   . '</section>'
                    . '<section class="av_textblock_section" itemscope="itemscope" itemtype="https://schema.org/CreativeWork">'
                      .  '<div class="avia_textblock " itemprop="text"><p>Your total number of earned credit is ' . do_shortcode('[uo_ceu_total]') . '</p>'
                      .  '</div>'
                    . '</section>'
                . '</div>';

            echo __($html);
        }
        else {
            echo __("<div>&nbsp;</div>");
        }

        echo $args['after_widget'];
    }

// Widget Backend
    public function form( $instance ) { return '';}



// Updating widget replacing old instances with new
    public function update( $new_instance, $old_instance ) {
        return $new_instance;
    }
} // Class  ends here




