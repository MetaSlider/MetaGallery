<?php

namespace KevinBatdorf\Routes;

use KevinBatdorf\App;

/**
 * Controller for handling WP_CLI commands
 * 
 * @since 0.1.0
 */
class Console {

    /**
     * Adds the commands
     * 
     * @since 0.1.0
     * @return void
     */
    public function __construct() {
        add_action( 'cli_init', function() {
            // Only one method now so just inlining it to keep it simple.
            \WP_CLI::add_command( 'refresh-users', function() {
                App::get('UserData')->clear_cache()->fetch();
                \WP_CLI::line( __('Updated!', App::$slug ) );
            });
        });
    }
}