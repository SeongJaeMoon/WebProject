<?php
/**
 * Admin Import step 1 view.
 *
 * @since 3.0.0
 */
?>

<ul class="form-options">
    <li>
        <label><?php _e( 'Save imported file', 'learnpress-import-export' ); ?></label>
        <input type="hidden" name="save_import" value="0"/>
        <input type="checkbox" name="save_import" value="1"/>
        <p class="description">
			<?php _e( 'Save imported file on your server so you can download/import it later', 'learnpress-import-export' ); ?>
        </p>
    </li>
</ul>
<?php
$file = lp_import_handle_upload( $_FILES['lpie_import_file'], array(
	'mimes'     => array( 'xml' => 'text/xml' ),
	'test_type' => false
) );
if ( ! empty( $file['file'] ) && file_exists( $file['file'] ) ) {
	$_REQUEST['file'] = $file['file'];
}
?>
<input type="hidden" name="import-file" value="tmp/<?php echo basename( $_REQUEST['file'] ); ?>"/>
<input type="hidden" name="nonce" value="<?php echo wp_create_nonce( 'lpie-import-file' ); ?>"/>
<button class="button button-primary"><?php _e( 'Import', 'learnpress-import-export' ); ?></button>
