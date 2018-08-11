<?php
/*
Plugin Name: LearnPress - Export/Import Courses
Plugin URI: http://thimpress.com/learnpress
Description: Export and Import your courses with all lesson and quiz in easiest way.
Author: ThimPress
Version: 3.0.1
Author URI: http://thimpress.com
Tags: learnpress, lms, add-on, prerequisites courses
Text Domain: learnpress-import-export
Domain Path: /languages/
*/

// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

define( 'LP_ADDON_IMPORT_EXPORT_FILE', __FILE__ );
define( 'LP_ADDON_IMPORT_EXPORT_VER', '3.0.1' );
define( 'LP_ADDON_IMPORT_EXPORT_REQUIRE_VER', '3.0.0' );
define( 'LP_IMPORT_EXPORT_VER', '3.0.0' );

/**
 * Class LP_Addon_Import_Export_Preload
 */
class LP_Addon_Import_Export_Preload {

	/**
	 * LP_Addon_Import_Export_Preload constructor.
	 */
	public function __construct() {
		add_action( 'learn-press/ready', array( $this, 'load' ) );
		add_action( 'admin_notices', array( $this, 'admin_notices' ) );
	}

	/**
	 * Load addon
	 */
	public function load() {
		LP_Addon::load( 'LP_Addon_Import_Export', 'inc/load.php', __FILE__ );
		remove_action( 'admin_notices', array( $this, 'admin_notices' ) );
	}

	/**
	 * Admin notice
	 */
	public function admin_notices() {
		?>
        <div class="error">
            <p><?php echo wp_kses(
					sprintf(
						__( '<strong>%s</strong> addon version %s requires %s version %s or higher is <strong>installed</strong> and <strong>activated</strong>.', 'learnpress-import-export' ),
						__( 'LearnPress Import_Export', 'learnpress-import-export' ),
						LP_ADDON_IMPORT_EXPORT_VER,
						sprintf( '<a href="%s" target="_blank"><strong>%s</strong></a>', admin_url( 'plugin-install.php?tab=search&type=term&s=learnpress' ), __( 'LearnPress', 'learnpress-import-export' ) ),
						LP_ADDON_IMPORT_EXPORT_REQUIRE_VER
					),
					array(
						'a'      => array(
							'href'  => array(),
							'blank' => array()
						),
						'strong' => array()
					)
				); ?>
            </p>
        </div>
		<?php
	}
}

new LP_Addon_Import_Export_Preload();