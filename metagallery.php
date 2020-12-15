<?php
/**
 * Plugin Name: MetaGallery
 * Description: MetaMeta Gallery plugin
 * Author: Extendify
 * Text Domain: metagallery
 * Version: 0.1.0
 */

if (!defined('ABSPATH')) {
    die('No direct access.');
}

if (!class_exists('MetaGallery')) :
    // phpcs:disable
    // Squiz.Classes.ClassFileName.NoMatch
    /**
     * The MetaGallery class
     */
    final class MetaGallery
    {
        // phpcs:enable

        /**
         * Var to make sure we only load once
         *
         * @var boolean $loaded
         */
        public static $loaded = false;

        /**
         * Set up the plugin
         *
         * @return void
         */
        public function __invoke()
        {
            // TODO: Maybe load an "upgrade your PHP" page instead?
            if (version_compare(PHP_VERSION, '7.3.0', '<')) {
                return;
            }

            if (!self::$loaded) {
                self::$loaded = true;
                require dirname(__FILE__) . '/bootstrap.php';
                $app = new Extendify\MetaGallery\App();
                if (!defined('METAGALLERY_BASE_URL')) {
                    define('METAGALLERY_BASE_URL', plugin_dir_url($app::$textDomain));
                }
            }
        }
        // phpcs:ignore Squiz.Classes.ClassDeclaration.SpaceBeforeCloseBrace
    }

endif;

$metagallery = new ExtendifyMetaGallery();
$metagallery();
