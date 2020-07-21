<?php

namespace KevinBatdorf;

if (!defined( 'ABSPATH' )) die( 'No direct access.' );

class Shortcode {
    
    public function __construct() {

        add_shortcode( App::$slug, function() {
            $this->add_styles();
            $this->add_scripts();

            ob_start();
            View::shortcode();
            return ob_get_clean();
        });
    }

    public function add_styles() {
        wp_enqueue_style( App::$slug . '-styles' );
        wp_add_inline_style( App::$slug . '-styles', '[x-cloak] { display: none; }');
    }
    
    public function add_scripts() {
        wp_enqueue_script(
            App::$slug . '-axios',
            'https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js',
            array(),
            App::$version,
            true
        );
        wp_enqueue_script(
            App::$slug . '-alpine',
            'https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js',
            array(),
            App::$version,
            true
        );
    }
}