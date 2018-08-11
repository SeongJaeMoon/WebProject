<?php
/**
 * Template for displaying shortcode course review.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/addons/course-review/shortcode-course-review.php.
 *
 * @author ThimPress
 * @package LearnPress/Course-Review/Templates
 * version  3.0.1
 */

// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

$course_id = $args['course_id'];
if ( $course_review['total'] ) {
	$course_rate = learn_press_get_course_rate( $course_id, false );
	$reviews     = $course_review['reviews'];
	?>
    <div id="course-reviews-shortcode">
        <h3 class="course-review-head"><?php _e( 'Reviews', 'learnpress-course-review' ); ?></h3>
        <p class="course-average-rate"><?php printf( __( 'Average rate: <span>%.1f</span>', 'learnpress-course-review' ), $course_rate ); ?></p>
        <ul class="course-reviews-list-shortcode">
			<?php foreach ( $reviews as $review ) { ?>
				<?php learn_press_course_review_template( 'loop-review.php', array( 'review' => $review ) ); ?>
			<?php } ?>
        </ul>
    </div>
	<?php
} else {
	_e( 'No review to load', 'learnpress-course-review' );
}