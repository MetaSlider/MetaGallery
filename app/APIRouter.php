<?php
/**
 * API router
 */

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

    /**
     * The capablity required for access.
     *
     * @var $capability
     */
    protected $capability;


    /**
     * Set the capability
     */
    public function __construct()
    {
        $this->capability = App::$capability;
    }

    /**
     * Check the capability
     *
     * @param string $capability - The capability.
     *
     * @return boolean
     */
    public function permission(string $capability)
    {
        $this->capability = $capability;
        return $this;
    }

    /**
     * Check the authorization of the request
     *
     * @return boolean
     */
    public function checkPermission()
    {
        // Check for the nonce on the server (used by WP REST).
        if (isset($_SERVER['HTTP_X_WP_NONCE']) && \wp_verify_nonce(sanitize_text_field(wp_unslash($_SERVER['HTTP_X_WP_NONCE'])), 'wp_rest')) {
            return \current_user_can($this->capability);
        }

        return false;
    }

    /**
     * Register dynamic routes
     *
     * @param string $namespace - The api name space.
     * @param string $endpoint  - The endpoint.
     * @param string $callback  - The callback to run.
     *
     * @return void
     */
    public function getHandler(string $namespace, string $endpoint, $callback)
    {
        \register_rest_route(
            $namespace,
            $endpoint,
            [
                'methods' => 'GET',
                'callback' => new $callback(),
                'permission_callback' => [
                    $this,
                    'checkPermission',
                ],
            ],
            true,
        );
    }

    /**
     * Register dynamic routes
     *
     * @param string $namespace - The api name space.
     * @param string $endpoint  - The endpoint.
     * @param string $callback  - The callback to run.
     *
     * @return void
     */
    public function postHandler(string $namespace, string $endpoint, $callback)
    {
    }
}
