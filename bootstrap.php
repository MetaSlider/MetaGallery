<?php
use Extendify\MetaGallery\AdminRouter;

if (!defined('METAGALLERY_PATH')) {
    define('METAGALLERY_PATH', \plugin_dir_path(__FILE__));
}
require METAGALLERY_PATH . 'vendor/autoload.php';

if (!defined('METAGALLERY_TEXTDOMAIN')) {
    define('METAGALLERY_TEXTDOMAIN', 'metagallery');
}

if (!defined('METAGALLERY_SIDELOAD_FROM')) {
    define('METAGALLERY_SIDELOAD_FROM', '');
}
(new AdminRouter())->sideload(METAGALLERY_SIDELOAD_FROM);

define('METAGALLERY_PAGE_NAME', 'metagallery');

require METAGALLERY_PATH . 'routes/api.php';
require METAGALLERY_PATH . 'routes/admin.php';
// require METAGALLERY_PATH . 'routes/console.php';
