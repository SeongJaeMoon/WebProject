<?php
/**
 * Admin Import step 3 view.
 *
 * @since 3.0.0
 */
?>

<?php $_REQUEST['step'] = 0; ?>

<?php if ( isset( $GLOBALS['is_imported_done'] ) && $GLOBALS['is_imported_done'] ) { ?>
    <h1 style="color:#5cb85c; background: #dff0d8; padding: 10px;"><?php _e( 'Import Successfully!', 'learnpress-import-export' ); ?></h1>

    <a href="<?php echo admin_url( 'admin.php?page=learnpress-import-export&tab=import' ); ?>"
       class="button button-large button-primary"><?php _e( 'Import another', 'learnpress-import-export' ); ?></a>
<?php } else { ?>
    <h1><?php _e( 'Import Fail!', 'learnpress-import-export' ); ?></h1>
<?php } ?>