<?php
/**
 * Template for displaying BuddyPress profile courses page.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/addons/buddypress/profile/courses.php.
 *
 * @author   ThimPress
 * @package  LearnPress/BuddyPress/Templates
 * @version  3.0.0
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();
?>

<?php
$limit     = apply_filters( 'learn_press_profile_tab_courses_all_limit', LP()->settings->get( 'profile_courses_limit', 10 ) );
$num_pages = learn_press_get_num_pages( $user->_get_found_rows(), $limit );

$profile = learn_press_get_profile();

$query   = isset( $_REQUEST['filter'] ) ? $_REQUEST['filter'] : 'own';
$filters = array(
	'own'       => __( 'Own', 'learnpress-buddypress' ),
	'purchased' => __( 'Purchased', 'learnpress-buddypress' )
); ?>

<ul class="leanpress-buddpress-list-filters">
	<?php foreach ( $filters as $key => $filter ) { ?>
        <li>
            <a href="<?php echo add_query_arg( array( 'filter' => $key ) ); ?>"
               class="<?php echo ( $query == $key ) ? 'active' : ''; ?>"><?php echo $filter; ?></a>
        </li>
	<?php } ?>
</ul>

<?php $courses = $profile->query_courses( $query, array( 'status' => '' ) ); ?>

<?php
if ( $query == 'own' ) {
	if ( ! $courses['total'] ) {
		learn_press_display_message( __( 'You haven\'t got any courses yet!', 'learnpress-buddypress' ) );
	} else { ?>
        <ul class="learn-press-courses profile-courses-list">
			<?php
			global $post;
			foreach ( $courses['items'] as $item ) {
				$course = learn_press_get_course( $item );
				$post   = get_post( $item );
				setup_postdata( $post );
				learn_press_get_template( 'content-course.php' );
			}
			wp_reset_postdata();
			?>
        </ul>

		<?php learn_press_buddypress_paging_nav( array( 'num_pages' => $num_pages ) ); ?>
	<?php }
} else if ( $query == 'purchased' ) {
	if ( $courses['items'] ) {
		?>
        <table class="lp-list-table profile-list-courses profile-list-table">
            <thead>
            <tr>
                <th class="column-course"><?php _e( 'Course', 'learnpress' ); ?></th>
                <th class="column-date"><?php _e( 'Date', 'learnpress' ); ?></th>
                <th class="column-passing-grade"><?php _e( 'Passing Grade', 'learnpress' ); ?></th>
                <th class="column-status"><?php _e( 'Progress', 'learnpress' ); ?></th>
            </tr>
            </thead>
            <tbody>
			<?php foreach ( $courses['items'] as $user_course ) { ?>
				<?php
				/**
				 * @var $user_course LP_User_Item_Course
				 */
				$course = learn_press_get_course( $user_course->get_id() ); ?>
                <tr>
                    <td class="column-course">
                        <a href="<?php echo $course->get_permalink(); ?>">
							<?php echo $course->get_title(); ?>
                        </a>
                    </td>
                    <td class="column-date"><?php echo $user_course->get_start_time( 'd M Y' ); ?></td>
                    <td class="column-passing-grade"><?php echo $course->get_passing_condition( true ); ?></td>
                    <td class="column-status">
						<?php if ( $user_course->get_results( 'status' ) !== 'purchased' ) { ?>
                            <span class="result-percent"><?php echo $user_course->get_percent_result(); ?></span>
                            <span class="lp-label label-<?php echo esc_attr( $user_course->get_results( 'status' ) ); ?>">
                                <?php echo $user_course->get_status_label( $user_course->get_results( 'status' ) ); ?>
                            </span>
						<?php } else { ?>
                            <span class="lp-label label-<?php echo esc_attr( $user_course->get_results( 'status' ) ); ?>">
                                <?php echo $user_course->get_status_label( $user_course->get_results( 'status' ) ); ?>
                            </span>
						<?php } ?>
                    </td>
                </tr>
			<?php } ?>
            </tbody>
            <tfoot>
            <tr class="list-table-nav">
                <td colspan="2" class="nav-text">
					<?php echo $courses->get_offset_text(); ?>
                </td>
                <td colspan="2" class="nav-pages">
					<?php $courses->get_nav_numbers( true ); ?>
                </td>
            </tr>
            </tfoot>
        </table>
		<?php
	} else {
		learn_press_display_message( __( 'No courses!', 'learnpress-buddypress' ) );
	}
} ?>

