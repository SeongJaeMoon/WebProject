<?php

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 */

if(!defined('OPE_THEME_REQUIRED_PHP_VERSION')){
    define('OPE_THEME_REQUIRED_PHP_VERSION','5.3.0');
}

add_action( 'after_switch_theme', 'one_page_express_check_php_version' );

function one_page_express_check_php_version(){
  // Compare versions.
  if ( version_compare(phpversion(), OPE_THEME_REQUIRED_PHP_VERSION, '<') ) :
    // Theme not activated info message.
    add_action( 'admin_notices', 'one_page_express_php_version_notice' );
    

    // Switch back to previous theme.
    switch_theme(get_option( 'theme_switched' )  );
    return false;
  endif;
}

function one_page_express_php_version_notice() {
    ?>
    <div class="notice notice-alt notice-error notice-large">
        <h4><?php _e('One Page Express theme activation failed!','one-page-express'); ?></h4>
        <p>
            <?php _e( 'You need to update your PHP version to use the <strong>One Page Express</strong>.', 'one-page-express' ); ?> <br />
            <?php _e( 'Current php version is:', 'one-page-express' ) ?> <strong>
            <?php echo phpversion(); ?></strong>, <?php _e( 'and the minimum required version is ', 'one-page-express' ) ?> 
            <strong><?php echo OPE_THEME_REQUIRED_PHP_VERSION; ?></strong>
        </p>
    </div>
    <?php
}

if( version_compare(phpversion(), OPE_THEME_REQUIRED_PHP_VERSION, '>=')){
    require_once get_template_directory() . "/inc/functions.php";
}
