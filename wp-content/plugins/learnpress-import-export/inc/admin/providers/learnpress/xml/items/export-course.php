<?php
global $wpdb;
/**
 * Export course sections
 */
$sections = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM $wpdb->learnpress_sections WHERE section_course_id = %d ORDER BY section_order ASC", $post->ID ) );
if ( $sections ) {
	foreach ( $sections as $section ) : ?>
        <wp:section>
        <wp:section_id><?php echo $section->section_id; ?></wp:section_id>
        <wp:section_name><?php echo esc_html( $section->section_name ); ?></wp:section_name>
        <wp:section_course_id><?php echo $section->section_course_id; ?></wp:section_course_id>
        <wp:section_order><?php echo $section->section_order; ?></wp:section_order>
        <wp:section_description><?php echo wxr_cdata( $section->section_description ); ?></wp:section_description>
		<?php
		/**
		 * Export course section items
		 */
		$query         = $wpdb->prepare( "SELECT si.*, p.post_type FROM $wpdb->learnpress_section_items si INNER JOIN {$wpdb->posts} p ON p.ID = si.item_id WHERE section_id = %d", $section->section_id );
		$section_items = $wpdb->get_results( $query );
		if ( $section_items ) {
			foreach ( $section_items as $item ) : ?>
                <wp:section_item>
                    <wp:section_id><?php echo $item->section_id; ?></wp:section_id>
                    <wp:item_id><?php echo $item->item_id; ?></wp:item_id>
                    <wp:item_order><?php echo $item->item_order; ?></wp:item_order>
                    <wp:item_type><?php echo $item->item_type; ?></wp:item_type>
                </wp:section_item>
			<?php endforeach;
		} ?>
        </wp:section><?php
	endforeach;
}