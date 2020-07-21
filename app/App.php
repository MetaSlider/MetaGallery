<?php

namespace KevinBatdorf;

if (!defined( 'ABSPATH' )) die( 'No direct access.' );

class App {
    public static $name = '';
    public static $slug = '';
    public static $version = '';

    public function __construct() {
        $readme = file_get_contents( dirname( __DIR__ ) . '/readme.txt' );

        preg_match( '/=== (.+) ===/', $readme, $matches );
        self::$name = $matches[1];
        self::$slug = sanitize_title( self::$name );

        preg_match( '/Stable tag: ([0-9.:]+)/', $readme, $matches );
        self::$version = $matches[1];

    }
}