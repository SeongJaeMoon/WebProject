<?php one_page_express_get_header();?>

<div class="content">
  <div class="gridContainer">
    <div class="row">
      <div class="post-item <?php if (!is_active_sidebar('sidebar-1')) echo 'post-item-large'; ?>">
        <?php 
            if (have_posts()):
              while (have_posts()): 
                the_post(); 
                get_template_part('template-parts/content', 'single');
              endwhile;
            else :
              get_template_part('template-parts/content', 'none'); 
            endif;
        ?>
      </div> 
      <?php get_sidebar(); ?>
   </div>
  </div>

</div>
<?php one_page_express_get_footer();?>