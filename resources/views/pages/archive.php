<?php
/**
 * The archive page view
 */

if (!defined('ABSPATH')) {
    die('No direct access.');
}

require METAGALLERY_PATH . 'resources/views/header.php';
?>
<div class="">
<?php require METAGALLERY_PATH . 'resources/views/navigation.php'; ?>

<div>
<?php
    // phpcs:disable
    var_dump($data);
    // phpcs:enable
?>
</div>
</div>
<?php
require METAGALLERY_PATH . 'resources/views/footer.php';
