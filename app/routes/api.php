<?php

namespace KevinBatdorf\routes;

use KevinBatdorf\App;

if ( !defined( 'ABSPATH' ) ) die( 'No direct access.' );

class API extends \WP_REST_Controller {

    	/**
	 * Namespace and version for the API
	 * 
	 * @var string
	 */
	protected $namespace;

	/**
	 * Constructor
	 */
	public function __construct() {
        $this->namespace = APP::$slug . '/v1';
		add_action( 'rest_api_init', array( $this, 'register_routes' ) );
    }
    
    /**
	 * Register routes
	 */
	public function register_routes() {

        register_rest_route( $this->namespace, '/users',
            array(
                array(
                    'methods' => 'GET',
                    // Only one method now so just inlining it to keep it simple
                    'callback' => function( $request ) {
                        $clearcache = filter_var( $request->get_param( 'clearcache' ), FILTER_VALIDATE_BOOLEAN );
                        $cached_users = get_transient( App::$slug . '-user-data' );
                        if ( $cached_users && !$clearcache) {
                            wp_send_json(
                                array_merge(
                                    array( 'success' => true, 'cached' => true ),
                                    $cached_users,
                                )
                            );
                        }

                        try {
                            $result = wp_remote_get( "https://miusage.com/v1/challenge/1/" );
                            $result = json_decode( wp_remote_retrieve_body( $result ), true );
                            set_transient( App::$slug . '-user-data', $result, (1 * 60 * 60) );
                            wp_send_json(
                                array_merge( array( 'success' => true ), $result ),
                                200
                            );
                        } catch (\Exception $e) {
                            wp_send_json_error( $e->getMessage(), $e->getCode() );
                        }
                    }
                )
            )
        );
    }
}
