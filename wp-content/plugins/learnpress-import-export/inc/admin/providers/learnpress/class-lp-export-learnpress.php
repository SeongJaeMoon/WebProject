<?php
/**
 * Learnpress Export Learnpress class.
 *
 * @author   ThimPress
 * @package  LearnPress/Import-Export/Classes
 * @version  3.0.0
 */

// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

/**
 * Class LP_Export_LearnPress_Provider
 */
if ( ! defined( 'LPIE_EXPORT_OPTIONS_SESSION_KEY' ) ) {
	define( 'LPIE_EXPORT_OPTIONS_SESSION_KEY', 'learn_press_export_options' );
}

if ( ! class_exists( 'LP_Export_LearnPress_Provider' ) ) {
	/**
	 * Class LP_Export_LearnPress_Provider.
	 */
	class LP_Export_LearnPress_Provider {

		/**
		 * @var null
		 */
		protected static $_instance = null;

		/**
		 * @var array
		 */
		protected $_exported_data = array();

		/**
		 * LP_Export_LearnPress_Provider constructor.
		 */
		public function __construct() {
			// No add hooks anymore
			if ( did_action( 'lpie_export_learnpress_init' ) ) {
				return;
			}

			$this->_exported_data = array_merge($this->_exported_data, $_REQUEST);

			add_action( 'lpie_export_view_step_1', array( $this, 'step_1' ) );
			add_action( 'lpie_export_view_step_2', array( $this, 'step_2' ) );
			add_action( 'lpie_export_view_step_3', array( $this, 'step_3' ) );

			add_action( 'lpie_do_export_item_meta', array( $this, 'do_export_item' ) );

			do_action( 'lpie_export_learnpress_init' );

			require_once LP_ADDON_IMPORT_EXPORT_INC . 'admin/providers/learnpress/lp-export-functions.php';
		}

		/**
		 * Export step 1 view.
		 */
		public function step_1() {
			lpie_admin_view( 'learnpress/export/step-1' );
		}

		/**
		 * Export step 2 view.
		 */
		public function step_2() {
			lpie_admin_view( 'learnpress/export/step-2' );
		}

		/**
		 * Export step 3 view.
		 */
		public function step_3() {
			$this->do_export();
			lpie_admin_view( 'learnpress/export/step-3' );
		}

		/**
		 * Export process.
		 */
		public function do_export() {
			global $wpdb, $post;

			$all_courses = $_REQUEST['courses'];
			$courses     = $wpdb->get_results(
				$wpdb->prepare( " SELECT * FROM {$wpdb->posts}
						WHERE ID IN(" . join( ",", $all_courses ) . ")
						AND post_type = %s",
					LP_COURSE_CPT )
			);

			ob_start();
			foreach ( $courses as $post ) {
				setup_postdata( $post );
				require LP_ADDON_IMPORT_EXPORT_INC . 'admin/providers/learnpress/xml/lp-export-item.php';

				// import course's items
				$course_items = $wpdb->get_results(
					$wpdb->prepare( "
						SELECT c.ID, p.* FROM {$wpdb->prefix}learnpress_sections s
						INNER JOIN {$wpdb->prefix}learnpress_section_items si ON si.section_id = s.section_id
						INNER JOIN {$wpdb->prefix}posts p ON si.item_id = p.ID
						INNER JOIN {$wpdb->prefix}posts c ON c.ID = s.section_course_id
						WHERE c.ID = %d", $post->ID )
				);
				if ( $course_items ) {
					foreach ( $course_items as $item ) {
						$this->_get_item( $item );
					}
				}
			}
			$items = ob_get_clean();

			$this->generate_exported_file( $items );
		}

		/**
		 * Get item.
		 *
		 * @param $item
		 */
		private function _get_item( $item ) {
			global $wpdb, $post;
			$old_post = $post;
			$post     = $item;
			setup_postdata( $post );

			require LP_ADDON_IMPORT_EXPORT_INC . 'admin/providers/learnpress/xml/lp-export-item.php';

			if ( $post->post_type == 'lp_quiz' ) {
				$query     = $wpdb->prepare( "
				SELECT q.*, qq.* FROM {$wpdb->posts} q
				INNER JOIN {$wpdb->prefix}learnpress_quiz_questions qq ON q.ID = qq.question_id
				WHERE quiz_id = %d
			", $post->ID );
				$questions = $wpdb->get_results( $query );
				if ( $questions ) {
					foreach ( $questions as $question ) {
						$this->_get_item( $question );
					}
				}
			}

			$post = $old_post;
			setup_postdata( $post );
		}

		/**
		 * @param WP_Post $item
		 */
		public function do_export_item( $item ) {
			global $post;
			$old_post = $post;
			$post     = $item;
			setup_postdata( $post );
			if ( $item->post_type == LP_COURSE_CPT ) {
				require LP_ADDON_IMPORT_EXPORT_INC . 'admin/providers/learnpress/xml/items/export-course.php';
			} elseif ( $item->post_type == LP_QUESTION_CPT ) {
				require LP_ADDON_IMPORT_EXPORT_INC . 'admin/providers/learnpress/xml/items/export-question.php';
			} elseif ( $item->post_type == LP_QUIZ_CPT ) {
				require LP_ADDON_IMPORT_EXPORT_INC . 'admin/providers/learnpress/xml/items/export-quiz.php';
			}
			$post = $old_post;
			setup_postdata( $post );
		}

		/**
		 * Get export file name.
		 *
		 * @param string $name
		 * @param string $type
		 *
		 * @return string
		 */
		public static function get_export_file_name( $name = '', $type = 'xml' ) {
			$file_name = ! empty( $name ) ? $name : 'export-courses-learnpress-' . date( 'Ymdhis' );
			$segs      = explode( '.', $file_name );
			$ext       = '';
			if ( sizeof( $segs ) > 1 ) {
				$ext = end( $segs );
			}
			if ( $ext != $type ) {
				$file_name .= ".{$type}";
			}

			return sanitize_file_name( $file_name );
		}

		/**
		 * Get export file name without extension.
		 *
		 * @param string $name
		 *
		 * @return string
		 */
		public static function get_export_file_name_without_extension( $name = '' ) {
			$name = self::get_export_file_name( $name );
			$segs = explode( '.', $name );
			array_pop( $segs );

			return join( '/', $segs );
		}

		public function generate_exported_file( $items ) {
			$export_options = $this->_exported_data;
			ob_start();
			require_once LP_ADDON_IMPORT_EXPORT_INC . 'admin/providers/learnpress/xml/lp-export.php';
			$content      = ob_get_clean();
			$xml_filename = $this->get_export_file_name( $_REQUEST['learn-press-export-file-name'] );
			if ( $_REQUEST['save_export'] ) {
				$xml_filename = 'learnpress/export/' . $xml_filename;
				lpie_put_contents( $xml_filename, $content );
			}
			if ( $_REQUEST['download_export'] ) {
				$download_filename = $this->get_download_export_file_name( $_REQUEST['learn-press-export-file-name'] );
				$download_filename = 'learnpress/tmp/' . $download_filename;
				lpie_put_contents( $download_filename, $content );
				$_REQUEST['download_url']   = $download_filename;
				$_REQUEST['download_alias'] = basename( $xml_filename );
			}
		}

		public function get_download_export_file_name( $type = 'xml' ) {
			$file_name = md5( date( 'Ymdhis' ) );
			$segs      = explode( '.', $file_name );
			$ext       = '';
			if ( sizeof( $segs ) > 1 ) {
				$ext = end( $segs );
			}
			if ( $ext != $type ) {
				$file_name .= ".{$type}";
			}

			return sanitize_file_name( $file_name );
		}

		/**
		 * Get export courses, only course of current user.
		 *
		 * @return mixed
		 */
		public static function get_courses() {
			global $wpdb;
			$user         = learn_press_get_current_user();
			$roles        = $user->get_data( 'roles' );
			$teacher_role = 'lp_teacher';
			$post_type    = 'lp_course';

			$query = $wpdb->prepare( "SELECT * FROM {$wpdb->posts} WHERE post_type = %s", $post_type );

			$is_teacher = false;
			if ( in_array( 'administrator', $roles ) || ( $is_teacher = in_array( $teacher_role, $roles ) ) ) {
				if ( $is_teacher ) {
					$query .= $wpdb->prepare( " AND post_author = %d", $user->ID );
				}
			}

			return $wpdb->get_results( $query );
		}

		/**
		 * Instance.
		 *
		 * @return LP_Export_LearnPress_Provider|null
		 */
		public static function instance() {
			if ( ! self::$_instance ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}
	}
}

return LP_Export_LearnPress_Provider::instance();