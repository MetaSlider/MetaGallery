<?php
/**
 * Return all galleries
 */

namespace Extendify\MetaGallery\API;

if (!defined('ABSPATH')) {
    die('No direct access.');
}

use Extendify\MetaGallery\Models\Gallery;
use Extendify\MetaGallery\Contracts\BasicRoute;

/**
 * Route to do something
 *
 * @since 0.1.0
 */
class GalleryRoute implements BasicRoute
{
    /**
     * Return all galleries
     *
     * @param WP_REST_Request $request - The request.
     * @return WP_Query
     */
    public function __invoke($request)
    {
        if ($request) {
            return Gallery::get()->all();
        }
    }
}
