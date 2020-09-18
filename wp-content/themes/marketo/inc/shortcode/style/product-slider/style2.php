
<div class="product-block-slider owl-carousel">
    <?php
    $xs_allproduct = $settings['xs_allproduct'];
    foreach($xs_allproduct as $xs_product):
        $args['post_in'] = $xs_product['xs_product'];
        $post_id = $xs_product['xs_product'];
        $args['posts_per_page'] = 1;
        $show_product_img = $xs_product['show_product_image'];
        $img_link = $xs_product['image']['url'];
        $xs_query = new \WP_Query( $args );
        if($xs_query->have_posts()):
            while ($xs_query->have_posts()) :
                $xs_query->the_post();
                $xs_product = wc_get_product($xs_product['xs_product']);
                ?>
                <div class="item">
                    <?php
                    if($show_product_img):
                        $img = wp_get_attachment_image_src(get_post_thumbnail_id($post_id),'full');
                        $img_link = $img[0];
                        ?>
                        <img src="<?php echo esc_url($img_link); ?>" alt="<?php the_title_attribute(); ?>">
                    <?php else: ?>
                        <img src="<?php echo esc_url($img_link); ?>" alt="<?php the_title_attribute(); ?>">
                    <?php endif; ?>
                </div>
            <?php
            endwhile;
        endif;
    endforeach;
    wp_reset_postdata();
    ?>
</div>