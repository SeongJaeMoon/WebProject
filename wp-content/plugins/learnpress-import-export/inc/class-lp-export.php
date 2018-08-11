<?php
/**
 * Learnpress Export class.
 *
 * @author   ThimPress
 * @package  LearnPress/Import-Export/Classes
 * @version  3.0.0
 */

// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'LP_Export' ) ) {
	/**
	 * Class LP_Export.
	 */
	class LP_Export {

		/**
		 * LP_Export constructor.
		 */
		public function __construct() {
			add_filter( 'lpie_export_provider_class', array( $this, 'provider_class' ), 5, 2 );

			do_action( 'learn-press/export/init-hooks', $this );

			include_once LP_ADDON_IMPORT_EXPORT_INC . 'admin/providers/learnpress/class-lp-export-learnpress.php';
		}

		/**
		 * Get export provider class.
		 *
		 * @param $class
		 * @param $name
		 *
		 * @return string
		 */
		public function provider_class( $class, $name ) {
			switch ( strtolower( $name ) ) {
				case 'learnpress':
					$class = 'LP_Export_LearnPress_Provider';
					break;
			}

			return $class;
		}

	}
}

return new LP_Export();
