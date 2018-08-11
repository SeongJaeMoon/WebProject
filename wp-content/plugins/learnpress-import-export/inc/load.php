<?php
/**
 * Plugin load class.
 *
 * @author   ThimPress
 * @package  LearnPress/Import-Export/Classes
 * @version  3.0.0
 */

// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'LP_Addon_Import_Export' ) ) {
	/**
	 * Class LP_Addon_Import_Export
	 */
	class LP_Addon_Import_Export extends LP_Addon {

		/**
		 * @var string
		 */
		public $version = LP_ADDON_IMPORT_EXPORT_VER;

		/**
		 * @var string
		 */
		public $require_version = LP_ADDON_IMPORT_EXPORT_REQUIRE_VER;

		/**
		 * @var null
		 */
		private $importer = null;

		/**
		 * @var null
		 */
		private $exporter = null;

		/**
		 * LP_Addon_Import_Export constructor.
		 */
		public function __construct() {
			parent::__construct();
		}

		/**
		 * Define Learnpress Import Export constants.
		 *
		 * @since 3.0.0
		 */
		protected function _define_constants() {
			define( 'LP_ADDON_IMPORT_EXPORT_PATH', dirname( LP_ADDON_IMPORT_EXPORT_FILE ) );
			define( 'LP_ADDON_IMPORT_EXPORT_INC', LP_ADDON_IMPORT_EXPORT_PATH . '/inc/' );
			define( 'LP_ADDON_IMPORT_EXPORT_URL', plugins_url( '/', LP_ADDON_IMPORT_EXPORT_FILE ) );
		}

		/**
		 * Include required core files used in admin and on the frontend.
		 *
		 * @since 3.0.0
		 */
		protected function _includes() {
			include_once LP_ADDON_IMPORT_EXPORT_INC . 'functions.php';
			include_once LP_ADDON_IMPORT_EXPORT_INC . 'parsers.php';
		}

		/**
		 * Hook into actions and filters.
		 */
		protected function _init_hooks() {
			add_action( 'admin_menu', array( $this, 'admin_menu' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );
			add_action( 'admin_init', array( $this, 'do_action' ) );

			$this->importer = include_once( LP_ADDON_IMPORT_EXPORT_INC . 'class-lp-import.php' );
			$this->exporter = include_once( LP_ADDON_IMPORT_EXPORT_INC . 'class-lp-export.php' );
		}

		/**
		 * Add admin menu.
		 */
		public function admin_menu() {
			add_submenu_page(
				'learn_press',
				__( 'Import/Export', 'learnpress-import-export' ),
				__( 'Import/Export', 'learnpress-import-export' ),
				'manage_options',
				'learnpress-import-export',
				array( $this, 'admin_page' )
			);
		}

		/**
		 * Admin import export page.
		 */
		public function admin_page() {
			lpie_admin_view( 'settings-page' );
		}

		/**
		 * Admin script.
		 */
		public function admin_scripts() {
			$assets = learn_press_admin_assets();

			$assets->enqueue_script( 'learn-press-import-script', $this->get_plugin_url( 'assets/js/import.js' ), array(
				'jquery',
				'backbone',
				'wp-util',
				'plupload'
			) );
			$assets->enqueue_script( 'learn-press-export-script', $this->get_plugin_url( 'assets/js/export.js' ), array(
				'jquery',
				'backbone',
				'wp-util'
			) );
			$assets->enqueue_style( 'learn-press-import-export-style', $this->get_plugin_url( 'assets/css/export-import.css' ) );
		}

		/**
		 * Do actions when admin init.
		 */
		public function do_action() {
			do_action( 'learn_press_import_export_actions' );

			// delete files
			$this->_delete_files();
			// download file
			$this->_download_file();
			// delete temp
			$this->_delete_tmp();
		}

		/**
		 * Delete file what was imported/exported.
		 */
		private function _delete_files() {
			// delete file
			if ( ! empty( $_REQUEST['delete-export'] ) && wp_verify_nonce( $_REQUEST['nonce'], 'lpie-delete-export-file' ) ) {
				$file = learn_press_get_request( 'delete-export' );
				if ( $file ) {
					$file = explode( ',', $file );
					foreach ( $file as $f ) {
						lpie_delete_file( 'learnpress/export/' . $f );
					}
				}
				wp_redirect( admin_url( 'admin.php?page=learnpress-import-export&tab=export' ) );
				exit();
			}
			if ( ! empty( $_REQUEST['delete-import'] ) && wp_verify_nonce( $_REQUEST['nonce'], 'lpie-delete-import-file' ) ) {
				$file = learn_press_get_request( 'delete-import' );
				if ( $file ) {
					$file = explode( ',', $file );
					foreach ( $file as $f ) {
						lpie_delete_file( 'learnpress/import/' . $f );
					}
				}
				wp_redirect( admin_url( 'admin.php?page=learnpress-import-export&tab=import' ) );
				exit();
			}
		}

		/**
		 * Download file what was imported/exported.
		 */
		private function _download_file() {
			// download file was exported
			if ( ! empty( $_REQUEST['download-export'] ) && wp_verify_nonce( $_REQUEST['nonce'], 'lpie-download-export-file' ) ) {
				$file = learn_press_get_request( 'download-export' );
				lpie_export_header( $file );
				echo lpie_get_contents( 'learnpress/export/' . $file );
				die();
			}
			// download file was imported
			if ( ! empty( $_REQUEST['download-import'] ) && wp_verify_nonce( $_REQUEST['nonce'], 'lpie-download-import-file' ) ) {
				$file = learn_press_get_request( 'download-import' );
				lpie_export_header( $file );
				echo lpie_get_contents( 'learnpress/import/' . $file );
				die();
			}
			// download file was imported
			if ( ! empty( $_REQUEST['download-file'] ) && wp_verify_nonce( $_REQUEST['nonce'], 'lpie-download-file' ) ) {
				$file = learn_press_get_request( 'download-file' );
				lpie_export_header( ! empty( $_REQUEST['alias'] ) ? $_REQUEST['alias'] : basename( $file ) );
				echo lpie_get_contents( $file );
				die();
			}
		}

		/**
		 * Delete temp files.
		 */
		private function _delete_tmp() {
			if ( $filesystem = lpie_filesystem() ) {
				$path = lpie_root_path() . '/learnpress/tmp';
				$list = $filesystem->dirlist( $path );
				if ( $list ) {
					foreach ( $list as $file ) {
						if ( time() - $file['lastmodunix'] > HOUR_IN_SECONDS ) {
							@unlink( $path . '/' . $file['name'] );
						}
					}
				}
			}
		}
	}

	add_action( 'plugins_loaded', array( 'LP_Addon_Import_Export', 'instance' ) );
}