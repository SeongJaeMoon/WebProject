<?php
/*
Plugin Name: LearnPress - Course Review
Plugin URI: http://thimpress.com/learnpress
Description: Adding review for course.
Author: ThimPress
Version: 3.0.3
Author URI: http://thimpress.com
Tags: learnpress
Requires at least: 3.8
Tested up to: 4.9.6
Text Domain: learnpress-course-review
Domain Path: /languages/
*/

// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

define( 'LP_ADDON_COURSE_REVIEW_FILE', __FILE__ );
define( 'LP_ADDON_COURSE_REVIEW_VER', '3.0.3' );
define( 'LP_ADDON_COURSE_REVIEW_REQUIRE_VER', '3.0.0' );

/**
 * Class LP_Addon_Course_Review_Preload
 */
class LP_Addon_Course_Review_Preload {

	/**
	 * LP_Addon_Course_Review_Preload constructor.
	 */
	public function __construct() {
		add_action( 'learn-press/ready', array( $this, 'load' ) );
		add_action( 'admin_notices', array( $this, 'admin_notices' ) );
	}

	/**
	 * Load addon
	 */
	public function load() {
		LP_Addon::load( 'LP_Addon_Course_Review', 'inc/load.php', __FILE__ );
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
						__( '<strong>%s</strong> addon version %s requires %s version %s or higher is <strong>installed</strong> and <strong>activated</strong>.', 'learnpress-course-review' ),
						__( 'LearnPress Course Review', 'learnpress-course-review' ),
						LP_ADDON_COURSE_REVIEW_VER,
						sprintf( '<a href="%s" target="_blank"><strong>%s</strong></a>', admin_url( 'plugin-install.php?tab=search&type=term&s=learnpress' ), __( 'LearnPress', 'learnpress-course-review' ) ),
						LP_ADDON_COURSE_REVIEW_REQUIRE_VER
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

new LP_Addon_Course_Review_Preload();