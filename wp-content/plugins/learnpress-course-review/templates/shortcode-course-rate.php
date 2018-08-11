<?php
/**
 * Template for displaying shortcode course rate.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/addons/course-review/shortcode-course-rate.php.
 *
 * @author ThimPress
 * @package LearnPress/Course-Review/Templates
 * version  3.0.1
 */

// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

$course_rate_res = $args['course_rate'];
$course_rate     = $course_rate_res['rated'];
$total           = $course_rate_res['total'];
?>

<div class="course-rate">
	<?php
	learn_press_course_review_template( 'rating-stars.php', array( 'rated' => $course_rate ) );
	$text = sprintf( _n( '%d rating', '%d ratings', $total, 'learnpress-course-review' ), $total );
	?>
    <p class="review-number">
		<?php do_action( 'learn_press_before_total_review_number' ); ?>
		<?php echo $text; ?>
		<?php do_action( 'learn_press_after_total_review_number' ); ?>
    </p>
    <div>
		<?php
		if ( isset( $course_rate_res['items'] ) && ! empty( $course_rate_res['items'] ) ):
			foreach ( $course_rate_res['items'] as $item ):
				?>
                <div class="course-rate">
                    <span><?php esc_html_e( $item['rated'] ); ?><?php _e( 'Star', 'learnpress-course-review' ); ?></span>
                    <span><?php esc_html_e( $item['total'] ); ?><?php _e( 'Rate', 'learnpress-course-review' ); ?></span>
                    <span><?php esc_html_e( $item['percent'] ); ?>%</span>
                </div>
			<?php
			endforeach;
		endif;
		?>
    </div>
</div>