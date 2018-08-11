<?php
/**
 * Template for displaying rating stars.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/addons/course-review/rating-stars.php.
 *
 * @author ThimPress
 * @package LearnPress/Course-Review/Templates
 * version  3.0.1
 */

// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;
//echo'<pre>alo ';print_r(sprintf(__( '%s out of 5 stars', 'learnpress-course-review'), $rated));die;

$percent = ( ! $rated ) ? 0 : min( 100, ( round( $rated * 2 ) / 2 ) * 20 );
$title   = sprintf( __( '%s out of 5 stars', 'learnpress-course-review' ), $rated );
?>
<div class="review-stars-rated" title="<?php echo esc_attr( $title ); ?>">
    <div class="review-stars empty"></div>
    <div class="review-stars filled" style="width:<?php echo $percent; ?>%;"></div>
</div>