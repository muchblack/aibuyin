<?php
defined( 'ABSPATH') || exit;
?>
<div class="wslu-social-login-main-wrapper">
	<?php
	require_once( WSLU_LOGIN_PLUGIN . '/template/admin/counter/tab-menu.php');
	if($message_provider == 'show'){?>
        <div class="admin-page-framework-admin-notice-animation-container">
            <div id="XS_Social_Login_Settings" 
                 class="updated admin-page-framework-settings-notice-message admin-page-framework-settings-notice-container notice is-dismissible" 
                 style="margin: 1em 0; visibility: visible; opacity: 1;">
                <p><?php echo esc_html__('Styles data have been updated.', 'wp-social');?></p>
                <button type="button" class="notice-dismiss"><span class="screen-reader-text"><?php echo esc_html__('Dismiss this notice.', 'wp-social');?></span></button>
            </div>
        </div>
	<?php }?>

    <form action="<?php echo esc_url(admin_url().'admin.php?page=wslu_counter_setting&tab=wslu_style_setting');?>" name="xs_style_submit_form" method="post" id="xs_style_form">
        <div class="xs-social-block-wraper">
            <div class="xs-global-section">


                <div class="wslu-single-item">

	                <?php if(isset($share_hover_effects)) : ?>
                        <div class="wslu-left-label">
                            <label class="wslu-sec-title" for=""><?php echo esc_html__('Select Hover Effects', 'wp-social'); ?></label>
                        </div>

                        <div class="wslu-right-content wlsu-hover-effect-select-wrapper">
                            <select class="wlsu-hover-effect-select" name="xs_style[hover_effect]">
				                <?php foreach ($share_hover_effects as $key => $value) : ?>
                                    <option <?php echo (isset($value['exclude'])) ? 'data-exclude="' . esc_attr(json_encode($value['exclude'])) . '"' : ''  ?> value="<?php echo esc_attr($key); ?>" <?php echo ($selectedEffect == $key) ? 'selected' : ''; ?>><?php echo esc_html($value['name']); ?></option>
				                <?php endforeach; ?>
                            </select>
                        </div>
	                <?php endif; ?>
                    
                </div>
                

                <div class="wslu-social-style-data">

					<?php foreach($styleArr AS $styleKey => $styleValue): ?>

                        <div class="wslu-single-social-style-item <?php echo esc_attr( ( (!did_action('wslu_social_pro/plugin_loaded')) && ($styleValue['package'] == 'pro') ) ? 'wslu-style-pro': 'wslu-style-free' ); ?>">

                            <label for="_login_button_style__<?= $styleKey;?>" class="social_radio_button_label xs_label_wp_login">

                                <input class="social_radio_button wslu-global-radio-input"
                                        type="radio"
                                        id="_login_button_style__<?= $styleKey;?>"
                                        name="xs_style[login_button_style]"
                                        value="<?= $styleKey;?>"
                                    <?php echo esc_attr( ( (!did_action('wslu_social_pro/plugin_loaded')) && ($styleValue['package'] == 'pro') ) ? 'disabled="disabled"': '' ); ?>
                                    <?php echo ($selectedStyle == $styleKey) ? 'checked' : ''; ?> >

                                <?php 
                                    echo esc_html__($styleValue['name'], 'wp-social');
                                    echo (!did_action('wslu_social_pro/plugin_loaded')) && ($styleValue['package'] == 'pro') ? '<span class="wslu-go-pro-text">(' . esc_html('Pro Only', 'elementskit') . ')</span>' : '';
                                ?>

                                <div class="wslu-style-img xs-login-<?= $styleKey;?> <?php echo (isset($return_data['login_button_style']) && $return_data['login_button_style'] == $styleKey ) ? 'style-active ' : '';?>">

                                    <img src="<?php echo esc_url(WSLU_LOGIN_PLUGIN_URL.'assets/images/screenshort/counter/'.$styleValue['design'].'.png'); ?>" alt="<?= $styleValue['name']; ?>">

                                </div>

                            </label>
                        </div>
					<?php endforeach; ?>

                </div>

                <div class="wslu-social-style-hidden-inputs">
                    <label>
                        <input type="text" class="wslu-main-content-input" name="xs_style[login_button_style][style]" value="<?php echo (isset($return_data['login_button_style']['style']) ? $return_data['login_button_style']['style'] : ''); ?>">
						<!-- ?php esc_html_e('Main Content', 'wp-social'); ?-->
                    </label>
                </div>
            
                <div class="wslu-right-content wslu-right-content--share">
                    <button type="submit" name="style_setting_submit_form" class="xs-btn btn-special small"><?php echo esc_html__('Save Changes');?></button>
                </div>

            </div>
        </div>
        <div class="xs-backdrop"></div>
    </form>
</div>