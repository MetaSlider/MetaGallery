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

if (!class_exists('ExtendifyMetaGallery')) :
final class ExtendifyMetaGallery
{
    public static $loaded = false;

    public function __invoke()
    {
        // TODO: Maybe load an "upgrade your PHP" page instead?
        if (version_compare(PHP_VERSION, '7.3.0', '<')) {
            return;
        }
        if (!self::$loaded) {
            self::$loaded = true;
            require dirname(__FILE__) . '/bootstrap.php';
            new Extendify\MetaGallery\App;
            if (!defined('METAGALLERY_BASE_URL')) {
                define('METAGALLERY_BASE_URL', plugin_dir_url(Extendify\MetaGallery\App::$textDomain));
            }
        }
    }
}

endif;

(new ExtendifyMetaGallery)();
