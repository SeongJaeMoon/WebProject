<?php
global $wpdb;
/**
 * Export course sections
 */
$query = $wpdb->prepare( "
	SELECT q.*, qq.*
	FROM {$wpdb->posts} q
	INNER JOIN {$wpdb->prefix}learnpress_quiz_questions qq ON q.ID = qq.question_id
	WHERE quiz_id = %d
", $post->ID );
if ( $questions = $wpdb->get_results( $query ) ) {
	foreach ( $questions as $question ):?>

		<wp:question>
			<wp:quiz_id><?php echo $question->quiz_id; ?></wp:quiz_id>
			<wp:question_id><?php echo $question->question_id; ?></wp:question_id>
			<wp:params><?php echo wxr_cdata( $question->params ); ?></wp:params>
			<wp:question_order><?php echo $question->question_order; ?></wp:question_order>
		</wp:question>

	<?php endforeach;
} ?>
