<?php
/**
 * Learnpress Import class.
 *
 * @author   ThimPress
 * @package  LearnPress/Import-Export/Classes
 * @version  3.0.0
 */

// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'LP_Import' ) ) {
	/**
	 * Class LP_Import.
	 */
	class LP_Import {

		/**
		 * LP_Import constructor.
		 */
		public function __construct() {
			do_action( 'learn-press/import/init-hooks', $this );

			include_once LP_ADDON_IMPORT_EXPORT_INC . 'admin/providers/learnpress/class-lp-import-learnpress.php';
		}
	}
}

return new LP_Import();
