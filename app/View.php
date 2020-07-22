<?php

namespace KevinBatdorf;

/**
 * Handles loading views
 * 
 * @since 0.1.0
 */
class View {

    /**
     * Will return an the required view file if available
     * Example: View::shortcode()
     * 
     * @since 0.1.0
     * @param string $name       The name of the view file
     * @param string $arguements On enumerated array containing the parameters passed to the $name'ed method
     * @return object
     */
    public static function __callStatic($name, $arguments) {
        if ( file_exists( $view = dirname( __FILE__ ) . "/views/{$name}.php" ) ) {
            include $view;
        }
    }
}