<?php

namespace Extendify\MetaGallery;

/**
 * Handles loading views
 *
 * @since 0.1.0
 */
class View
{
    protected static $instance = null;
    protected $queuedView = '';
    protected $queuedData = [];

    /**
     * Will queue the view from the controller.
     *
     * @since 0.1.0
     * @param string $view  The name of the view file
     * @param string $data  The data to load with the view
     * @return void
     */
    public static function queue($view, $data = [])
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        (self::$instance)->queuedView = $view;
        (self::$instance)->queuedData = $data;
    }

    /**
     * Will return an the required view file if available
     * Example: View::shortcode()
     *
     * @since 0.1.0
     * @param string $name       The name of the view file
     * @param string $arguements On enumerated array containing the parameters passed to the $name'ed method
     * @return object
     */
    public static function admin()
    {
        if (self::$instance) {
            $data = (self::$instance)->queuedData;
            $view = (self::$instance)->queuedView;
            include METAGALLERY_PATH . "resources/views/pages/{$view}.php";
            return;
        }
        // TODO: consider this showing an error page instead
        include METAGALLERY_PATH . "resources/views/pages/start.php";
        return;
    }

    /**
     * Will return an the required view file if available
     * Example: View::shortcode()
     *
     * @since 0.1.0
     * @param string $name       The name of the view file
     * @param string $arguements On enumerated array containing the parameters passed to the $name'ed method
     * @return object
     */
    public static function __callStatic($name, $arguments)
    {
        if (file_exists($view = METAGALLERY_PATH . "resources/views/{$name}.php")) {
            include $view;
        }
    }
}
