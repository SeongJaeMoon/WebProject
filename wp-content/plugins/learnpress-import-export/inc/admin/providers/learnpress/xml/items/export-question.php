<?php
global $wpdb;
/**
 * Export course sections
 */
$query            = $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}learnpress_question_answers WHERE question_id = %d", $post->ID );
$question_answers = $wpdb->get_results( $query );
if ( $question_answers ) {
	foreach ( $question_answers as $answer ): ?>

        <wp:answer>
            <wp:question_id><?php echo $post->ID; ?></wp:question_id>
            <wp:answer_data><?php echo wxr_cdata( 'base64:' . base64_encode( $answer->answer_data ) ); ?></wp:answer_data>
            <wp:answer_order><?php echo $answer->answer_order; ?></wp:answer_order>
        </wp:answer>

	<?php endforeach;
} ?>