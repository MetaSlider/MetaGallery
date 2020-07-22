<?php

namespace KevinBatdorf;

/**
 * Handles setting up the shortcode
 * 
 * @since 0.1.0
 */
class Shortcode {

    /**
     * Adds scripts, styles and the view returned
     * 
     * @since 0.1.0
     * @return string
     */
    public function __construct() {
        add_shortcode( App::$slug, function() {
            $this->add_styles();
            $this->add_scripts();

            ob_start();
            View::shortcode();
            return ob_get_clean();
        });
    }

    /**
     * Add styles
     * 
     * @since 0.1.0
     * @return void
     */
    public function add_styles() {
        wp_enqueue_style( App::$slug . '-styles' );
        wp_add_inline_style( App::$slug . '-styles', '[x-cloak] { display: none; }');
    }

    /**
     * Add scripts
     * 
     * @since 0.1.0
     * @return void
     */
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