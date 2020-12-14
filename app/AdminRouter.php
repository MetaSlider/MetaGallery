<?php
/**
 * Admin page router.
 */

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

    /**
     * The instance.
     *
     * @var $instance
     */
    protected static $instance = null;

    /**
     * The parent page
     *
     * @var $parent
     */
    protected $parent = '';

    /**
     * The routes
     *
     * @var $routes
     */
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

    /**
     * The get handler.
     *
     * @param string $namespace - The namespace.
     * @param string $endpoint  - The route endpoint.
     * @param mixed  $callback  - The callback function.
     *
     * @return void
     */
    public function getHandler(string $namespace, string $endpoint, $callback)
    {
        // Convert Object::class to [Object::class, ''] to match [Object, method].
        if (is_string($callback)) {
            $callback = [
                $callback,
                '',
            ];
        }

        $this->routes[$endpoint . $namespace] = $callback;
    }

    /**
     * The route handler.
     *
     * @return void
     */
    public function registerHandler()
    {
        if (!$this->checkAdminPageIsOurs()) {
            return;
        }

        // phpcs:ignore WordPress.Security.NonceVerification.Recommended
        if (!isset($_GET['route'])) {
            \wp_safe_redirect(\admin_url('admin.php?page=' . METAGALLERY_PAGE_NAME . '&route=archive'));
            exit;
        }

        // phpcs:ignore WordPress.Security.NonceVerification.Recommended
        $callback = $this->routes[sanitize_text_field(wp_unslash($_GET['route']))];
        if ($callback) {
            if (is_array($callback) && class_exists($callback[0])) {
                $class = new $callback[0]();
                if (method_exists($class, $callback[1])) {
                    return call_user_func([$class, $callback[1]]);
                }
            }
        }

        // Default to archive page.
        \wp_safe_redirect(
            \admin_url('admin.php?page=' . METAGALLERY_PAGE_NAME . '&route=archive')
        );
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
        \add_action(
            'admin_menu',
            function () {
                $this->addAdminPage();
            },
            9999
        );

        \add_action(
            'admin_enqueue_scripts',
            function ($hook) {
                $this->addGlobalScriptsAndStyles();
                if (!$this->checkAdminPageIsOurs($hook)) {
                    return;
                }

                $this->addScopedScriptsAndStyles();
            }
        );

        \add_action(
            'admin_head',
            function () {
                $this->addGlobalInlineScripts();
                if (!$this->checkAdminPageIsOurs()) {
                    return;
                }

                $this->addScopedInlineScripts();
            }
        );
    }

    /**
     * Lets sideloading as a subpage from another plugin
     *
     * @since 0.1.0
     * @param string $page - The parent page.
     *
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
     * @param string $hook - An optional hook provided by WP to identify the page.
     * @return boolean
     */
    public function checkAdminPageIsOurs($hook = '')
    {
        if ($hook) {
            return ('toplevel_page_' . App::$slug === $hook);
        }

        // phpcs:ignore WordPress.Security.NonceVerification.Recommended
        return isset($_GET['page']) && (sanitize_text_field(wp_unslash($_GET['page'])) === METAGALLERY_PAGE_NAME);
    }

    /**
     * Adds various JS scripts
     *
     * @since 0.1.0
     * @return void
     */
    public function addScopedScriptsAndStyles()
    {
        \wp_register_script(
            App::$slug . '-scripts',
            METAGALLERY_BASE_URL . 'public/build/metagallery.js',
            [],
            App::$version,
            true
        );
        \wp_localize_script(
            App::$slug . '-scripts',
            App::$slug . 'Data',
            [
                'root' => esc_url_raw(rest_url(APP::$slug . '/' . APP::$apiVersion)),
                'nonce' => wp_create_nonce('wp_rest'),
            ]
        );
        \wp_enqueue_script(App::$slug . '-scripts');
        \wp_enqueue_style(
            App::$slug . '-theme',
            METAGALLERY_BASE_URL . 'public/build/theme.css',
            [],
            App::$version,
            'all'
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
        // helper style for Alpinejs.
        echo '<style>[x-cloak] { display: none!important; }</style>';
    }

    /**
     * Adds various JS scripts to EVERY admin page
     *
     * @since 0.1.0
     * @return void
     */
    public function addGlobalScriptsAndStyles()
    {
        // phpcs:disable
        // \wp_enqueue_script(
        //     App::$slug . '-alpine',
        //     'https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js',
        //     [],
        //     App::$version,
        //     true
        // );
        // phpcs:enable
    }

    /**
     * Adds various inline JS/CSS scripts directly to the head on EVERY admin page
     *
     * @since 0.1.0
     * @return void
     */
    public function addGlobalInlineScripts()
    {
        ?>
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
        <?php
    }
}
