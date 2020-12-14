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
     * @return Extendify\MetaGallery\Models\Gallery
     */
    public function __invoke()
    {
        return Gallery::get()->all();
    }
}
