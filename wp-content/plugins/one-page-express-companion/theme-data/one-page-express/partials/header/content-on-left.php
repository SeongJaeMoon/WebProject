<div class="row header-description-row">

    <div class="header-description-right">
        <?php
        if (!empty($onepage_builder_header_title) && !empty($onepage_builder_header_subtitle)) {
            if (!empty($onepage_builder_header_title)) {
                ?>
                <h1 data-text-effect class="heading8">
                    <?php echo esc_html($onepage_builder_header_title); ?>
                </h1>
                <?php
            }

            if (!empty($onepage_builder_header_subtitle)) {
                ?>
                <p data-text-effect class="header-subtitle"> <?php echo esc_html($onepage_builder_header_subtitle); ?></p>
                <?php
            }
        }
        ?>

        <a class="button" href="<?php echo esc_attr($onepage_builder_header_btn_1_url); ?>"><?php echo esc_html($onepage_builder_header_btn_1_title); ?></a>
        <a class="white_button" href="<?php echo esc_attr($onepage_builder_header_btn_2_url); ?>"><?php echo esc_html($onepage_builder_header_btn_2_title); ?></a>

    </div>
    <div class="header-description-left">
    </div>
</div>
