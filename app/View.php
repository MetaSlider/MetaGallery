<?php
/**
 * View handler for base pages
 */

namespace Extendify\MetaGallery;

/**
 * Handles loading views
 *
 * @since 0.1.0
 */
class View
{

    /**
     * The instance
     *
     * @var $instance
     */
    protected static $instance = null;

    /**
     * The View that will be shown
     *
     * @var $queuedView
     */
    protected $queuedView = '';

    /**
     * The Layout that will be shown
     *
     * @var $queuedLayout
     */
    protected $queuedLayout = '';

    /**
     * The Data that will go with the view
     *
     * @var $queuedData
     */
    protected $queuedData = [];


    /**
     * Will queue the view from the controller.
     *
     * @since 0.1.0
     * @param string $view   The name of the view file.
     * @param string $layout The name of the layout file.
     * @param array  $data   The data to load with the view.
     * @return void
     */
    public static function queue($view, $layout = 'main', $data = [])
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }

        (self::$instance)->queuedView = $view;
        (self::$instance)->queuedLayout = $layout;
        (self::$instance)->queuedData = $data;
    }

    /**
     * Will return an the required view file if available
     * Example: View::shortcode()
     *
     * @since 0.1.0
     *
     * @return void
     */
    public static function admin()
    {
        if (self::$instance) {
            // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.FoundAfterLastUsed
            $data = (self::$instance)->queuedData;
            // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.FoundAfterLastUsed
            $view = (self::$instance)->queuedView;
            $layout = (self::$instance)->queuedLayout;

            include METAGALLERY_PATH . "resources/views/layouts/{$layout}.php";
            return;
        }

        // TODO: consider this showing an error page instead.
        include METAGALLERY_PATH . 'resources/views/pages/start.php';
    }

    // phpcs:disable
    // - Unused $arguments
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
        // phpcs:enable
        $view = METAGALLERY_PATH . "resources/views/{$name}.php";
        if (file_exists($view)) {
            include $view;
        }
    }
}
