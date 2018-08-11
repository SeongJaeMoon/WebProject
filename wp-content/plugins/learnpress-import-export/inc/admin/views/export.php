<?php
/**
 * Admin Import view.
 *
 * @since 3.0.0
 */
?>

<?php $step = learn_press_get_request( 'step', 0 ); ?>

<form method="post" name="export-courses" action="admin.php?page=learnpress-import-export"
      enctype="multipart/form-data">

    <!-- Form to select source to export -->
    <div id="export-form" class="postbox">
        <h2 class="hndle"><span><?php _e( 'Export', 'learnpress-import-export' ); ?></span></h2>
        <div class="inside">
            <input type="hidden" name="step" value="<?php echo $step + 1; ?>"/>

			<?php if ( $step ) { ?>
                <!--view for each step-->
				<?php do_action( 'lpie_export_view_step_' . $step ); ?>
			<?php } else { ?>

                <!--main export page-->
                <h3><?php _e( 'Select source', 'learnpress-import-export' ); ?></h3>
                <!--select export source-->
				<?php if ( $sources = lpie_get_export_source() ) { ?>
					<?php $i = 0; ?>
                    <ul class="lpie-export-source">
						<?php foreach ( $sources as $type => $name ) { ?>
							<?php $i ++; ?>
                            <li>
                                <label>
                                    <input type="radio" name="exporter"
                                           value="<?php echo $type; ?>" <?php checked( $i == 1 ); ?> />
									<?php echo $name; ?>
                                </label>
                            </li>
						<?php } ?>
                    </ul>
                    <input type="hidden" name="action" value="export"/>
                    <button class="button button-primary"><?php _e( 'Continue', 'learnpress-import-export' ); ?></button>
				<?php } ?>
			<?php } ?>

			<?php $step ++; ?>
            <input type="hidden" name="export-nonce"
                   value="<?php echo wp_create_nonce( 'learnpress-import-export-export' ); ?>"/>
        </div>
    </div>
</form>

<form method="post" name="export-download" action="admin.php?page=learnpress-import-export"
      enctype="multipart/form-data">
    <!-- List of files are exported -->
	<?php $exports = lpie_get_export_files(); ?>
	<?php $total = sizeof( $exports ); ?>
    <div id="browse-exported-files" class="postbox">
        <h2 class="hndle">
            <span><?php printf( __( 'Recent exported', 'learnpress-import-export' ), $total ); ?></span>
        </h2>

        <div class="inside">
            <p>
                <strong><?php printf( $total ? _nx( '%d file', '%d files', $total, 'learnpress-import-export' ) : __( '%d file' ), $total ); ?></strong>
                <a href="" data-text="<?php _e( 'Remove selected', 'learnpress-import-export' ); ?>"
                   data-url="<?php echo wp_nonce_url( admin_url( 'admin.php?page=learnpress-import-export&tab=' . lpie_get_current_tab() ), 'lpie-delete-export-file', 'nonce' ) . '&delete-export='; ?>"
                   id="learn-press-remove-files"
                   class="hide-if-js"><?php _e( 'Remove selected', 'learnpress-import-export' ); ?></a>
            </p>
            <table class="wp-list-table widefat fixed striped">
                <thead>
                <tr>
                    <th width="20">#</th>
                    <th width="20"><input type="checkbox" id="learn-press-check-all-files"/></th>
                    <th><?php _e( 'File', 'learnpress-import-export' ); ?></th>
                    <th width="25%"><?php _e( 'Time', 'learnpress-import-export' ); ?></th>
                    <th width="50"><?php _e( 'Size', 'learnpress-import-export' ); ?></th>
                </tr>
                </thead>
                <tbody>
				<?php if ( $exports ) { ?>
					<?php $index = 0; ?>
					<?php foreach ( $exports as $file ) { ?>
						<?php $m_time = date( 'Y/m/d g:i:s a', $file['lastmodunix'] ); ?>
                        <tr>
                            <td><?php echo ++ $index; ?></td>
                            <td><input type="checkbox" class="check-file" value="<?php echo $file['name']; ?>"/></td>
                            <th>
								<?php echo $file['name']; ?>
                                <p>
                                    <a href="<?php echo wp_nonce_url( admin_url( 'admin.php?page=learnpress-import-export&tab=export&download-export=' . $file['name'] ), 'lpie-download-export-file', 'nonce' ); ?>">
										<?php _e( 'Download', 'learnpress-import-export' ); ?></a>
                                    |
                                    <a href="<?php echo lpie_get_url( 'learnpress/export/' . $file['name'] ); ?>"
                                       target="_blank"><?php _e( 'View', 'learnpress-import-export' ); ?></a>
                                    |
                                    <a href="<?php echo wp_nonce_url( admin_url( 'admin.php?page=learnpress-import-export&tab=import&learnpress_import_form_server=export/' . $file['name'] ), 'learnpress-import-export-import', 'import-nonce' ); ?>">
										<?php _e( 'Import', 'learnpress-import-export' ); ?></a>
                                    |
                                    <a href="<?php echo wp_nonce_url( admin_url( 'admin.php?page=learnpress-import-export&tab=import&delete-export=' . $file['name'] ), 'lpie-delete-export-file', 'nonce' ); ?>">
										<?php _e( 'Remove', 'learnpress-import-export' ); ?></a>
                                </p>
                            </th>
                            <td><?php echo $m_time; ?></td>
                            <td><?php echo size_format( $file['size'] ); ?></td>
                        </tr>
					<?php } ?>
				<?php } else { ?>
                    <tr>
                        <td colspan="5"><?php _e( 'No exported files', 'learnpress-import-export' ); ?></td>
                    </tr>
				<?php } ?>
                </tbody>
            </table>

        </div>
    </div>
</form>
