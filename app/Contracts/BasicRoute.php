<?php

namespace Extendify\MetaGallery\Contracts;

/**
 * Contract for routes
 *
 * @since 0.1.0
 */
interface BasicRoute
{
    public function __invoke($request);
}
