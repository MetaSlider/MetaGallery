<?php
/**
 * The start page view
 */

if (!defined('ABSPATH')) {
    die('No direct access.');
}
?>

<div class="max-w-screen-md mx-auto">
    <p class="text-center">
<?php
    \esc_html_e('Hi, welcome the gallery project by MetaSlider. <strong>Redefining WordPress galleries</strong>.', 'metagallery');
?>
    </p>
    <div class="my-20 flex items-center justify-center">
    <!-- For now this will immediately create a gallery and move to the archive page.
        However, I'd like to have a middle step to let users pre select a gallery layout.
        It's set up with a start, create, archive, and single page system but I think
        we can just use the archive page as the builder for now until it gets more complex
        ie. no single page and no create page
    -->
        <a
            href="<?php echo \esc_attr(\admin_url('admin.php?page=' . METAGALLERY_PAGE_NAME . '&route=create')); ?>"
            class="flex items-center transition duration-150 px-6 py-1 bg-nord4 hover:bg-nord1 hover:text-nord6 shadow-sm text-base font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-nord8">
            <?php \esc_html_e('Start Here', 'metagallery'); ?>
        </a>
    </div>
    <div class="bg-nord5 p-10 py-6">
        <h3 class="mb-3"><?php \esc_html_e('MetaGallery will be build following these principles:', 'metagallery'); ?></h3>
        <ul>
            <li>
            <?php
                // translators: %s is an emoji.
                printf(\esc_html__('%s Fast - Using modern best practices, your galleries will be faster than ever.', 'metagallery'), '🚀');
            ?>
            </li>

            <li>
            <?php
                // translators: %s is an emoji.
                printf(\esc_html__('%s SEO-focused - Search engines will love your galleries.', 'metagallery'), '🏢');
            ?>
            </li>

            <li>
            <?php
                // translators: %s is an emoji.
                printf(\esc_html__('%s Easy to learn, fun to master. With advanced features for those who need them.', 'metagallery'), '⛵');
            ?>
            </li>
        </ul>
    </div>
</div>
