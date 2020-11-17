<?php
/*
*	Plugin Name: MetaGallery
*	Description: MetaMeta Gallery plugin
*	Author: Extendify
*	Text Domain: metagallery
*	Version: 0.1.0
*/
if (!defined('ABSPATH')) {
    die('No direct access.');
}

define('METAGALLERY_TEXTDOMAIN', 'metagallery');
define('METAGALLERY_PAGE_NAME', 'metagallery');
define('METAGALLERY_PATH', plugin_dir_path(__FILE__));

require plugin_dir_path(__FILE__) . 'vendor/autoload.php';
require plugin_dir_path(__FILE__) . 'routes/api.php';
require plugin_dir_path(__FILE__) . 'routes/admin.php';
// require plugin_dir_path(__FILE__) . 'routes/console.php';

new Extendify\MetaGallery\App;
// new Extendify\MetaGallery\Shortcode;
