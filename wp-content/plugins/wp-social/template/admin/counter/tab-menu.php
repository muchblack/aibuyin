<?php
defined( 'ABSPATH') || exit;

$active_tab = isset($_GET["tab"]) ? $_GET["tab"] : 'wslu_counter_setting';
?>

<div class="wslu-main-header">
	<h1><span class="wslu-icon met-social met-social-cog-icon"></span><?php _e('WP Social Counter Settings', 'wp-social'); ?></h1>
</div>

<div class="wslu-nav-tab-wrapper">
	<ul>
		<li><a href="?page=wslu_counter_setting" class="nav-tab <?php if($active_tab == 'wslu_counter_setting'){echo 'nav-tab-active';} ?> "><?php _e('Counter Settings', 'wp-social'); ?></a></li>
		<li><a href="?page=wslu_counter_setting&tab=wslu_providers" class="nav-tab <?php if($active_tab == 'wslu_providers'){echo 'nav-tab-active';} ?>"><?php _e('Providers', 'wp-social'); ?></a></li>
		<li><a href="?page=wslu_counter_setting&tab=wslu_style_setting" class="nav-tab <?php if($active_tab == 'wslu_style_setting'){echo 'nav-tab-active';} ?>"><?php _e('Style Settings', 'wp-social'); ?></a></li>
	</ul>
</div>