<?php

namespace Extendify\MetaGallery\Contracts;

if (!defined('ABSPATH')) {
    die('No direct access.');
}

/**
 * Contract for routes
 *
 * @since 0.1.0
 */
interface BasicRoute
{
    public function __invoke($request);
}
