<?php

use Extendify\MetaGallery\App;
use Extendify\MetaGallery\Routes\UserData;
use Extendify\MetaGallery\APIRouter;

\add_action('rest_api_init', function () {
    $namespace = APP::$slug . '/v1';

    APIRouter::get($namespace, '/users', UserData::class);
});
