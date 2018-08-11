<?php
/**
 * Admin Export step 3 view.
 *
 * @since 3.0.0
 */
?>

<div id="exporting" class="hide-if-js">
    <span class="dashicons dashicons-image-rotate"></span>
	<?php _e( 'Exporting...', 'learnpress-import-export' ); ?>
</div>

<div id="exported">
	<?php _e( 'Exported', 'learnpress-import-export' ); ?>
	<?php foreach ( $_REQUEST['courses'] as $course_id ): ?>
        <input type="hidden" name="courses[]" value="<?php echo $course_id; ?>"/>
	<?php endforeach; ?>
    <input type="hidden" name="step" value="<?php echo $_REQUEST['step']; ?>"/>
    <input type="hidden" name="exporter" value="<?php echo $_REQUEST['exporter']; ?>"/>
    <input type="hidden" name="download_export" value="<?php echo $_REQUEST['download_export']; ?>"/>
    <input type="hidden" name="learn-press-export-file-name"
           value="<?php echo $_REQUEST['learn-press-export-file-name']; ?>"/>
    <p>
        <button class="button button-primary" id="lpie-button-cancel">
			<?php _e( 'Export new', 'learnpress-import-export' ); ?></button>
        <button class="button" id="lpie-export-again">
			<?php _e( 'Export again!', 'learnpress-import-export' ); ?></button>
    </p>
</div>
<?php if ( ! empty( $_REQUEST['download_url'] ) ) { ?>
    <script type="text/javascript">
        typeof jQuery !== 'undefined' && jQuery(function ($) {
            window.location.href = '<?php echo admin_url( 'admin.php?page=learnpress-import-export' ) . '&download-file=' . $_REQUEST['download_url'] . '&alias=' . $_REQUEST['download_alias'] . '&nonce=' . wp_create_nonce( 'lpie-download-file' ); ?>';
        })
    </script>
<?php } ?>
