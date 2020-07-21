<?php

namespace KevinBatdorf;

if (!defined( 'ABSPATH' )) die( 'No direct access.' );

class View {
    public static function __callStatic($name, $arguments) {
        if ( file_exists( $view = dirname( __FILE__ ) . "/views/{$name}.php" ) ) {
            include $view;
        }
    }
}