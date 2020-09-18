<?php
defined( 'ABSPATH') || exit;
?>
<div class="wslu-social-login-main-wrapper">
    <?php
    require_once(WSLU_LOGIN_PLUGIN . '/template/admin/share/tab-menu.php');
    if ($message_provider == 'show') { ?>
        <div class="admin-page-framework-admin-notice-animation-container">
            <div 0="XS_Social_Login_Settings" id="XS_Social_Login_Settings" class="updated admin-page-framework-settings-notice-message admin-page-framework-settings-notice-container notice is-dismissible" style="margin: 1em 0px; visibility: visible; opacity: 1;">
                <p><?php echo esc_html__('Styles data have been updated.', 'wp-social'); ?></p>
                <button type="button" class="notice-dismiss"><span class="screen-reader-text"><?php echo esc_html__('Dismiss this notice.', 'wp-social'); ?></span></button>
            </div>
        </div>
    <?php } ?>

    <form class="wslu-share-styles-form" data-action="<?php echo esc_url(admin_url() . 'admin.php?page=wslu_share_setting&tab=wslu_style_setting'); ?>" action="<?php echo esc_url(admin_url() . 'admin.php?page=wslu_share_setting&tab=wslu_style_setting'); ?>" name="xs_style_submit_form" method="post" id="xs_style_form">
        <div class="xs-social-block-wraper">
            <div class="xs-global-section">

                <ul class="wslu-display-type-container">
                    <li>
                        <a href="#primary_content" data-id="primary_content">
                            <?php echo esc_html__('Primary Content', 'wp-social'); ?>
                            <span><?php esc_html_e('Choose default method that will be used to render buttons inside content.', 'wp-social'); ?></span>
                        </a>
                    </li>
                    <li>
                        <a href="#fixed_display" data-id="fixed_display">
                            <?php echo esc_html__('Fixed Display ', 'wp-social'); ?>
                            <span><?php esc_html_e('Choose default method that will be used to render buttons inside content.', 'wp-social'); ?></span>
                        </a>
                    </li>
                </ul>

                
                
                <div class="wslu-display-content">
                    <div class="wslu-single-item" id="wslu-primary_content">

                        <div class="wslu-single-item wlsu-primary-content-inner">
                            <div class="wslu-left-label">
                                <label class="wslu-sec-title" for=""><?php echo esc_html__('Primary Content', 'wp-social'); ?></label>
                            </div>

                            <div class="wslu-right-content">

                                <label for="_login_button_style__after_content" class="social_radio_button_label xs_label_wp_login">
                                    <input class="social_radio_button wslu-global-radio-input" type="radio" id="_login_button_style__after_content" name="xs_style[login_content]" value="after_content" <?php echo (isset($return_data['login_content']) && $return_data['login_content'] == 'after_content') ? 'checked' : ''; ?>>

                                    <?php echo esc_html__('After Content ', 'wp-social'); ?>
                                </label>


                                <label for="_login_button_style__before_content" class="social_radio_button_label xs_label_wp_login">
                                    <input class="social_radio_button wslu-global-radio-input" type="radio" id="_login_button_style__before_content" name="xs_style[login_content]" value="before_content" <?php echo (isset($return_data['login_content']) && $return_data['login_content'] == 'before_content') ? 'checked' : ''; ?>>

                                    <?php echo esc_html__('Before Content ', 'wp-social'); ?>
                                </label>

                                <label for="_login_button_style__login_content1" class="social_radio_button_label xs_label_wp_login">
                                    <input class="social_radio_button wslu-global-radio-input" type="radio" id="_login_button_style__login_content1" name="xs_style[login_content]" value="no_content" <?php echo (empty($return_data['login_content']) || $return_data['login_content'] == 'no_content') ? 'checked' : ''; ?>>

                                    <?php echo esc_html__('Disable ', 'wp-social'); ?>
                                </label>

                            </div>
                        </div>
                        
                        <!-- show count -->
                        <div class="wslu-single-item">

                            <div class="wslu-left-label">
                                <label class="wslu-sec-title" for=""><?php echo esc_html__('Show total count', 'wp-social'); ?></label>
                            </div>

                            <div class="wslu-right-content">

                                <label class="social_radio_button_label xs_label_wp_login">
                                    <input class="social_radio_button wslu-global-radio-input" type="radio" name="xs_style[main_content][show_social_count_share]" value="1" <?php echo (!empty($return_data['main_content']['show_social_count_share'])) ? 'checked' : ''; ?>>

                                    <?php echo esc_html__('Yes', 'wp-social'); ?>
                                </label>

                                <label class="social_radio_button_label xs_label_wp_login">
                                    <input class="social_radio_button wslu-global-radio-input" type="radio" name="xs_style[main_content][show_social_count_share]" value="0" <?php echo (empty($return_data['main_content']['show_social_count_share'])) ? 'checked' : ''; ?>>

                                    <?php echo esc_html__('No', 'wp-social'); ?>
                                </label>
                            </div>
                        </div>

                    </div> <!-- ./ End Single Item -->



                    <div class="wslu-single-item" id="wslu-fixed_display">

                        <div class="wslu-single-item wlsu-primary-content-inner">
                            <div class="wslu-left-label">
                                <label class="wslu-sec-title" for=""><?php echo esc_html__('Fixed Display', 'wp-social'); ?></label>
                            </div>

                            <div class="wslu-right-content">

                                <label for="_login_button_style__left_content" class="social_radio_button_label xs_label_wp_login">
                                    <input class="social_radio_button wslu-global-radio-input" type="radio" id="_login_button_style__left_content" name="xs_style[login_button_content]" value="left_content" <?php echo (isset($return_data['login_button_content']) && $return_data['login_button_content'] == 'left_content') ? 'checked' : ''; ?>>

                                    <?php echo esc_html__('Left Floating ', 'wp-social'); ?>
                                </label>



                                <label for="_login_button_style__right_content" class="social_radio_button_label xs_label_wp_login">

                                    <input class="social_radio_button wslu-global-radio-input" type="radio" id="_login_button_style__right_content" name="xs_style[login_button_content]" value="right_content" <?php echo (isset($return_data['login_button_content']) && $return_data['login_button_content'] == 'right_content') ? 'checked' : ''; ?>>

                                    <?php echo esc_html__('Right Floating ', 'wp-social'); ?>
                                </label>


                                <label for="_login_button_style__top_content" class="social_radio_button_label xs_label_wp_login">
                                    <input class="social_radio_button wslu-global-radio-input" type="radio" id="_login_button_style__top_content" name="xs_style[login_button_content]" value="top_content" <?php echo (isset($return_data['login_button_content']) && $return_data['login_button_content'] == 'top_content') ? 'checked' : ''; ?>>

                                    <?php echo esc_html__('Top Inline ', 'wp-social'); ?>
                                </label>


                                <label for="_login_button_style__bottom_content" class="social_radio_button_label xs_label_wp_login">
                                    <input class="social_radio_button wslu-global-radio-input" type="radio" id="_login_button_style__bottom_content" name="xs_style[login_button_content]" value="bottom_content" <?php echo (isset($return_data['login_button_content']) && $return_data['login_button_content'] == 'bottom_content') ? 'checked' : ''; ?>>

                                    <?php echo esc_html__('Bottom Inline ', 'wp-social'); ?>
                                </label>


                                <label for="_login_button_style__login_content" class="social_radio_button_label xs_label_wp_login">

                                    <input class="social_radio_button wslu-global-radio-input" type="radio" id="_login_button_style__login_content" name="xs_style[login_button_content]" value="no_content" <?php echo (empty($return_data['login_button_content']) || $return_data['login_button_content'] == 'no_content') ? 'checked' : ''; ?>>

                                    <?php echo esc_html__('Disable ', 'wp-social'); ?>

                                </label>

                            </div>
                        </div>

                        <!-- Show count -->
                        <div class="wslu-single-item">

                            <div class="wslu-left-label">
                                <label class="wslu-sec-title" for=""><?php echo esc_html__('Show total count', 'wp-social'); ?></label>
                            </div>

                            <div class="wslu-right-content">

                                <label class="social_radio_button_label xs_label_wp_login">
                                    <input class="social_radio_button wslu-global-radio-input" type="radio" name="xs_style[fixed_display][show_social_count_share]" value="1" <?php echo (!empty($return_data['fixed_display']['show_social_count_share'])) ? 'checked' : ''; ?>>

                                    <?php echo esc_html__('Yes', 'wp-social'); ?>
                                </label>

                                <label class="social_radio_button_label xs_label_wp_login">
                                    <input class="social_radio_button wslu-global-radio-input" type="radio" name="xs_style[fixed_display][show_social_count_share]" value="0" <?php echo (empty($return_data['fixed_display']['show_social_count_share'])) ? 'checked' : ''; ?>>

                                    <?php echo esc_html__('No', 'wp-social'); ?>
                                </label>
                            </div>
                        </div>

                    </div> <!-- ./ End Single Item -->


                </div>

                 <!-- Layout -->
                <div class="wslu-single-item wslu-share-layout">
                    <div class="wslu-left-label">
                        <label class="wslu-sec-title" for=""><?php echo esc_html__('Layout', 'wp-social'); ?></label>
                    </div>

                    <div class="wslu-right-content">
                        <label class="social_radio_button_label xs_label_wp_login">
                            <input class="social_radio_button wslu-global-radio-input" type="radio" name="xs_style[layout]" value="horizontal">

                            <?php echo esc_html__('Horizontal', 'wp-social'); ?>
                        </label>

                        <label class="social_radio_button_label xs_label_wp_login">
                            <input class="social_radio_button wslu-global-radio-input" type="radio" name="xs_style[layout]" value="vertical">

                            <?php echo esc_html__('Vertical', 'wp-social'); ?>
                        </label>
                    </div>
                </div> <!-- ./ End Single Item -->

                 <!-- Hover Count -->
                 <?php if (isset($share_hover_effects)) : ?>
                    <div class="wslu-single-item">
                        <div class="wslu-left-label">
                            <label class="wslu-sec-title" for=""><?php echo esc_html__('Select Hover Effects', 'wp-social'); ?></label>
                        </div>

                        <div class="wslu-right-content wlsu-hover-effect-select-wrapper">
                            <select class="wlsu-hover-effect-select" name="xs_style[hover_effect]">
                                <?php foreach ($share_hover_effects as $key => $value) : ?>
                                    <option <?php echo (isset($value['exclude'])) ? 'data-exclude="' . esc_attr(json_encode($value['exclude'])) . '"' : ''  ?> value="<?php echo esc_attr($key); ?>" <?php echo ($mainEffect == $key) ? 'selected' : ''; ?>><?php echo esc_html($value['name']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div> <!-- ./ End Single Item -->
                <?php endif; ?>

                <div class="wslu-social-style-data">

                    <?php
                    foreach ($styleArr as $k => $v) : ?>

                        <div class="wslu-single-social-style-item <?php echo esc_attr( ( (!did_action('wslu_social_pro/plugin_loaded')) && ($v['package'] == 'pro') ) ? 'wslu-style-pro': 'wslu-style-free' ); ?>">

                            <label  class="social_radio_button_label xs_label_wp_login">
                                    
                                <input class="social_radio_button  wslu-global-radio-input" type="radio" id="_login_button_style__<?= $k; ?>" name="xs_style[login_button_style][main]" value="<?= $k; ?>" <?php echo esc_attr( ( (!did_action('wslu_social_pro/plugin_loaded')) && ($v['package'] == 'pro') ) ? 'disabled="disabled"': '' ); ?>>
                                <?php 
                                    echo esc_html__($v['name'], 'wp-social');
                                    echo (!did_action('wslu_social_pro/plugin_loaded')) && ($v['package'] == 'pro') ? '<span class="wslu-go-pro-text">(' . esc_html('Pro Only', 'elementskit') . ')</span>' : '';
                                ?>
                                
                                <div class="wslu-style-img xs-login-<?= $k; ?> <?php echo (isset($return_data['login_button_style']) && $return_data['login_button_style'] == $k) ? 'style-active ' : ''; ?>">
                                    <img class="wslu-style-img-h" src="<?php echo esc_url(WSLU_LOGIN_PLUGIN_URL . 'assets/images/screenshort/share/' . $v['design'] . '.png'); ?>" alt="<?php echo $k; ?>">
                                    <img class="wslu-style-img-v" src="<?php echo esc_url(WSLU_LOGIN_PLUGIN_URL . 'assets/images/screenshort/share/' . $v['design'].'-v' . '.png'); ?>" alt="<?php echo $k; ?>">
                                </div>
                                <?php
                                    $effect = isset($v['effect']) ? $v['effect'] : [];
                                    if (!empty($effect)) {
                                        foreach ($effect as $kk => $vv) :
                                            ?>
                                        <label for="wslu-effect-<?= $k; ?>-<?= $kk; ?>">
                                            <input class="social_radio_button  wslu-global-radio-input" type="radio" id="wslu-effect-<?= $k; ?>-<?= $kk; ?>" value="<?= $kk; ?>" <?php echo (isset($return_data['login_button_style']['effect']) && $return_data['login_button_style']['effect'] == $kk) ? 'checked' : ''; ?>>
                                            <?php echo esc_html__($vv['name'], 'wp-social') ?>
                                        </label>
                                <?php
                                        endforeach;
                                    }
                                    ?> 
                            </label>
                            
                        </div>
                    <?php
                    endforeach; ?>
                </div>

                <div class="wslu-social-style-hidden-inputs">
                    <label>
                        <input type="text" class="wslu-main-content-input" name="xs_style[main_content][style]" value="<?php echo $return_data['main_content']['style']; ?>">
                        <?php esc_html_e('Main Content', 'wp-social'); ?>
                    </label>
                    <label>
                        <input type="text" class="wslu-fixed-display-input" name="xs_style[fixed_display][style]" value="<?php echo $return_data['fixed_display']['style']; ?>">
                        <?php esc_html_e('Fixed Display', 'wp-social'); ?>
                    </label>
                </div>

                <div class="wslu-right-content wslu-right-content--share">
                    <button type="submit" name="style_setting_submit_form" class="xs-btn btn-special small"><?php echo esc_html__('Save Changes'); ?></button>
                </div>

            </div>
        </div>
        <div class="xs-backdrop"></div>
    </form>
</div>