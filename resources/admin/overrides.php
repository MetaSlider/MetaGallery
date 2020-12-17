<?php
/**
 * Overrides to various WP defaults
 */

/**
 * Checks whether the page is a metagallery page.
 *
 * @return boolean
 */
function metagalleryCheckPageIsOurs()
{
    // phpcs:ignore WordPress.Security.NonceVerification.Recommended
    return isset($_GET['page']) && (sanitize_text_field(wp_unslash($_GET['page'])) === METAGALLERY_PAGE_NAME);
}

add_action(
    'admin_menu',
    function () {
        if (metagalleryCheckPageIsOurs()) {
            remove_filter('update_footer', 'core_update_footer');
            add_filter(
                'admin_footer_text',
                function () {
                    return sprintf(
                        // translators: %s are anchor tags i.e. <a></a>.
                        esc_html__('MetaGallery is developed in public. Follow along on our %1$sdevelopment page%2$s, or %3$sprovide feedback%4$s.', 'metagallery'),
                        '<a target="_blank" class="text-nord10 underline" href="https://github.com/MetaSlider/MetaGallery">',
                        '</a>',
                        '<a target="_blank" class="text-nord10 underline" href="https://github.com/MetaSlider/MetaGallery/discussions">',
                        '</a>'
                    );
                }
            );
        }
    }
);
