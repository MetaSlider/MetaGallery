<?php
/**
 * The single page view
 */

if (!defined('ABSPATH')) {
    die('No direct access.');
}
?>

<!-- TODO:
1. Delete images
1. Add image properties (alt tags only)
1. show via shortcode


Sooner
1. Add image resizing that auto refreshes
1. Add image dropdown for deleting, adding attributes
1. Hold off on captions for initial release

1. Add muuri config override
1. add indiviual image output override? maybe!

Later:
1. Add unpublish option (publish by default)
1. Add delete me option
-->

<div
    x-title="Images"
    x-data="Gallery()"
    x-id="theGallery"
    @metagallery-images-added.window="addImages($event.detail.images)"
    @reset-layout.window="window.metagalleryGrid.refreshItems().layout(true)"
    @load.window="init()"
    class="text-center flex-grow flex relative z-0 px-4">
    <div :x-id="`metagallery-grid-${$component('current').data.ID}`" class="relative w-full">
        <!-- Grid container -->
    </div>
    <template x-if="!$component('current').images.length">
        <div class="absolute inset-0 flex items-center justify-center font-heading text-6xl text-nord4 mx-auto transform -translate-y-8 pointer-events-none">
            MetaGallery
        </div>
    </template>
</div>
