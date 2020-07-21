<?php

namespace KevinBatdorf;

if (!defined( 'ABSPATH' )) die( 'No direct access.' );

class AdminPage {

    public function __construct() {
        add_action( 'admin_menu', function() {
            $this->add_admin_options_page();
        });
        add_action( 'admin_enqueue_scripts', function($hook) {
            if ( 'toplevel_page_' . App::$slug != $hook ) return;
            $this->add_admin_scripts();
        });
        add_action( 'admin_head', function() {
            $page = get_current_screen();
            if ( isset($page->base) ) {
                if ( 'toplevel_page_' . App::$slug != $page->base ) return;
                // helper style for Alpinejs
                echo '<style>[x-cloak] { display: none; }</style>';
            }
        });
    }

    public function add_admin_options_page() {
        add_menu_page(
            App::$name,
            'Dev Challenge',
            'manage_options',
            App::$slug,
            '\KevinBatdorf\View::admin',
            'dashicons-clipboard', 99);
    }

    public function add_admin_scripts() {
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