<div class="footer">
   <div class="row_201">
    <div class="column_209 gridContainer">
     <div class="row_202">
      <div class="column_210">
        <i class="font-icon-18 fa <?php echo esc_attr(get_theme_mod('one_page_express_footer_boxes_b1_icon', 'fa-map-marker')); ?>">
        </i>
      <p>
        <?php echo wp_kses_post(get_theme_mod('one_page_express_footer_boxes_b1_text', 'San Francisco - Adress - 18 California Street 1100.')); ?>
      </p>
      </div>
      <div class="column_210" >
        <i class="font-icon-18 fa <?php echo esc_attr(get_theme_mod('one_page_express_footer_boxes_b2_icon', 'fa-envelope-o')); ?> ">
        </i>
        <p >
        <?php echo wp_kses_post(get_theme_mod('one_page_express_footer_boxes_b2_text', 'hello@mycoolsite.com')); ?>
        </p>
      </div>
      <div class="column_210" >
        <i class="font-icon-18 fa <?php echo esc_attr(get_theme_mod('one_page_express_footer_boxes_b3_icon', 'fa-phone')); ?> ">
        </i>
         <p>
        <?php echo wp_kses_post(get_theme_mod('one_page_express_footer_boxes_b3_text', '+1 (555) 345 234343')); ?>
        </p>
      </div>
      <div class="footer-column-colored-1">
          <div>
             <div class="row_205"> 
               <?php one_page_express_footer_social_icons();?>
               </div>
          </div>
          <p class="paragraph10"><?php echo one_page_express_copyright();?></p>
      </div>
     </div>
    </div>
   </div>
</div>
<?php wp_footer();?>
    </body>
</html>
