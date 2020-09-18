<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
// Include user custom function
require(WSLU_LOGIN_PLUGIN.'/inc/admin-custom-function.php');

require(WSLU_LOGIN_PLUGIN . '/keys.php');
require(WSLU_LOGIN_PLUGIN . '/traits/Singleton.php');
require(WSLU_LOGIN_PLUGIN . '/xs_migration/MigrationContract.php');
require(WSLU_LOGIN_PLUGIN . '/xs_migration/DataMigration.php');
require(WSLU_LOGIN_PLUGIN . '/xs_migration/Migration.php');

require(WSLU_LOGIN_PLUGIN.'/inc/admin-setting.php');

require(WSLU_LOGIN_PLUGIN.'/inc/admin-social-button.php');

require(WSLU_LOGIN_PLUGIN.'/inc/admin-social-enque-script.php');

require(WSLU_LOGIN_PLUGIN.'/inc/admin-create-widget.php');

require(WSLU_LOGIN_PLUGIN.'/inc/admin-create-shortcode.php');

require(WSLU_LOGIN_PLUGIN.'/inc/admin-rest-api.php');
require(WSLU_LOGIN_PLUGIN.'/inc/share.php');
require(WSLU_LOGIN_PLUGIN.'/inc/share-widget.php');

require(WSLU_LOGIN_PLUGIN.'lib/counter/counters-api.php');
require(WSLU_LOGIN_PLUGIN.'/inc/counter.php');
require(WSLU_LOGIN_PLUGIN.'/inc/counter-widget.php');

// elementor plugin
require(WSLU_LOGIN_PLUGIN.'/inc/elementor/elements.php');

require(WSLU_LOGIN_PLUGIN.'lib/vendor/autoload.php');

// Login functionality

require(WSLU_LOGIN_PLUGIN.'/inc/login.php');
require(WSLU_LOGIN_PLUGIN.'/app/Avatar.php');