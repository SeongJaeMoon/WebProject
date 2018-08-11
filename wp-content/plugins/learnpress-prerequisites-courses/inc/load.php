<?php
/**
 * Plugin load class.
 *
 * @author   ThimPress
 * @package  LearnPress/Prerequisites-Courses/Classes
 * @version  3.0.0
 */

// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'LP_Addon_Prerequisites_Courses' ) ) {
	/**
	 * Class LP_Addon_Prerequisites_Courses
	 */
	class LP_Addon_Prerequisites_Courses extends LP_Addon {

		/**
		 * @var string
		 */
		public $version = LP_ADDON_PREREQUISITES_COURSES_VER;

		/**
		 * @var string
		 */
		public $require_version = LP_ADDON_PREREQUISITES_COURSES_REQUIRE_VER;

		/**
		 * LP_Addon_Prerequisites_Courses constructor.
		 */
		public function __construct() {
			parent::__construct();
		}

		/**
		 * Define Learnpress Prerequisites Courses constants.
		 *
		 * @since 3.0.0
		 */
		protected function _define_constants() {
			define( 'LP_PREREQUISITES_COURSES_PATH', dirname( LP_ADDON_PREREQUISITES_COURSES_FILE ) );
		}

		/**
		 * Include required core files used in admin and on the frontend.
		 *
		 * @since 3.0.0
		 */
		protected function _includes() {
			// code
		}

		/**
		 * Hook into actions and filters.
		 */
		protected function _init_hooks() {
			// add course meta box
			add_filter( 'learn_press_course_settings_meta_box_args', array( $this, 'admin_meta_box' ), 11 );
			// filter condition enroll, purchase course
			add_filter( 'learn-press/can-enroll-course', array( $this, 'can_enroll' ), 99, 3 );
			add_filter( 'learn_press_user_can_purchase_course', array(
				$this,
				'can_purchase_course'
			), 99, 3 );
			// show notice required pass prerequisites courses
			add_action( 'learn-press/content-landing-summary', array( $this, 'enroll_notice' ), 34 );
		}

		/**
		 * Add prerequisites courses in course meta box.
		 *
		 * @since 3.0.0
		 *
		 * @param $meta_boxes
		 *
		 * @return mixed
		 */
		public function admin_meta_box( $meta_boxes ) {
			$prerequisite = array(
				array(
					'name' => __( 'Allow Purchase', 'learnpress-prerequisites-courses' ),
					'id'   => "_lp_prerequisite_allow_purchase",
					'type' => 'yes_no',
					'desc' => __( 'Allow purchase course without finish prerequisites.', 'learnpress-prerequisites-courses' ),
					'std'  => 'no'
				),
				array(
					'name'     => __( 'Prerequisites Courses', 'learnpress-prerequisites-courses' ),
					'id'       => "_lp_course_prerequisite",
					'type'     => 'select_advanced',
					'multiple' => true,

					'desc'        => __( 'Courses you have to finish before you can enroll to this course.', 'learnpress-prerequisites-courses' ),
					'placeholder' => __( 'Select courses', 'learnpress-prerequisites-courses' ),
					'std'         => '',
					'options'     => array()
				)
			);

			global $wpdb;
			$post_id = ! empty( $_REQUEST['post'] ) ? $_REQUEST['post'] : 0;
			if ( $post_id ) {
				$post_author = get_post_field( 'post_author', $post_id );
			} else {
				$post_author = get_current_user_id();
			}
			$current_user_id = get_current_user_id();
			$post_authors    = array( $post_author );

			if ( $current_user_id != $post_author ) {
				$post_authors[] = $current_user_id;
			}
			settype( $post_id, 'array' );
			$post_ids = join( ', ', $post_id );
			// admin select all publish courses
			if ( is_super_admin() ) {
				$query = $wpdb->prepare( "
						SELECT ID, post_title FROM {$wpdb->posts}
						WHERE post_type = %s AND post_status = %s
						AND ID NOT IN(" . $post_ids . ")
						AND ID NOT IN( SELECT `post_id`FROM {$wpdb->postmeta} WHERE `meta_key`='_lp_course_prerequisite' and `meta_value` IN ({$post_ids}))",
					'lp_course', 'publish' );
			} else {
				// other author select all own publish courses
				$query = $wpdb->prepare( "
						SELECT ID, post_title FROM {$wpdb->posts}
						WHERE post_type = %s AND post_author in(" . implode( ',', $post_authors ) . ") AND post_status = %s
						AND ID NOT IN(" . $post_ids . ") AND ID NOT IN( 
						SELECT `post_id` FROM {$wpdb->postmeta} WHERE `meta_key`='_lp_course_prerequisite' and `meta_value` IN ({$post_ids}))",
					'lp_course', 'publish' );
			}
			if ( $options = $wpdb->get_results( $query ) ) {
				foreach ( $options as $option ) {
					// option for select courses
					$prerequisite[1]['options'][ $option->ID ] = $option->post_title;
				}
			} else {
				$prerequisite[1]['desc'] = __( 'There is no course to select.', 'learnpress-prerequisites-courses' );
				unset( $prerequisite[0] );
			}

			foreach ( $prerequisite as $field ) {
				// add prerequisites option on top of admin settings course
				array_unshift( $meta_boxes['fields'], $field );
			}

			return $meta_boxes;
		}

		/**
		 * Filer user can enroll course condition.
		 *
		 * @since 3.0.0
		 *
		 * @param $can_enroll
		 * @param $course_id
		 * @param $user
		 *
		 * @return bool
		 */
		public function can_enroll( $can_enroll, $course_id, $user ) {
			if ( ! $can_enroll ) {
				return false;
			}
			// get prerequisites of course
			$prerequisites = $this->get_prerequisite_courses( $course_id );
			if ( $prerequisites ) {
				foreach ( $prerequisites as $course ) {
					if ( ! $this->has_passed_course( $course ) ) {
						return false;
					}
				}
			}

			return $can_enroll;
		}

		/**
		 * Filer user can purchase course condition.
		 *
		 * @param $purchasable
		 * @param $user
		 * @param $course_id
		 *
		 * @return bool
		 */
		public function can_purchase_course( $purchasable, $user, $course_id ) {

			if ( ! $purchasable ) {
				return false;
			}
			// get prerequisites of course
			$prerequisites = $this->get_prerequisite_courses( $course_id );
			if ( $prerequisites ) {
				// allow purchase
				$allow_purchase = get_post_meta( $course_id, '_lp_prerequisite_allow_purchase', true );
				if ( $allow_purchase && $allow_purchase == 'yes' ) {
					return true;
				}
				// check pass condition
				foreach ( $prerequisites as $course ) {
					if ( ! $this->has_passed_course( $course ) ) {
						return false;
					}
				}
			}

			return $purchasable;
		}

		/**
		 * Check user has passed course condition.
		 *
		 * @since 3.0.0
		 *
		 * @param $course_id
		 * @param null $user_id
		 *
		 * @return mixed
		 */
		public function has_passed_course( $course_id, $user_id = null ) {
			if ( ! $user_id ) {
				$user_id = learn_press_get_current_user_id();
			}
			$user = learn_press_get_user( $user_id );

			return $user->has_passed_course( $course_id );
		}

		/**
		 * Get prerequisites of course.
		 *
		 * @param $course_id
		 *
		 * @return array|bool
		 */
		public function get_prerequisite_courses( $course_id ) {
			if ( ! $course_id ) {
				$course_id = learn_press_get_course_id();
			}

			return get_post_meta( $course_id, '_lp_course_prerequisite' );
		}

		/**
		 * Show notice required pass prerequisites courses.
		 *
		 * @since 3.0.0
		 */
		public function enroll_notice() {
			global $post;
			// course
			$course = learn_press_get_course( $post->ID );

			if ( $course->get_external_link() ) {
				return;
			}

			// get prerequisites of course
			$prerequisites = $this->get_prerequisite_courses( $post->ID );

			if ( ! $prerequisites ) {
				return;
			}

			$required_courses = array();

			foreach ( $prerequisites as $course_id ) {
				if ( ! $this->has_passed_course( $course_id ) ) {
					$required_courses[] = $course_id;
				}
			}

			if ( ! $required_courses ) {
				return;
			}

			$notice = __( 'NOTE: You have to pass these courses before you can enroll this course.', 'learnpress-prerequisites-courses' );

			$list_courses = array();
			foreach ( $required_courses as $course_id ) {
				$list_courses[] = '<a href="' . get_permalink( $course_id ) . '">' . get_the_title( $course_id ) . '</a>';
			}
			if ( $list_courses ) {
				$message = sprintf( '<ul style="margin: 0 0 0 20px;"><li>%s</li></ul>', join( '</li><li>', $list_courses ) );
				$notice  .= $message;
			}
			learn_press_display_message( $notice, 'error' );
		}
	}
}

add_action( 'plugins_loaded', array( 'LP_Addon_Prerequisites_Courses', 'instance' ) );
