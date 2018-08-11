<div class="post-list-item">
<div id="post-<?php the_ID(); ?>" <?php post_class( 'blog-post' ); ?>>
  <div class="post-content">
      <?php
        if ( has_post_thumbnail() ):
      ?>
        <a href="<?php the_permalink(); ?>" class="post-list-item-thumb">
          <?php the_post_thumbnail(); ?>
        </a>  
      <?php 
        endif;
    ?>
    <div class="row_345">
      <h3 class="blog-title">
        <a href="<?php the_permalink(); ?>" rel="bookmark">
          <?php the_title(); ?>
        </a>
      </h3>
     
        <?php 
          the_excerpt();
        ?>


         <?php  get_template_part('template-parts/content-post-footer'); ?>
    </div>
  </div>
</div>
</div>