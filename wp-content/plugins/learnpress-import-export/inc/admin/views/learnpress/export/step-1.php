<?php
/**
 * Admin Export step 1 view.
 *
 * @since 3.0.0
 */
?>

<?php
$courses     = LP_Export_LearnPress_Provider::get_courses();
$selected    = ! empty( $_REQUEST['courses'] ) ? $_REQUEST['courses'] : array();
$all_courses = array();
?>

<h3><?php _e( 'Select courses', 'learnpress-import-export' ); ?></h3>

<?php if ( $courses ) { ?>
	<?php $course_ids = array(); ?>
    <table class="list-export-courses">
        <thead>
        <tr>
            <th><?php _e( 'Course', 'learnpress-import-export' ); ?></th>
            <th><?php _e( 'Status', 'learnpress-import-export' ); ?></th>
            <th><?php _e( 'Author/Instructor', 'learnpress-import-export' ); ?></th>
        </tr>
        </thead>
        <tbody>
		<?php foreach ( $courses as $course ) {
			$user         = get_user_by( 'ID', $course->post_author );
			$course_ids[] = $course->ID;
			$is_checked   = in_array( $course->ID, $selected );
			if ( $is_checked ) {
				$all_courses[] = $course->ID;
			}
			?>
            <tr>
                <td>
                    <label>
                        <input type="checkbox" name="courses[]"
                               value="<?php echo $course->ID; ?>" <?php checked( $is_checked ); ?> />
						<?php echo get_the_title( $course->ID ); ?>
                    </label>
                </td>
                <td><?php echo get_post_status( $course->ID ); ?></td>
                <td><?php echo $user ? sprintf( '%s (%s)', $user->user_login, $user->user_email ) : '-'; ?></td>
            </tr>
		<?php } ?>
        <tr>
            <th colspan="2">
                <label>
                    <input type="checkbox"
                           id="learn-press-import-export-select-all" <?php checked( ! array_diff( $course_ids, $all_courses ) ); ?> />
					<?php _e( 'Select all', 'learnpress-import-export' ); ?>
                </label>
            </th>
        </tr>
        </tbody>
    </table>
<?php } else { ?>
    <p><?php echo __( 'No course available to export.', 'learnpress-import-export' ); ?></p>
<?php } ?>
<input type="hidden" name="exporter" value="<?php echo $_REQUEST['exporter'];?>">
<p>
    <button class="button button-primary" id="button-export-next" disabled="disabled">
		<?php _e( 'Next', 'learnpress-import-export' ); ?>
    </button>
    <button class="button" id="lpie-button-back-step"><?php _e( 'Back', 'learnpress-import-export' ); ?></button>
</p>
