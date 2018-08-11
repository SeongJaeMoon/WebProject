<?php echo '<?xml version="1.0" encoding="' . get_bloginfo( 'charset' ) . "\" ?>\n"; ?>
<rss version="2.0"
     xmlns:excerpt="http://wordpress.org/export/<?php echo LP_ADDON_IMPORT_EXPORT_VER; ?>/excerpt/"
     xmlns:content="http://purl.org/rss/1.0/modules/content/"
     xmlns:wfw="http://wellformedweb.org/CommentAPI/"
     xmlns:dc="http://purl.org/dc/elements/1.1/"
     xmlns:wp="http://wordpress.org/export/<?php echo LP_ADDON_IMPORT_EXPORT_VER; ?>/">

	<?php global $wpdb, $post; ?>

    <channel>
        <title><?php bloginfo_rss( 'name' ); ?></title>
        <link><?php bloginfo_rss( 'url' ); ?></link>
        <description><?php bloginfo_rss( 'description' ); ?></description>
        <pubDate><?php echo date( 'D, d M Y H:i:s +0000' ); ?></pubDate>
        <language><?php bloginfo_rss( 'language' ); ?></language>
        <wp:wxr_version><?php echo LP_ADDON_IMPORT_EXPORT_VER; ?></wp:wxr_version>
        <wp:base_site_url><?php echo wxr_site_url(); ?></wp:base_site_url>
        <wp:base_blog_url><?php bloginfo_rss( 'url' ); ?></wp:base_blog_url>
        <wp:plugin_name><?php echo $export_options['exporter']; ?></wp:plugin_name>
        <wp:plugin_version><?php echo LP_ADDON_IMPORT_EXPORT_VER; ?></wp:plugin_version>
		<?php wxr_authors_list( $export_options['courses'] ); ?>
		<?php echo $items; ?>
    </channel>
</rss>