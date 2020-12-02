<?php

namespace Extendify\MetaGallery\Models;

if (!defined('ABSPATH')) {
    die('No direct access.');
}

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
