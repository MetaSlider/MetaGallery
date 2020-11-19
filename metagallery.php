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
class ExtendifyMetaGallery
{
    public static $loaded = false;

    public function __invoke()
    {
        if (!self::$loaded) {
            self::$loaded = true;
            require dirname(__FILE__) . '/bootstrap.php';
            new Extendify\MetaGallery\App;
        }
    }
}
endif;

(new ExtendifyMetaGallery)();
