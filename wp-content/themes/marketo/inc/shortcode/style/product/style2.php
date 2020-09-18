<div class="row no-gutters product-block-category">
    <?php
    $args['posts_per_page'] = $product_count;
    if($xs_query->have_posts()):
        while ($xs_query->have_posts()) :
        $xs_query->the_post();
        $xs_product = wc_get_product(get_the_id());
        $img_link = xs_resize( get_post_thumbnail_id(), 120, 120,true );
    ?>
        <div class="col-md-3">
            <div class="xs-product-category">
                <?php if(!empty($img_link)): ?>
                <a class="xs_product_img_link" href="<?php echo esc_url(get_the_permalink()) ?>">
                    <img src="<?php echo esc_url($img_link); ?>"  alt="<?php the_title_attribute(); ?>">
                </a>
                <?php endif; ?>
                <div class="product-content">
                    <h4 class="product-title"><a href="<?php echo esc_url(get_the_permalink()) ?>"><?php echo get_the_title(); ?></a></h4>
                    <span class="price">
                      <?php echo marketo_return($xs_product-> get_price_html());?>
                    </span>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
    <?php endif; ?>
    <?php wp_reset_postdata(); ?>
</div>