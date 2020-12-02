<?php
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
    protected static $instance = null;

    abstract public function getHandler(string $namespace, string $endpoint, $callback);

    public static function __callStatic(string $name, array $arguments)
    {
        $name = "{$name}Handler";
        if (null === self::$instance) {
            self::$instance = new static();
        }
        return (self::$instance)->$name(...$arguments);
    }
}
