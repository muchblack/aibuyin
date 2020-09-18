<?php

defined( 'ABSPATH') || exit;

if(is_array($counter_provider) && !empty($counter_provider) && $styles[$shareStyleKey]['class'] != 'wslu-go-pro') : ?>

    <div class="xs_social_share_widget xs_share_url <?php echo esc_attr($customClass).' ';?>
<?php echo esc_attr($fixed_display).' ';?>
<?php echo esc_attr($widget_style); ?>">

		<?php if($showCountMarkup): ?>

            <div class="wslu-share-count">
                <span class="wslu-share-count--total"><?php echo xs_format_num($totalSCount);?></span>
                <span class="wslu-share-count--text"><?php esc_html_e('Shares', 'wp-social') ?></span>
            </div>

		<?php endif; ?>

        <ul>
			<?php
			$content = isset($styles[$shareStyleKey]['content']) ? $styles[$shareStyleKey]['content'] : '';

			foreach($provider as $key) {

				if(!empty($counter_provider[$key]['enable'])) {

					$label  = isset($counter_provider[$key]['data']['label']) ? $counter_provider[$key]['data']['label'] : '';
					$def    = isset($counter_provider[$key]['data']['value']) ? (int) $counter_provider[$key]['data']['value'] : 0;
					$text   = isset($counter_provider[$key]['data']['text']) ? $counter_provider[$key]['data']['text'] : '';

					$counter = isset($post_meta[0][$key]) ? $post_meta[0][$key] : 1;
					$counter = ($def) > $counter ? $def : $counter;

					$id     = isset($counter_provider[$key]['id']) ? $counter_provider[$key]['id'] : '';
					$type   = isset($counter_provider[$key]['type']) ? $counter_provider[$key]['type'] : '';
					$getUrl = isset($core_provider[$key]['url']) ? $core_provider[$key]['url'] : '';
					$pData  = isset($core_provider[$key]['params']) ? $core_provider[$key]['params'] : [];

					$urlCon = array_combine(
						array_keys($pData),
						array_map( function($v) {
							global $currentUrl, $title, $author, $details, $source, $media, $app_id;
							return str_replace(['[%url%]', '[%title%]', '[%author%]', '[%details%]', '[%source%]', '[%media%]', '[%app_id%]'], [$currentUrl, $title, $author, $details, $source, $media, $app_id], $v);
						}, $pData)
					);

					$params = http_build_query($urlCon, '&');

					?>
                    <li class="xs-share-li
                        <?php echo $key; ?>
                        <?php echo $content != '' ? 'wslu-extra-data' : 'wslu-no-extra-data'; ?>" >
                        <a href="javascript:void();" id="xs_feed_<?php echo $key?>" onclick="xs_feed_share(this);" data-xs-href="<?php echo $getUrl.'?'.$params;?>">

                            <div class="xs-social-icon">
                                <span class="met-social met-social-<?php echo $key;?>"></span>
                            </div>

							<?php if($content != '') : ?>
                                <div class="wslu-both-counter-text ">

									<?php if(!empty($content['number'])) : ?>
                                        <div class="xs-social-follower">
											<?php echo xs_format_num($counter);?>
                                        </div>
									<?php endif; ?>

									<?php if(!empty($content['text'])) : ?>
                                        <div class="xs-social-follower-text">
											<?php echo $text;?>
                                        </div>
									<?php endif; ?>

									<?php if(!empty($content['label'])) : ?>
                                        <div class="xs-social-follower-label">
											<?php echo $label;?>
                                        </div>
									<?php endif; ?>
                                </div>
							<?php endif; ?>

                            <div class="wslu-hover-content">
                                <div class="xs-social-followers">
									<?php echo xs_format_num($counter);?>
                                </div>
                                <div class="xs-social-follower-text">
									<?php echo $text;?>
                                </div>
                                <div class="xs-social-follower-label">
									<?php echo $label;?>
                                </div>
                            </div>
                        </a>
                    </li>
					<?php
				}
			}

			?>
        </ul>
    </div>
<?php endif;?>

<script>
    function xs_feed_share(e){
        if(e){
            var getLink = e.getAttribute('data-xs-href');
            window.open(getLink, 'xs_feed_sharer', 'width=626,height=436');
        }
    }
</script>
