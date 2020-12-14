<?php
/**
 * Trait for making something routable
 */

namespace Extendify\MetaGallery\Traits;

if (!defined('ABSPATH')) {
    die('No direct access.');
}

/**
 * Abstract route class
 *
 * @since 0.1.0
 */
trait Routable
{

    /**
     * The class instance.
     *
     * @var $instance
     */
    protected static $instance = null;


    /**
     * The handler for get requests
     *
     * @param string $namespace - The namespace.
     * @param string $endpoint  - The endpoint being called.
     * @param string $callback  - The callback function.
     *
     * @return mixed
     */
    abstract public function getHandler(string $namespace, string $endpoint, $callback);

    /**
     * The caller
     *
     * @param string $name      - The name of the method to call.
     * @param array  $arguments - The arguments to pass in.
     *
     * @return mixed
     */
    public static function __callStatic(string $name, array $arguments)
    {
        $name = "{$name}Handler";
        if (is_null(self::$instance)) {
            self::$instance = new static();
        }

        return (self::$instance)->$name(...$arguments);
    }
}
