<?php
use Extendify\MetaGallery\AdminRouter;
use Extendify\MetaGallery\Controllers\GalleryController;

// Opens possability for namespaced pages if we need to change the implementation but preserve the old pages
$namespace = '';
AdminRouter::get($namespace, 'archive', [GalleryController::class, 'index']);
AdminRouter::get($namespace, 'create', [GalleryController::class, 'create']);
AdminRouter::get($namespace, 'single', [GalleryController::class, 'show']);
AdminRouter::get($namespace, 'start', [GalleryController::class, 'start']);

\add_action('admin_init', function () {
    AdminRouter::register();
});
