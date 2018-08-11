<?php
/**
 * Template for displaying course review.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/addons/course-review/course-review.php.
 *
 * @author ThimPress
 * @package LearnPress/Course-Review/Templates
 * @version 3.0.1
 */

// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

$course_id     = get_the_ID();
$paged = ! empty( $_REQUEST['paged'] ) ? intval( $_REQUEST['paged'] ) : 1;
$course_review = learn_press_get_course_review( $course_id, $paged );//echo'<pre>';print_r($course_review);die;
if ( $course_review['total'] ) {
	$reviews = $course_review['reviews']; ?>
    <div id="course-reviews">
        <h3 class="course-review-head"><?php _e( 'Reviews', 'learnpress-course-review' ); ?></h3>
        <ul class="course-reviews-list">
			<?php foreach ( $reviews as $review ) { ?>
				<?php learn_press_course_review_template( 'loop-review.php', array( 'review' => $review ) ); ?>
			<?php } ?>

			<?php if ( empty( $course_review['finish'] ) ) { ?>
                <li class="loading"><?php _e( 'Loading...', 'learnpress-course-review' ); ?></li>
			<?php } ?>

			<?php //_e( 'No review to load', 'learnpress-course-review' ); ?>
        </ul>
		<?php if ( empty( $course_review['finish'] ) ) { ?>
            <button class="button course-review-load-more" id="course-review-load-more"
                    data-paged="<?php echo $course_review['paged']; ?>"><?php _e( 'Load More', 'learnpress-course-review' ); ?></button>
		<?php } ?>
    </div>
<?php }