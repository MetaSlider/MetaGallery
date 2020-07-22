<?php

namespace KevinBatdorf\routes;

use KevinBatdorf\App;

/**
 * Controller for handling REST requests
 * 
 * @since 0.1.0
 */
class API extends \WP_REST_Controller {

    /**
     * Namespace and version for the API
     * 
     * @since 0.1.0
     * @var string
     */
	protected $namespace;

    /**
     * Sets up the namespace and hooks into WordPress
     * 
     * @since 0.1.0
     * @return void
     */
	public function __construct() {
        $this->namespace = APP::$slug . '/v1';
		add_action( 'rest_api_init', array( $this, 'register_routes' ) );
    }

    /**
     * Register routes
     * 
     * @since 0.1.0
     * @return void
     */
	public function register_routes() {
        register_rest_route( $this->namespace, '/users',
            array(
                array(
                    'methods' => 'GET',
                    // Only one method now so just inlining it to keep it simple.
                    // If more, add to a controller
                    'callback' => function( $request ) {
                        try {
                            if (filter_var( $request->get_param( 'clearcache' ), FILTER_VALIDATE_BOOLEAN )) {
                                $result = App::get('UserData')->clear_cache()->fetch();
                            } else {
                                $result = App::get('UserData')->fetch();
                            }

                            if ( is_wp_error($result) ) {
                                wp_send_json_error( array(
                                    'message' => $result->get_error_message()
                                ), 400 );
                            }
                            wp_send_json( $result, 200 );
                        } catch (\Exception $e) {
                            wp_send_json_error( $e->getMessage(), $e->getCode() );
                        }
                    }
                )
            )
        );
    }
}
