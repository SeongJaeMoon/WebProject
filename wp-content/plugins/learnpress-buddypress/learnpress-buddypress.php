<?php
/*
Plugin Name: LearnPress - BuddyPress Integration
Plugin URI: http://thimpress.com/learnpress
Description: Using the profile system provided by BuddyPress.
Author: ThimPress
Version: 3.0.2
Author URI: http://thimpress.com
Tags: learnpress, lms, add-on, buddypress
Text Domain: learnpress-buddypress
Domain Path: /languages/
*/

// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

define( 'LP_ADDON_BUDDYPRESS_FILE', __FILE__ );
define( 'LP_ADDON_BUDDYPRESS_VER', '3.0.2' );
define( 'LP_ADDON_BUDDYPRESS_REQUIRE_VER', '3.0.0' );
define( 'LP_ADDON_BP_VER', '3.0.2' );

/**
 * Class LP_Addon_BuddyPress_Preload
 */
class LP_Addon_BuddyPress_Preload {

	/**
	 * LP_Addon_BuddyPress_Preload constructor.
	 */
	public function __construct() {
		add_action( 'learn-press/ready', array( $this, 'load' ) );
		add_action( 'admin_notices', array( $this, 'admin_notices' ) );
	}

	/**
	 * Load addon
	 */
	public function load() {
		LP_Addon::load( 'LP_Addon_BuddyPress', 'inc/load.php', __FILE__ );
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
						__( '<strong>%s</strong> addon version %s requires %s version %s or higher is <strong>installed</strong> and <strong>activated</strong>.', 'learnpress-buddypress' ),
						__( 'LearnPress BuddyPress', 'learnpress-buddypress' ),
						LP_ADDON_BUDDYPRESS_VER,
						sprintf( '<a href="%s" target="_blank"><strong>%s</strong></a>', admin_url( 'plugin-install.php?tab=search&type=term&s=learnpress' ), __( 'LearnPress', 'learnpress-buddypress' ) ),
						LP_ADDON_BUDDYPRESS_REQUIRE_VER
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

new LP_Addon_BuddyPress_Preload();