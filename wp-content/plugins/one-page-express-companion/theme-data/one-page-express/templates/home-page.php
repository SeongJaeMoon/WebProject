<?php \OnePageExpress\Customizer\Template::header("homepage"); ?>
<div class="content">
    <?php the_post(); ?>
    <div class="page-content">
        <?php \OnePageExpress\Customizer\Template::content() ?>
    </div>
</div>
<?php \OnePageExpress\Customizer\Template::footer("one_page_express_get_footer"); ?>
