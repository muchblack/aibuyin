<div class="recent-view-slider owl-carousel">
    <?php
    if ($xs_query->have_posts()):
        while ($xs_query->have_posts()) :
            $xs_query->the_post();
            $xs_product = wc_get_product(get_the_id());
            $img_link = xs_resize(get_post_thumbnail_id(), 185, 200, true);
            ?>
            <div class="item">
                <a href="<?php echo esc_url(get_the_permalink()); ?>">
                    <img src="<?php echo esc_url($img_link); ?>" alt="<?php the_title_attribute(); ?>">
                </a>
            </div>
            <?php
        endwhile;
    endif;
    wp_reset_postdata();
    ?>
</div>