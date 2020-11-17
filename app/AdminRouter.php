<?php

namespace Extendify\MetaGallery;

use Extendify\MetaGallery\App;
use Extendify\MetaGallery\Traits\Routable;

/**
 * This file acts as a router for pages within the specific admin page.
 *
 * @since 0.1.0
 */
class AdminRouter
{
    use Routable;

    protected static $instance = null;

    public $routes = [];

    /**
     * Adds various actions to set up the page
     *
     * @since 0.1.0
     * @return void
     */

    public function __construct()
    {
        if (self::$instance) {
            return self::$instance;
        }
        self::$instance = $this;
        $this->addBasePageAndLoadScripts();
    }

    public function getHandler(string $namespace, string $endpoint, $callback)
    {
        // Convert Object::class to [Object::class, ''] to match [Object, method]
        if (is_string($callback)) {
            $callback = [$callback, ''];
        }
        $this->routes[$endpoint . $namespace] = $callback;
    }
    public function registerHandler()
    {
        if (!$this->checkAdminPageIsOurs()) {
            return;
        }
        if (!isset($_GET['route'])) {
            \wp_safe_redirect(\admin_url('admin.php?page='.METAGALLERY_PAGE_NAME.'&route=archive'));
            exit;
        }

        if ($callback = $this->routes[$_GET['route']]) {
            if (is_array($callback) && class_exists($callback[0])) {
                $class = new $callback[0];
                if (method_exists($class, $callback[1])) {
                    return call_user_func([$class, $callback[1]]);
                }
            }
        }

        // Default to archive page
        \wp_safe_redirect(\admin_url('admin.php?page='.METAGALLERY_PAGE_NAME.'&route=archive'));
        exit;
    }

    /**
     * Adds the main admin page
     *
     * @since 0.1.0
     * @return void
     */
    public function addBasePageAndLoadScripts()
    {
        \add_action('admin_menu', function () {
            $this->addAdminPage();
        });
        \add_action('admin_enqueue_scripts', function ($hook) {
            if (!$this->checkAdminPageIsOurs($hook)) {
                return;
            }
            $this->addScripts();
        });
        \add_action('admin_head', function () {
            if (!$this->checkAdminPageIsOurs()) {
                return;
            }
            // helper style for Alpinejs
            echo '<style>[x-cloak] { display: none; }</style>';
        });
    }

    /**
     * Adds the main admin page
     *
     * @since 0.1.0
     * @return void
     */
    public function addAdminPage()
    {
        \add_menu_page(
            App::$name,
            App::$name,
            App::$capability,
            App::$slug,
            '\Extendify\MetaGallery\View::admin',
            'dashicons-clipboard',
            99
        );
    }

    /**
     * Makes sure we are on the correct page
     *
     * @since 0.1.0
     * @var string $hook - An optional hook provided by WP to identify the page
     * @return void
     */
    public function checkAdminPageIsOurs($hook = '')
    {
        if ($hook) {
            return ('toplevel_page_' . App::$slug === $hook);
        }
        return isset($_GET['page']) && ($_GET['page'] === METAGALLERY_PAGE_NAME);
    }

    /**
     * Adds various JS scripts
     *
     * @since 0.1.0
     * @return void
     */
    public function addScripts()
    {
        \wp_enqueue_script(
            App::$slug . '-axios',
            'https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js',
            [],
            App::$version,
            true
        );
        \wp_enqueue_script(
            App::$slug . '-alpine',
            'https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js',
            [],
            App::$version,
            true
        );
    }
}
