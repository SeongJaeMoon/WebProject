<?php
/**
 * Admin Import/Export Setting view.
 *
 * @since 3.0.0
 */
?>

<?php
$tabs        = array(
	'export' => __( 'Export', 'learnpress-import-export' ),
	'import' => __( 'Import', 'learnpress-import-export' )
);
$current_tab = lpie_get_current_tab();
?>

<div class="wrap">
    <h1><?php _e( 'Import/Export', 'learnpress-import-export' ); ?></h1>
    <h2 class="nav-tab-wrapper lp-nav-tab-wrapper">
		<?php foreach ( $tabs as $slug => $title ): ?>
            <a href="<?php echo admin_url( 'admin.php?page=learnpress-import-export&tab=' . $slug ); ?>"
               class="nav-tab<?php echo $slug == $current_tab ? ' nav-tab-active' : ''; ?>"><?php echo $title; ?></a>
		<?php endforeach; ?>
    </h2>
    <div id="poststuff" class="learn-press-export-import">
        <!--include import or export setting page-->
		<?php include dirname( __FILE__ ) . "/{$current_tab}.php"; ?>
    </div>
</div>