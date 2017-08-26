<?php
/**
 * Created by PhpStorm.
 * User: Fazlur R Khan
 * Url: www.samadhan.com.au
 * Date: 28-May-17
 * Time: 9:03 AM
 */



// Creating the widget
class smdn_mycourse_progress_class extends WP_Widget {
    static $users_ceus = array();

    function __construct() {
        parent::__construct(
        // Base ID of your widget
            'samadhan_corporate_mycourse_progress_widget',
            // Widget name will appear in UI
            __('Corporate User Course Progress', 'samadhan_widget_domain'),
            // Widget description
            array( 'description' => __( 'A widget titled “Corporate User Course Progress” to appear where you want', 'samadhan_widget_domain' ), )
        );
    }

// Creating widget front-end

    public function widget( $args, $instance ) {
        echo $args['before_widget'];
        if(is_user_logged_in()) {
            $users_ceus =  $this->get_user_course_data();

                if ( $users_ceus ) { ?>

                    <table id="searchResults" class="display" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th><?php _e( 'Course', 'uncanny-ceu' ); ?></th>
                            <th><?php _e( 'Completion Dates', 'uncanny-ceu' ); ?></th>
                            <th><?php echo get_option( 'credit_designation_label_plural', __( 'CEU', 'uncanny-ceu' ) ); ?></th>
                            <th><?php _e( 'Total ', 'uncanny-ceu' );
                                echo get_option( 'credit_designation_label_plural', __( 'CEU', 'uncanny-ceu' ) ); ?></th>
                        </tr>
                        </thead>


                        <tbody>

                        <?php

                        foreach ($users_ceus as $user ) {
                            ?>
                            <tr>
                                <td><?php echo $user['ceu_title']; ?></td>
                                <td><?php echo date( 'M d, Y', $user['ceu_date'] ); ?></td>
                                <td><?php echo $user['ceu_earned']; ?></td>
                                <td><?php echo $user['total_ceus']; ?></td>
                            </tr>
                        <?php } ?>

                        </tbody>
                    </table>

                <?php } else { ?>
                    <h2 style="text-align: center"><?php _e( 'No course progress record found' ); ?></h2>
                <?php }
        }
        echo $args['after_widget'];
    }

// Widget Backend
    public function form( $instance ) { return '';}



// Updating widget replacing old instances with new
    public function update( $new_instance, $old_instance ) {
        return $new_instance;
    }


    /**
     * Collect user data
     */
    public function get_user_course_data() {

        global $wpdb;
        global $current_user;

            //var_dump($current_user);

            $ceu_completions = array();
            $user_meta = get_user_meta( $current_user->ID );

            //var_dump($user_meta);



            $total_ceus = 0;

            foreach ( $user_meta as $meta_key => $meta_value ) {



                if ( false !== strpos( $meta_key, 'ceu_' ) ) {

                    $key        = explode( '_', $meta_key );

                    //var_dump($key);

                    $collection = array( 'title', 'date', 'course', 'earned' );

                    if ( ! in_array( $key[1], $collection ) ) {
                        continue;
                    }

                    $unique_key = $key[2] . '_' . $key[3]; //unique identifier for ceu completion...  {timestamp}_{course ID}
                    $value_key  = $key[0] . '_' . $key[1]; // name of data stored... ceu_title  ceu_date  ceu_course  ceu_earned


                    if ( 'ceu_earned' === $value_key ) {
                        $total_ceus += (float) $meta_value[0];
                    }


                    if ( ! isset( $ceu_completions[ $unique_key ] ) ) {
                        $ceu_completions[ $unique_key ]               = array();
                        $ceu_completions[ $unique_key ]['total_ceus'] = 0;
                    }

                    $ceu_completions[ $unique_key ][ $value_key ] = $meta_value[0];

                    if ( 'ceu_earned' === $value_key ) {
                        $ceu_completions[ $unique_key ]['total_ceus'] += $total_ceus;
                    }
                }
            }

        //var_dump($ceu_completions);
      return $ceu_completions;

    }
} // Class  ends here



