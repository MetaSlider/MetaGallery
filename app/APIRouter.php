<?php

namespace Extendify\MetaGallery;

use Extendify\MetaGallery\App;
use Extendify\MetaGallery\Traits\Routable;

/**
 * Simple router for the REST Endpoints
 *
 * @since 0.1.0
 */
class APIRouter extends \WP_REST_Controller
{
    use Routable;

    protected $capability;

    public function __construct()
    {
        $this->capability = App::$capability;
    }

    public function permission(string $capability)
    {
        $this->capability = $capability;
        return $this;
    }
    public function checkPermission()
    {
        // Check for the nonce on the server (used by WP REST)
        if (isset($_SERVER['HTTP_X_WP_NONCE']) && \wp_verify_nonce($_SERVER['HTTP_X_WP_NONCE'], 'wp_rest')) {
            return \current_user_can($this->capability);
        }
        return false;
    }

    public function gethandler(string $namespace, string $endpoint, $callback)
    {
        \register_rest_route(
            $namespace,
            $endpoint,
            [
                'methods' => 'GET',
                'callback' => new $callback,
                'permission_callback' => [$this, 'checkPermission']
            ],
            true
        );
    }
}
