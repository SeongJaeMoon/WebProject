 <div class="one-page-express-about-page">
      <div class="rp-panel">
        <div class="rp-c">
          <h1><?php _e('Thanks for choosing One Page Express!', 'one-page-express'); ?></h1>
          <p><?php _e('We\'re glad you chose our theme and we hope it will help you create a beautiful site in no time!<br> If you have any suggestions, don\'t hesitate to leave us some feedback.', 'one-page-express'); ?></p>
          <div class="one-page-express-get-started">
            <h2> <?php _e('Get Started in 3 Easy Steps', 'one-page-express'); ?></h2>
            <p><?php _e('1. Install the recommended plugins', 'one-page-express'); ?></p>
              <?php
                $config = \OnePageExpress\Companion_Plugin::$config;
                $plugins = $config['plugins'];

                foreach ($plugins as $slug => $plugin) {
                  $state = \OnePageExpress\Companion_Plugin::get_plugin_state($slug);
                  
                  $plugin_is_ready = $state['installed'] && $state['active'];
                  if (!$plugin_is_ready) {
                    if ($state['installed']) {
                      $link = \OnePageExpress\Companion_Plugin::get_activate_link($slug);
                      $label = $plugin['activate']['label'];
                      $btn_class = "activate";
                    } else {
                      $link = \OnePageExpress\Companion_Plugin::get_install_link($slug);
                      $label = $plugin['install']['label'];
                      $btn_class = "install-now";
                    }
                  }

                  $title = $plugin['title'];
                  $description = $plugin['description'];
              ?>

                  <div class="one-page-express_install_notice <?php if ($plugin_is_ready) echo 'blue'; ?>">
                    <h3 class="rp-plugin-title"><?php echo $title ?></h3>
                    <?php 
                      printf('<p>%1$s</p>', $description);
                      if (!$plugin_is_ready) {
                        printf('<a class="%1$s button" href="%2$s">%3$s</a>', $btn_class, esc_url($link), $label);
                      } else {
                        _e('Plugin is installed and active.', 'one-page-express');
                      }
                    ?>
                  </div>
              <?php
                }
              ?>
            <p>
              <?php 
              $customize_link = add_query_arg(
                array(
                  'url' =>  get_home_url()
                ),
                network_admin_url( 'customize.php' )
              );

              printf('2. <a class="button" href="%s"> %s </a> your site', $customize_link, __('Customize', 'one-page-express')); ?></p>
            <p><?php _e('3. Enjoy! :)', 'one-page-express'); ?></p>
          </div>
        </div>
          

      </div>
    </div>