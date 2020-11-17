<?php

namespace Extendify\MetaGallery\Models;

use Extendify\MetaGallery\Models\Model;

class Gallery extends Model
{
    public $title = '';
    public $images = [];
    public $settings = null;

    public function getPostType()
    {
        return 'metagallery';
    }
}
