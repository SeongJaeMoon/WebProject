<?php
/**
 * LearnPress BuddyPress Functions
 *
 * Define common functions for both front-end and back-end
 *
 * @author   ThimPress
 * @package  LearnPress/BuddyPress/Functions
 * @version  3.0.0
 */

// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'learn_press_buddypress_paging_nav' ) ) :
	/**
	 * Display navigation to next/previous set of posts when applicable.
	 *
	 * @param array
	 */
	function learn_press_buddypress_paging_nav( $args = array() ) {

		$args = wp_parse_args(
			$args,
			array(
				'num_pages'     => 0,
				'paged'         => get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1,
				'wrapper_class' => 'learn-press-pagination',
				'base'          => false
			)
		);
		if ( $args['num_pages'] < 2 ) {
			return;
		}
		$paged        = $args['paged'];
		$pagenum_link = html_entity_decode( $args['base'] === false ? get_pagenum_link() : $args['base'] );

		$query_args = array();
		$url_parts  = explode( '?', $pagenum_link );

		if ( isset( $url_parts[1] ) ) {
			wp_parse_str( $url_parts[1], $query_args );
		}

		$pagenum_link = remove_query_arg( array_keys( $query_args ), $pagenum_link );
		$pagenum_link = trailingslashit( $pagenum_link ) . '%_%';

		$format = $GLOBALS['wp_rewrite']->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
		$format .= '?paged=%#%';

		// Set up paginated links.
		$links = paginate_links( array(
			'base'      => $pagenum_link,
			'format'    => $format,
			'total'     => $args['num_pages'],
			'current'   => max( 1, $paged ),
			'mid_size'  => 1,
			'add_args'  => array_map( 'urlencode', $query_args ),
			'prev_text' => __( '<', 'learnpress-buddypress' ),
			'next_text' => __( '>', 'learnpress-buddypress' ),
			'type'      => 'list'
		) );

		if ( $links ) { ?>
            <div class="<?php echo $args['wrapper_class']; ?>"><?php echo $links; ?></div>
            <!-- .pagination -->
			<?php
		}
	}

endif;