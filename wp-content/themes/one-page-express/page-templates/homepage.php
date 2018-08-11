<?php
/*
 * Template Name: Front Page Template
 */
get_header('homepage');
?>

<div class="page-content">
  <div class="gridContainer">
   <?php 
      while ( have_posts() ) : the_post();
        get_template_part( 'template-parts/content', 'page' );
      endwhile;
     ?>
  </div>
</div>

<?php one_page_express_get_footer(); ?>