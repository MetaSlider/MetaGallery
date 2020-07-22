<?php

namespace KevinBatdorf\controllers;

use KevinBatdorf\App;

/**
 * Controller for handling external user data
 * 
 * @since 0.1.0
 */
class UserDataController {

    /**
     * Clears the cache
     * 
     * @since 0.1.0
     * @return UserDataController
     */
    public function clear_cache() {
        delete_transient( App::$slug . '-user-data' );
        return $this;
    }

    /**
     * Fetches data from miusage.com
     * 
     * @since 0.1.0
     * @return array
     */
    public function fetch() {
        $cached_users = get_transient( App::$slug . '-user-data' );
        if ( $cached_users ) {
            return array_merge(
                array( 'success' => true, 'cached' => true ),
                $cached_users,
            );
        }
        $result = wp_remote_get( "https://miusage.com/v1/challenge/1/" );
        $result = json_decode( wp_remote_retrieve_body( $result ), true );
        set_transient( App::$slug . '-user-data', $result, (1 * 60 * 60) );
        return array_merge( array( 'success' => true ), $result );
    }
}