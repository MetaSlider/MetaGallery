<?php

namespace Extendify\MetaGallery\Routes;

use Extendify\MetaGallery\Contracts\BasicRoute;

/**
 * Route to do something
 *
 * @since 0.1.0
 */
class UserData implements BasicRoute
{
    public function __invoke($request)
    {
        return $request->get_params();
    }
}
