<?php
/**
 * Template for displaying BuddyPress profile quizzes page.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/addons/buddypress/profile/quizzes.php.
 *
 * @author   ThimPress
 * @package  LearnPress/BuddyPress/Templates
 * @version  3.0.1
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
$query   = $profile->query_quizzes( array( 'status' => '' ) );
?>

<?php if ( $query['items'] ) { ?>
    <table class="lp-list-table profile-list-quizzes profile-list-table">
        <thead>
        <tr>
            <th class="column-quiz"><?php _e( 'Quiz', 'learnpress-buddypress' ); ?></th>
            <th class="column-date"><?php _e( 'Date', 'learnpress-buddypress' ); ?></th>
            <th class="column-status"><?php _e( 'Progress', 'learnpress-buddypress' ); ?></th>
            <th class="column-time-interval"><?php _e( 'Interval', 'learnpress-buddypress' ); ?></th>
        </tr>
        </thead>
        <tbody>
		<?php foreach ( $query['items'] as $user_quiz ) { ?>
			<?php
			/**
			 * @var $user_quiz LP_User_Item_Quiz
			 */
			$quiz = learn_press_get_quiz( $user_quiz->get_id() ); ?>
            <tr>
                <td class="column-quiz">
                    <a href="<?php echo $quiz->get_permalink(); ?>">
						<?php echo $quiz->get_title( 'display' ); ?>
                    </a>
                </td>
                <td class="column-date"><?php echo $user_quiz->get_start_time( 'd M Y' ); ?></td>
                <td class="column-status">
                    <span class="result-percent"><?php echo $user_quiz->get_percent_result(); ?></span>
                    <span class="lp-label label-<?php echo esc_attr( $user_quiz->get_results( 'status' ) ); ?>">
                        <?php echo $user_quiz->get_status_label(); ?>
                    </span>
                </td>
                <td class="column-time-interval">
					<?php echo( $user_quiz->get_time_interval( 'display' ) ); ?>
                </td>
            </tr>
			<?php continue; ?>
            <tr>
                <td colspan="4"></td>
            </tr>
		<?php } ?>
        </tbody>
        <tfoot>
        <tr class="list-table-nav">
            <td colspan="2" class="nav-text"><?php echo $query->get_offset_text(); ?></td>
            <td colspan="2" class="nav-pages"><?php $query->get_nav_numbers( true ); ?></td>
        </tr>
        </tfoot>
    </table>

<?php } else {
	learn_press_display_message( __( 'No quizzes!', 'learnpress-buddypress' ) );
}

