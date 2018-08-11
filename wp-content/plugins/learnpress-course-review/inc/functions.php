<?php
/**
 * LearnPress Course Review Functions
 *
 * Define common functions for both front-end and back-end
 *
 * @author   ThimPress
 * @package  LearnPress/Course-Review/Functions
 * @version  3.0.1
 */

// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

/**
 * @param int $course_id
 * @param int $paged
 * @param int $per_page
 * @param boolean $force
 *
 * @return mixed
 */
function learn_press_get_course_review( $course_id, $paged = 1, $per_page = LP_ADDON_COURSE_REVIEW_PER_PAGE, $force = false ) {

	$key = 'course-' . md5( serialize( array( $course_id, $paged, $per_page ) ) );

	if ( false === ( $results = wp_cache_get( $key, 'lp-course-review' ) ) || $force ) {

		global $wpdb;
		$per_page = absint( apply_filters( 'learn_press_course_reviews_per_page', $per_page ) );
		$paged    = absint( $paged );

		if ( $per_page == 0 ) {
			$per_page = 9999999;
		}

		if ( $paged == 0 ) {
			$paged = 1;
		}

		$start    = ( $paged - 1 ) * $per_page;
		$start    = max( $start, 0 );
		$per_page = max( $per_page, 1 );
		$results  = array(
			'reviews'  => array(),
			'paged'    => $paged,
			'total'    => 0,
			'per_page' => $per_page
		);

		$query = $wpdb->prepare( "
	        SELECT SQL_CALC_FOUND_ROWS u.*, c.comment_ID as comment_id, cm1.meta_value as title, c.comment_content as content, cm2.meta_value as rate
	        FROM {$wpdb->posts} p
	        INNER JOIN {$wpdb->comments} c ON p.ID = c.comment_post_ID
	        INNER JOIN {$wpdb->users} u ON u.ID = c.user_id
	        INNER JOIN {$wpdb->commentmeta} cm1 ON cm1.comment_id = c.comment_ID AND cm1.meta_key = %s
	        INNER JOIN {$wpdb->commentmeta} cm2 ON cm2.comment_id = c.comment_ID AND cm2.meta_key = %s
	        WHERE p.ID = %d AND c.comment_type = %s AND c.comment_approved = %d
	        ORDER BY c.comment_date DESC
	        LIMIT %d, %d
	    ", '_lpr_review_title', '_lpr_rating', $course_id, 'review', 1, $start, $per_page );

		$course_review = $wpdb->get_results( $query );

		if ( $course_review ) {
			$ratings            = _learn_press_get_ratings( $course_id );
			$results['reviews'] = $course_review;
			$results['total']   = $ratings[ $course_id ]['total'];
			if ( $results['total'] <= $start + $per_page ) {
				$results['finish'] = true;
			}
		}

		wp_cache_set( $key, $results, 'lp-course-review' );
	}

	return $results;
}

function _learn_press_get_ratings( $course_id ) {

	static $course_rates = array();
	if ( ! is_array( $course_id ) ) {
		$ids = array( $course_id );
	} else {
		$ids = $course_id;
	}
	foreach ( $ids as $cid ) {
		if ( ! isset( $course_rates[ $cid ] ) ) {
			$course_rates[ $cid ] = leanr_press_get_ratings_result( $cid );
		}
	}

	return $course_rates;
}


/**
 * @param $course_id
 * @param $field
 *
 * @return mixed
 */
function learn_press_get_course_rate( $course_id, $field = 'rated' ) {
	$ratings = _learn_press_get_ratings( $course_id );
	$rate    = ( $field && array_key_exists( $field, $ratings[ $course_id ] ) ) ? $ratings[ $course_id ][ $field ] : $ratings[ $course_id ];

	return apply_filters( 'learn_press_get_course_rate', $rate );
}

function learn_press_get_course_rate_total( $course_id, $field = 'total' ) {
	/*global $wpdb;
	$query = $wpdb->prepare( "
        SELECT COUNT(*)
        FROM {$wpdb->posts} p
        INNER JOIN {$wpdb->comments} c ON p.ID = c.comment_post_ID
        INNER JOIN {$wpdb->users} u ON u.ID = c.user_id
        INNER JOIN {$wpdb->commentmeta} cm1 ON cm1.comment_id = c.comment_ID AND cm1.meta_key=%s
        INNER JOIN {$wpdb->commentmeta} cm2 ON cm2.comment_id = c.comment_ID AND cm2.meta_key=%s
        WHERE p.ID=%d AND c.comment_type=%s and c.comment_approved = %d
        ORDER BY c.comment_date DESC",
		'_lpr_review_title', '_lpr_rating', $course_id, 'review', 1
	);
	$total = $wpdb->get_var( $query );*/

	$ratings = _learn_press_get_ratings( $course_id );
	$total   = array_key_exists( $field, $ratings[ $course_id ] ) ? $ratings[ $course_id ][ $field ] : $ratings;

	return apply_filters( 'learn_press_get_course_rate_total', $total );
}

/**
 * @param $course_id
 * @param $user_id
 *
 * @return string
 */
function learn_press_get_user_review_title( $course_id, $user_id ) {
	$course_review = get_post_meta( $course_id, '_lpr_course_review', true );

	if ( $course_review && array_key_exists( $user_id, $course_review['review_title'] ) ) {
		return apply_filters( 'learn_press_get_user_review', $course_review['review_title'][ $user_id ] );
	}

	return false;
}

/**
 * Get the rating user has posted for a course.
 *
 * @param int $course_id
 * @param int $user_id
 *
 * @return mixed
 */
function learn_press_get_user_rate( $course_id = null, $user_id = null ) {
	if ( ! $user_id ) {
		$user_id = get_current_user_id();
	}
	if ( ! $course_id ) {
		$course_id = get_the_ID();
	}

	// Get in cache if it is already get
	if ( false === ( $comment = wp_cache_get( 'user-' . $user_id . '/' . $course_id, 'lp-user-rate' ) ) ) {
		global $wpdb;
		$query = $wpdb->prepare( "
	        SELECT *
	        FROM {$wpdb->posts} p
	        INNER JOIN {$wpdb->comments} c ON c.comment_post_ID = p.ID
	        WHERE c.comment_post_ID = %d 
	        AND c.user_id = %d 
	        AND c.comment_type = %s
	    ", $course_id, $user_id, 'review' );

		$comment = $wpdb->get_row( $query );

		if ( $comment ) {
			$comment->comment_title = get_comment_meta( $comment->comment_ID, '_lpr_review_title', true );
			$comment->rating        = get_comment_meta( $comment->comment_ID, '_lpr_rating', true );
		}

		wp_cache_set( 'user-' . $user_id . '/' . $course_id, $comment, 'lp-user-rate' );
	}

	return $comment;
}

/**
 * Add new review for a course
 *
 * @param array
 *
 * @return int
 */
function learn_press_add_course_review( $args = array() ) {
	$args        = wp_parse_args(
		$args,
		array(
			'title'     => '',
			'content'   => '',
			'rate'      => '',
			'user_id'   => 0,
			'course_id' => 0
		)
	);
	$user_id     = $args['user_id'];
	$course_id   = $args['course_id'];
	$user_review = learn_press_get_user_rate( $course_id, $user_id );
	$comment_id  = 0;
	if ( ! $user_review ) {
		$user       = get_user_by( 'id', $user_id );
		$comment_id = wp_new_comment(
			array(
				'comment_post_ID'      => $course_id,
				'comment_author'       => $user->display_name,
				'comment_author_email' => $user->user_email,
				'comment_author_url'   => '',
				'comment_content'      => $args['content'],
				'comment_parent'       => 0,
				'user_id'              => $user->ID,
				'comment_approved'     => 1,
				'comment_type'         => 'review' // let filter to not display it as comments
			)
		);
	}
	if ( $comment_id ) {
		add_comment_meta( $comment_id, '_lpr_rating', $args['rate'] );
		add_comment_meta( $comment_id, '_lpr_review_title', $args['title'] );
	}

	return $comment_id;
}

function learn_press_course_review_template( $name, $args = null ) {
	learn_press_get_template( $name, $args, learn_press_template_path() . '/addons/course-review/', LP_ADDON_COURSE_REVIEW_TMPL );
}

/*
 * If we are viewing archive course page, so load all ratings of courses
 * into cache to reduce queries and time rather than load separate course
 * in loop
 */
add_filter( 'the_posts', 'learn_press_init_courses_review' );
function learn_press_init_courses_review( $posts ) {
	if ( $posts ) {
		$pIds = array();
		foreach ( $posts as $p ) {
			$pIds[] = $p->ID;
		}
		_learn_press_get_ratings( $pIds );
	}

	return $posts;
}

/**
 * Get rating for a course
 *
 * @param int $course_id
 * @param bool $get_items
 *
 * @return array
 */
function leanr_press_get_ratings_result( $course_id = 0, $get_items = false ) {
	//return learn_press_get_ratings_result_bak($course_id);
	if ( false === ( $result = wp_cache_get( 'course-' . $course_id, 'lp-course-ratings' ) ) ) {
		global $wpdb;

		$query = $wpdb->prepare( "
				SELECT 
					cm.meta_value `rate`, COUNT(1) `count`
				FROM
					{$wpdb->comments} c
						INNER JOIN
					{$wpdb->commentmeta} cm ON c.comment_ID = cm.comment_id AND meta_key = %s
				WHERE
					c.comment_approved = 1
						AND c.comment_type = %s
						AND c.user_id > 0
						AND c.comment_post_ID = %d 
				GROUP BY `cm`.`meta_value`
			", '_lpr_rating', 'review', $course_id );
		$rows  = $wpdb->get_results( $query/*, OBJECT_K */ );

		$count = 0;
		$rate  = 0;
		$avg   = 0;
		$items = array();

		for ( $i = 5; $i > 0; $i -- ) {
			$items[ $i ] = array(
				'rated'   => $i,
				'total'   => 0,
				'percent' => 0
			);
		}

		if ( $rows ) {

			$count       = wp_list_pluck( $rows, 'count' );
			$count       = array_sum( $count );
			$round       = array();
			$one_hundred = 0;

			foreach ( $rows as $row ) {
				$rate                += $row->rate * $row->count;
				$percent             = $row->count / $count * 100;
				$items[ $row->rate ] = array(
					'rated'         => $row->rate,
					'total'         => $row->count,
					'percent'       => floor( $percent ),
					'percent_float' => $percent
				);
				$one_hundred         += $items[ $row->rate ]['percent'];
				$round[ $row->rate ] = $percent - floor( $percent );
			}

			if ( $one_hundred < 100 ) {
				arsort( $round );
				foreach ( $round as $key => $value ) {
					$percent                  = $items[ $key ]['percent'];
					$items[ $key ]['percent'] = ceil( $items[ $key ]['percent_float'] );

					if ( $percent < $items[ $key ]['percent'] ) {
						$one_hundred ++;
						if ( $one_hundred == 100 ) {
							break;
						}
					}
				}
			}


			$avg = $rate / $count;
		}

		$result = array(
			'course_id' => $course_id,
			'total'     => $count,
			'rated'     => $avg,
			'items'     => $items
		);

		wp_cache_set( 'course-' . $course_id, $result, 'lp-course-ratings' );
	}

	return $result;
}

function learn_press_get_ratings_result_bak( $course_id = 0, $get_items = false ) {

	if ( false === ( $result = wp_cache_get( 'course-' . $course_id, 'lp-course-ratings' ) ) ) {
		LP_Debug::timeStart( 'xxxxx' );
		global $wpdb;
		$query = $wpdb->prepare( "
			SELECT 
				COUNT(*) `count` ,AVG(cm.meta_value) `avg`
			FROM
				{$wpdb->comments} c
					INNER JOIN
				{$wpdb->commentmeta} cm ON c.comment_ID = cm.comment_id AND meta_key = %s
			WHERE
				c.comment_approved = 1
					AND c.comment_type = %s
					AND c.user_id > 0
					AND c.comment_post_ID = %d
		", '_lpr_rating', 'review', $course_id );
		$row   = $wpdb->get_row( $query );

		$count = 0;
		$avg   = 0;

		if ( $row ) {
			$count = $row->count;
			$avg   = $row->avg;
		}

		$rows = array();
		if ( $count != 0 ):

			$query = $wpdb->prepare( "
				SELECT 
					cm.meta_value `rate`, COUNT(*) `count`
				FROM
					{$wpdb->comments} c
						INNER JOIN
					{$wpdb->commentmeta} cm ON c.comment_ID = cm.comment_id AND meta_key = %s
				WHERE
					c.comment_approved = 1
						AND c.comment_type = %s
						AND c.user_id > 0
						AND c.comment_post_ID = %d 
				GROUP BY `cm`.`meta_value`
				ORDER BY `cm`.`meta_value` DESC
			", '_lpr_rating', 'review', $course_id );
			$rows  = $wpdb->get_results( $query, OBJECT_K );

		endif;

		$items = array();
		for ( $i = 5; $i > 0; $i -- ) {
			if ( isset( $rows[ $i ] ) ) {
				$items[] = array(
					'rated'   => $rows[ $i ]->rate,
					'total'   => $rows[ $i ]->count,
					'percent' => $rows[ $i ]->count / $count * 100
				);
			} else {
				$items[] = array(
					'rated'   => $i,
					'total'   => 0,
					'percent' => 0
				);
			}
		}
		$result = array(
			'course_id' => $course_id,
			'total'     => $count,
			'rated'     => $avg,
			'items'     => $items
		);
		LP_Debug::timeEnd( 'xxxxx' );

		learn_press_debug( $result );

		wp_cache_set( 'course-' . $course_id, $result, 'lp-course-ratings' );
	}

	return $result;
}