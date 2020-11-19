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

    protected $parent = '';

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
        }, 9999);

        \add_action('admin_enqueue_scripts', function ($hook) {
            $this->addGlobalScripts();
            if (!$this->checkAdminPageIsOurs($hook)) {
                return;
            }
            $this->addScopedScripts();
        });

        \add_action('admin_head', function () {
            $this->addGlobalInlineScripts();
            if (!$this->checkAdminPageIsOurs()) {
                return;
            }
            $this->addScopedInlineScripts();
        });
    }



    /**
     * Lets sideloading as a subpage from another plugin
     *
     * @since 0.1.0
     * @var string $page - The parent page
     * @return self
     */
    public function sideload($page)
    {
        $this->parent = $page;
        return $this;
    }


    /**
     * Adds the main admin page
     *
     * @since 0.1.0
     * @return void
     */
    public function addAdminPage()
    {
        $addPage = $this->parent ? '\add_submenu_page' : '\add_menu_page';
        $args = [
            App::$name,
            App::$name,
            App::$capability,
            App::$slug,
            '\Extendify\MetaGallery\View::admin',
        ];
        if ($this->parent) {
            array_unshift($args, $this->parent);
        }
        $addPage(...$args);
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
    public function addScopedScripts()
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

    /**
     * Adds various inline JS/CSS scripts directly to the head
     *
     * @since 0.1.0
     * @return void
     */
    public function addScopedInlineScripts()
    {
        // helper style for Alpinejs
        echo '<style>[x-cloak] { display: none; }</style>';
    }

    /**
     * Adds various JS scripts to EVERY admin page
     *
     * @since 0.1.0
     * @return void
     */
    public function addGlobalScripts()
    {
        // \wp_enqueue_script(
        //     App::$slug . '-alpine',
        //     'https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js',
        //     [],
        //     App::$version,
        //     true
        // );
    }

    /**
     * Adds various inline JS/CSS scripts directly to the head on EVERY admin page
     *
     * @since 0.1.0
     * @return void
     */
    public function addGlobalInlineScripts()
    { ?>
        <style>
            .wp-has-submenu a[href="admin.php?page=metagallery"] {
                margin-top: 10px !important;
            }
            .wp-has-submenu a[href="admin.php?page=metagallery"]::after {
                content: 'NEW';
                font-size: 10px;
                margin-left: 5px;
                color: #dfff34;
            }
        </style>
    <?php }
}
