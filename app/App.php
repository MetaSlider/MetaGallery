<?php

namespace KevinBatdorf;

/**
 * Controller for handling various app data
 * 
 * @since 0.1.0
 */
class App {

    /**
     * Plugin name
     * 
     * @since 0.1.0
     * @var string
     */
    public static $name = '';

    /**
     * Plugin slug
     * 
     * @since 0.1.0
     * @var string
     */
    public static $slug = '';

    /**
     * Plugin version
     * 
     * @since 0.1.0
     * @var string
     */
    public static $version = '';

    /**
     * Process the readme file to get version and name
     * 
     * @since 0.1.0
     * @return void
     */
    public function __construct() {
        $readme = file_get_contents( dirname( __DIR__ ) . '/readme.txt' );

        preg_match( '/=== (.+) ===/', $readme, $matches );
        self::$name = $matches[1];
        self::$slug = sanitize_title( self::$name );

        preg_match( '/Stable tag: ([0-9.:]+)/', $readme, $matches );
        self::$version = $matches[1];
    }

    /**
     * Will return an instance of a controller on demand
     * Example: App::get('UserData')
     * 
     * @since 0.1.0
     * @param string $name       The name of the method being called
     * @param string $arguements On enumerated array containing the parameters passed to the $name'ed method
     * @return object
     */
    public static function __callStatic($name, $arguments) {
        if ( $name !== 'get' ) return;
        if ( file_exists( dirname( __FILE__ ) . "/controllers/{$arguments[0]}Controller.php" ) ) {
            $controller = 'KevinBatdorf\\controllers\\' . $arguments[0] . 'Controller';
            return new $controller;
        }
    }
}