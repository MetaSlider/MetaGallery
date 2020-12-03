<?php
if (!defined('ABSPATH')) {
    die('No direct access.');
}
use Extendify\MetaGallery\App;
use Extendify\MetaGallery\API\GalleryRoute;
use Extendify\MetaGallery\APIRouter;

// TODO: Not really necessary but this could be refactored to be more like the admin router.
\add_action('rest_api_init', function () {
    $namespace = APP::$slug . '/' . APP::$apiVersion;

    APIRouter::get($namespace, '/gallery', GalleryRoute::class);
});
