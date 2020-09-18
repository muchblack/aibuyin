<a href="<?php echo esc_url($banner_link); ?>" class="xs-organic-product-widget media">
    <?php if(isset($image['url']) && !empty($image['url'])): ?>
        <div class="d-flex product-thumb">
            <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($alt); ?>">
        </div>
    <?php endif; ?>
    <div class="media-body organic-widget-content">
        <h4><?php echo esc_html($title); ?></h4>
        <h5><?php echo wp_kses_post($sub_title); ?></h5>
        <p><?php echo wp_kses_post($sub_desc); ?> </p>
    </div>
</a>