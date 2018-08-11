<?php
/**
 * Learnpress Import Learnpress class.
 *
 * @author   ThimPress
 * @package  LearnPress/Import-Export/Classes
 * @version  3.0.0
 */

// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

// Load Importer API
require_once ABSPATH . 'wp-admin/includes/import.php';

if ( ! class_exists( 'WP_Importer' ) ) {
	$class_wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';
	if ( file_exists( $class_wp_importer ) ) {
		require $class_wp_importer;
	}
}

if ( ! class_exists( 'LP_Import_LearnPress_Provider' ) ) {
	/**
	 * Class LP_Import_LearnPress_Provider.
	 */
	class LP_Import_LearnPress_Provider {

		/**
		 * @var null
		 */
		protected static $_instance = null;

		/**
		 * @var array
		 */
		private $processed_posts = array();

		/**
		 * @var array
		 */
		private $processed_authors = array();

		/**
		 * @var array
		 */
		private $processed_terms = array();

		/**
		 * @var array
		 */
		private $processed_thumbnails = array();

		/**
		 * @var int
		 */
		private $posts_count = 0;

		/**
		 * @var int
		 */
		private $posts_imported = 0;

		/**
		 * @var array
		 */
		private $posts_duplication = array();

		/**
		 * LP_Import_LearnPress_Provider constructor.
		 */
		public function __construct() {
			// No add hooks anymore
			if ( did_action( 'lpie_import_learnpress_init' ) ) {
				return;
			}

			add_action( 'lpie_import_view_step_1', array( $this, 'step_1' ) );
			add_action( 'lpie_import_view_step_2', array( $this, 'step_2' ) );
			add_action( 'lpie_import_view_step_3', array( $this, 'step_3' ) );
			add_action( 'lpie_import_from_server', array( $this, 'import_form_server_view' ) );

			require_once LP_ADDON_IMPORT_EXPORT_INC . 'admin/providers/learnpress/lp-import-functions.php';

			do_action( 'lpie_import_learnpress_init' );
		}

		/**
		 * Import from server view.
		 *
		 * @param $file
		 */
		public function import_form_server_view( $file ) {
			?>
            <h2><strong><?php _e( 'Course(s) found on this file', 'learnpress-import-export' ); ?></strong>
                (<?php _e( str_replace( 'export/', '', $file ) ) ?>):</h2>
            <table class="wp-list-table widefat fixed striped">
				<?php
				$file_data = $this->parse( lpie_root_path() . '/learnpress/' . $file );
				$courses   = $file_data ['posts'];
				foreach ( $courses as $course ) {
					if ( $course['post_type'] == LP_COURSE_CPT ) {
						_e( '<tr><td>' . $course['post_title'] . '</td><tr>' );
					}
				}
				?>
            </table>
            <p>
                <a href="<?php echo wp_nonce_url( admin_url( 'admin.php?page=learnpress-import-export&tab=import&import-file=' . $file . '&step=3' ), 'learnpress-import-export-import', 'import-nonce' ); ?>"
                   class="button button-primary button-large"><?php _e( 'Confirm Import', 'learnpress-import-export' ); ?></a>
                <a href="<?php echo admin_url( 'admin.php?page=learnpress-import-export&tab=import' ); ?>"
                   class="button button-large"><?php _e( 'Cancel', 'learnpress-import-export' ); ?></a>
            </p>
			<?php
		}

		/**
		 * Import step 1 view.
		 */
		public function step_1() {
			lpie_admin_view( 'learnpress/import/step-1' );
		}

		/**
		 * Import step 2 view.
		 */
		public function step_2() {
			lpie_admin_view( 'learnpress/import/step-2' );
		}

		/**
		 * Import step 3 view.
		 */
		public function step_3() {
			$this->do_import();
			lpie_admin_view( 'learnpress/import/step-3' );
		}

		/**
		 * Import process.
		 */
		public function do_import() {
			$file_data   = $this->parse( lpie_root_path() . '/learnpress/' . $_REQUEST['import-file'] );
			$map_authors = learn_press_get_request( 'map_authors' );
			$new_authors = learn_press_get_request( 'new_authors' );

			if ( $authors = $file_data['authors'] ) {
				foreach ( $authors as $old_author ) {
					if ( ! empty( $map_authors[ $old_author['author_id'] ] ) /* and user exists */ ) {
						continue;
					}
					if ( ! empty( $new_authors[ $old_author['author_id'] ] ) /* and user exists */ ) {
						$user_data = array(
							'user_login' => $new_authors[ $old_author['author_id'] ],
							'user_pass'  => wp_generate_password(),
							'role'       => 'teacher'
						);
					} else {
						$user_data = array(
							'user_login'   => $old_author['author_login'],
							'user_pass'    => wp_generate_password(),
							'user_email'   => isset( $old_author['author_email'] ) ? $old_author['author_email'] : '',
							'display_name' => $old_author['author_display_name'],
							'first_name'   => isset( $old_author['author_first_name'] ) ? $old_author['author_first_name'] : '',
							'last_name'    => isset( $old_author['author_last_name'] ) ? $old_author['author_last_name'] : '',
							'role'         => 'teacher'
						);
					}
					$user_id = wp_insert_user( $user_data );

					if ( ! is_wp_error( $user_id ) ) {
						if ( ! empty( $old_author['author_id'] ) ) {
							$this->processed_authors[ $old_author['author_id'] ] = $user_id;
						}
					} else {
						if ( ! empty( $old_author['author_id'] ) ) {
							$this->processed_authors[ $old_author['author_id'] ] = (int) get_current_user_id();
						}
					}
				}
			}

			if ( $posts = $file_data['posts'] ) {
				// if have posts then import the categories and/or tags first
				// if success, store the new ID of category/tag into an array to map the old ID with new ID
				foreach ( $posts as $post ) {
					if ( ! empty( $post['terms'] ) ):
						foreach ( $post['terms'] as $term ) {
							if ( $term['domain'] == 'course_category' ) {
								$this->process_category( $term, $post );
							} elseif ( $term['domain'] == 'course_tag' ) {
								$this->process_tag( $term );
							}
						}
					endif;
				}

				// then import posts and map the new ID of category/tag/author for new post
				$this->posts_count    = count( $posts );
				$this->posts_imported = 0;

				// import all courses, lessons, quizzes, questions
				foreach ( $posts as $post ) {
					if ( $post['post_type'] == 'lp_course' ) {
						$args = array(
							'update_date'     => isset( $args['update_date'] ) ? true : false,
							'check_duplicate' => isset( $args['check_duplicate'] ) ? true : false,
						);
					} else {
						$args = array(
							'update_date' => isset( $args['update_date'] ) ? true : false,
						);
					}
					$post_id = $this->process_post( $post, $args );
					if ( ! $post_id ) {
						continue;
					}
				} //end foreach

				// Import section
				foreach ( $posts as $post ) {
					switch ( $post['post_type'] ) {
						case LP_COURSE_CPT:
							$this->process_sections( $post );
							break;
						case LP_QUIZ_CPT:
							$this->process_quiz_questions( $post );
							break;
						case LP_QUESTION_CPT:
							$this->process_question_answers( $post );
							break;
					}
				}
			}

			if ( ! empty( $_REQUEST['save_import'] ) ) {
				if ( ! file_exists( lpie_import_path() ) ) {
					mkdir( lpie_import_path(), 0777, true );
				}
				copy( lpie_root_path() . '/learnpress/' . $_REQUEST['import-file'], lpie_import_path() . '/' . basename( $_REQUEST['import-file'] ) );
			}

			$GLOBALS['is_imported_done'] = true;
		}

		/**
		 * Parse import file.
		 *
		 * @param $file
		 *
		 * @return array|WP_Error
		 */
		public function parse( $file ) {
			$parser = new LPR_Export_Import_Parser();

			return $parser->parse( $file );
		}

		/**
		 * Create new category for course and return the ID if success.
		 *
		 * @param $cat
		 * @param $post
		 *
		 * @return mixed
		 */
		public function process_category( $cat, $post ) {
			$term_id = term_exists( $cat['slug'], 'course_category' );

			if ( $term_id ) {
				if ( is_array( $term_id ) ) {
					$term_id = $term_id['term_id'];
				}
				if ( isset( $cat['id'] ) ) {
					$this->processed_terms[ intval( $cat['id'] ) ] = (int) $term_id;

					return $this->processed_terms[ intval( $cat['id'] ) ];
				}
			}

			$category_parent = empty( $cat['parent'] ) ? 0 : term_exists( $cat['parent'], 'course_category' );
			if ( $category_parent ) {
				if ( is_array( $category_parent ) ) {
					$category_parent = $category_parent['term_id'];
				}
			} else {
				if ( ! empty( $cat['parent'] ) && $cat['parent'] > 0 ) {
					foreach ( $post['terms'] as $t ) {
						if ( $t['id'] == $cat['parent'] ) {
							$category_parent = $this->process_category( $t, $post );
							break;
						}
					}
				}
			}
			$category_description = isset( $cat['description'] ) ? $cat['description'] : '';
			$category_arr         = array(
				'parent'      => $category_parent ? ( is_array( $category_parent ) ? $category_parent['term_id'] : $category_parent ) : 0,
				'description' => $category_description
			);

			$term = wp_insert_term( $cat['name'], 'course_category', $category_arr );

			if ( ! is_wp_error( $term ) ) {
				if ( isset( $cat['id'] ) ) {
					$this->processed_terms[ intval( $cat['id'] ) ] = (int) $term['term_id'];

					return $this->processed_terms[ intval( $cat['id'] ) ];
				}
			}

			return false;
		}

		/**
		 * Create new tag for course and return the ID if success.
		 *
		 * @param   $tag    array
		 * @param   $post   array
		 *
		 * @return  mixed
		 */
		public function process_tag( $tag, $post = array() ) {
			$term_id = term_exists( $tag['slug'], 'course_tag' );
			if ( $term_id ) {
				if ( is_array( $term_id ) ) {
					$term_id = $term_id['term_id'];
				}
				if ( isset( $tag['id'] ) ) {
					$this->processed_terms[ intval( $tag['id'] ) ] = (int) $term_id;
				}
			}

			$category_parent      = empty( $tag['parent'] ) ? 0 : term_exists( $tag['parent'] );
			$category_description = isset( $tag['description'] ) ? $tag['description'] : '';
			$catarr               = array(
				'parent'      => $category_parent ? ( is_array( $category_parent ) ? $category_parent['term_id'] : $category_parent ) : 0,
				'description' => $category_description
			);

			$term = wp_insert_term( $tag['name'], 'course_tag', $catarr );
			if ( ! is_wp_error( $term ) ) {
				if ( isset( $tag['id'] ) ) {
					$this->processed_terms[ intval( $tag['id'] ) ] = (int) $term['term_id'];
				}

			}

			return false;
		}

		/**
		 * Create new thumbnail for course.
		 *
		 * @param   array
		 * @param   int
		 *
		 * @return  void
		 */
		public function process_attachment( $attachment, $post_id ) {
			if ( ! isset( $this->processed_thumbnails[ $attachment['id'] ] ) ) {
				// if it is an url, try to read it
				if ( preg_match( '!^https?://!', $attachment['data'] ) ) {
					$data = @file_get_contents( $attachment['data'] );
				} else {
					$data = base64_decode( $attachment['data'] );
				}

				// create a temp file to upload
				if ( $data ) {
					$ext = '';
					switch ( $attachment['mime_type'] ) {
						case 'image/jpeg':
							$ext = 'jpg';
							break;
						case 'image/png':
							$ext = 'png';
							break;
					}
					if ( $ext ) {
						$wp_upload = wp_upload_dir();
						$tmp       = $wp_upload['path'] . '/' . $attachment['filename'] . '.' . $ext;
						@file_put_contents( $tmp, $data );
						if ( file_exists( $tmp ) ) {
							$filename    = basename( $tmp );
							$upload_file = wp_upload_bits( $filename, null, $data );
							if ( ! $upload_file['error'] ) {
								$wp_filetype    = wp_check_filetype( $filename, null );
								$new_attachment = array(
									'post_mime_type' => $wp_filetype['type'],
									'post_parent'    => $post_id,
									'post_title'     => preg_replace( '/\.[^.]+$/', '', $filename ),
									'post_content'   => '',
									'post_status'    => 'inherit'
								);
								$attachment_id  = wp_insert_attachment( $new_attachment, $upload_file['file'], $post_id );
								if ( ! is_wp_error( $attachment_id ) ) {
									require_once( ABSPATH . "wp-admin" . '/includes/image.php' );
									$attachment_data = wp_generate_attachment_metadata( $attachment_id, $upload_file['file'] );
									wp_update_attachment_metadata( $attachment_id, $attachment_data );

									$this->processed_thumbnails[ $attachment['id'] ] = $attachment_id;
								}
							}
						}
						// remove tmp file
						@unlink( $tmp );
					}
				}
			}

			// ensure the thumbnail is exists
			if ( ! empty( $this->processed_thumbnails[ $attachment['id'] ] ) ) {
				set_post_thumbnail( $post_id, $this->processed_thumbnails[ $attachment['id'] ] );
			}
		}

		/**
		 * Import post.
		 *
		 * @param       $post
		 * @param array $args
		 *
		 * @return int|WP_Error
		 */
		public function process_post( $post, $args = array() ) {
			$args             = wp_parse_args(
				$args,
				array(
					'check_duplicate' => false,
					'update_date'     => false
				)
			);
			$original_post_ID = $post['post_id'];
			$post_id          = 0;
			if ( $args['check_duplicate'] && ( $duplication_id = $this->_post_exists( array( 'post_name' => $post['post_name'] ) ) ) ) {
				$this->posts_duplication[] = $duplication_id;

				return $post_id;
			}

			if ( isset( $this->processed_posts[ $original_post_ID ] ) && ! empty( $original_post_ID ) ) {
				return $post_id;
			}

			if ( $post['status'] == 'auto-draft' ) {
				return $post_id;
			}

			if ( 'nav_menu_item' == $post['post_type'] ) {
				//$this->process_menu_item( $post );
				return $post_id;
			}
			$post_type_object = get_post_type_object( $post['post_type'] );
			$post_exists      = post_exists( $post['post_title'], '', $post['post_date'] );
			if ( $args['check_duplicate'] && $post_exists && get_post_type( $post_exists ) == $post['post_type'] ) {

			} else {

				// map the post author
				if ( isset( $this->processed_authors[ $post['post_author_id'] ] ) ) {
					$author = $this->processed_authors[ $post['post_author_id'] ];
				} else {
					$author = (int) get_current_user_id();
				}

				$postdata = array(
					'post_author'    => $author,
					'post_date'      => $post['post_date'],
					'post_date_gmt'  => $post['post_date_gmt'],
					'post_content'   => $post['post_content'],
					'post_excerpt'   => $post['post_excerpt'],
					'post_title'     => $post['post_title'],
					'post_status'    => $post['status'],
					'post_name'      => $post['post_name'],
					'comment_status' => $post['comment_status'],
					'ping_status'    => $post['ping_status'],
					'guid'           => $post['guid'],
					'post_parent'    => 0,
					'menu_order'     => $post['menu_order'],
					'post_type'      => $post['post_type'],
					'post_password'  => $post['post_password']
				);
				$post_id  = wp_insert_post( $postdata, true );
				if ( $post_id ) {
					$this->posts_imported ++;
				}
				if ( $post['is_sticky'] == 1 ) {
					stick_post( $post_id );
				}

				if ( ! empty( $post['attachment'] ) && $attachment = $post['attachment'] ) {
					$this->process_attachment( $attachment, $post_id );
				}
			} // end if

			$this->processed_posts[ intval( $post['post_id'] ) ] = (int) $post_id;

			// set tag or category for post
			if ( ! empty( $post['terms'] ) && $post_id ) {
				foreach ( $post['terms'] as $term ) {
					if ( $term['domain'] == 'course_category' ) {
						if ( isset( $this->processed_terms[ $term['id'] ] ) ) {
							wp_set_object_terms( $post_id, (int) $this->processed_terms[ $term['id'] ], 'course_category', true );
						}
					} elseif ( $term['domain'] == 'course_tag' ) {
						if ( isset( $this->processed_terms[ $term['id'] ] ) ) {
							wp_set_object_terms( $post_id, (int) $this->processed_terms[ $term['id'] ], 'course_tag', true );
						}
					}
				}
			}

			/**
			 * Import metas
			 */
			if ( ! empty( $post['postmeta'] ) && $post_id ) {
				foreach ( $post['postmeta'] as $meta ) {
					$key   = apply_filters( 'import_post_meta_key', $meta['key'], $post_id, $post );
					$value = false;

					if ( '_edit_last' == $key ) {
						if ( isset( $this->processed_authors[ intval( $meta['value'] ) ] ) ) {
							$value = $this->processed_authors[ intval( $meta['value'] ) ];
						} else {
							$key = false;
						}
					}

					if ( $key && ! $this->_is_old_meta( $key ) ) {
						// export gets meta straight from the DB so could have a serialized string
						if ( ! $value ) {
							$value = maybe_unserialize( $meta['value'] );
						}

						update_post_meta( $post_id, $key, $value );
						do_action( 'import_post_meta', $post_id, $key, $value );

					} // end if key
				} // end foreach meta
			}

			return $post_id;
		}

		/**
		 * Import course sections.
		 *
		 * @param $post
		 */
		public function process_sections( $post ) {
			global $wpdb;
			/**
			 * Import course section
			 */
			$old_post_id = $post['post_id'];
			$post_id     = ! empty( $this->processed_posts[ $old_post_id ] ) ? $this->processed_posts[ $old_post_id ] : 0;
			if ( $post_id && ! empty( $post['section'] ) ) {
				foreach ( $post['section'] as $section_order => $section ) {
					$inserted = $wpdb->insert(
						$wpdb->prefix . 'learnpress_sections',
						array(
							'section_name'        => $section['section_name'],
							'section_description' => $section['section_description'],
							'section_course_id'   => $post_id,
							'section_order'       => $section_order + 1
						),
						array( '%s', '%s', '%d', '%d' )
					);
					if ( ! $inserted ) {
						continue;
					}
					$section_id = $wpdb->insert_id;
					if ( $section_id && ! empty( $section['items'] ) ) {
						foreach ( $section['items'] as $item_order => $item ) {
							$old_item_id = $item['item_id'];
							if ( ! empty( $this->processed_posts[ $old_item_id ] ) ) {
								$item_id = $this->processed_posts[ $old_item_id ];
								$wpdb->insert(
									$wpdb->prefix . 'learnpress_section_items',
									array(
										'section_id' => $section_id,
										'item_id'    => $item_id,
										'item_order' => $item_order + 1,
										'item_type'  => get_post_type( $item_id ),
									),
									array( '%d', '%d', '%d', '%s' )
								);
							}
						}
					}
				}
			}
		}

		/**
		 * Import quiz questions.
		 *
		 * @param $post
		 */
		public function process_quiz_questions( $post ) {
			global $wpdb;
			$old_post_id = $post['post_id'];
			$post_id     = ! empty( $this->processed_posts[ $old_post_id ] ) ? $this->processed_posts[ $old_post_id ] : 0;
			if ( $post_id && ! empty( $post['questions'] ) ) {
				foreach ( $post['questions'] as $question_order => $question ) {
					$question_id = ! empty( $this->processed_posts[ $question['question_id'] ] ) ? $this->processed_posts[ $question['question_id'] ] : 0;
					$inserted    = $question_id ? $wpdb->insert(
						$wpdb->prefix . 'learnpress_quiz_questions',
						array(
							'quiz_id'        => $post_id,
							'question_id'    => $question_id,
							'params'         => $question['params'],
							'question_order' => $question['question_order']
						),
						array( '%d', '%d', '%s', '%d' )
					) : 0;
				}
			}
		}

		/**
		 * Import question answers.
		 *
		 * @param $post
		 */
		public function process_question_answers( $post ) {
			global $wpdb;
			$old_post_id = $post['post_id'];
			$post_id     = ! empty( $this->processed_posts[ $old_post_id ] ) ? $this->processed_posts[ $old_post_id ] : 0;
			if ( $post_id && ! empty( $post['answers'] ) ) {
				foreach ( $post['answers'] as $answer_order => $answer ) {

					$key = 'base64:';
					if ( strpos( $answer['answer_data'], $key ) !== false ) {
						$answer_data = base64_decode( substr( $answer['answer_data'], strlen( $key ) ) );
					} else {
						$answer_data = $answer['answer_data'];
					}

					$inserted = $wpdb->insert(
						$wpdb->prefix . 'learnpress_question_answers',
						array(
							'question_id'  => $post_id,
							'answer_data'  => $answer_data,
							'answer_order' => $answer['answer_order']
						),
						array( '%d', '%s', '%d' )
					);
				}
			}
		}

		/**
		 * Check exists post.
		 *
		 * @param $fields
		 *
		 * @return int|null|string
		 */
		private function _post_exists( $fields ) {
			global $wpdb;

			$fields = wp_parse_args(
				$fields,
				array(
					'post_name'  => '',
					'post_type'  => 'lp_course',
					'post_title' => ''
				)
			);
			$query  = "SELECT ID FROM $wpdb->posts WHERE 1=1";
			$args   = array();
			extract( $fields );
			if ( ! empty ( $post_name ) ) {
				$query  .= " AND post_name LIKE '%s' ";
				$args[] = $post_name;
			}
			if ( ! empty ( $post_type ) ) {
				$query  .= " AND post_type = '%s' ";
				$args[] = $post_type;
			}

			if ( ! empty( $post_title ) ) {
				$query  .= " AND post_title = '%s' ";
				$args[] = $post_title;
			}
			//echo $wpdb->prepare($query, $args);die();
			if ( ! empty ( $args ) ) {
				return $wpdb->get_var( $wpdb->prepare( $query, $args ) );
			}

			return 0;
		}

		/**
		 * Check old meta data.
		 *
		 * @param $key
		 *
		 * @return bool
		 */
		private function _is_old_meta( $key ) {
			$old_meta = array(
				/* course */
				'_lpr_course_duration',
				'_lpr_course_number_student',
				'_lpr_max_course_number_student',
				'_lpr_retake_course',
				'_lpr_course_final',
				'_lpr_course_condition',
				'_lpr_course_enrolled_require',
				'_lpr_course_payment',
				/* quiz */
				'_lpr_quiz_questions',
				'_lpr_duration',
				'_lpr_retake_quiz',
				'_lpr_show_quiz_result',
				'_lpr_show_question_answer',
				'_lpr_course',
				/* lesson */
				'_lpr_lesson_duration',
				'_lpr_lesson_preview',
				'_lpr_course',
				/* question */
				'_lpr_question',
				'_lpr_question_mark',
				'_lpr_duration'
			);

			return in_array( $key, $old_meta );
		}

		/**
		 * Instance.
		 *
		 * @return LP_Import_LearnPress_Provider|null
		 */
		public static function instance() {
			if ( ! self::$_instance ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}
	}
}

return LP_Import_LearnPress_Provider::instance();