<?php
/**
 * The main layout view
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
    if ($view) {
        include METAGALLERY_PATH . "resources/views/pages/{$view}.php";
    }
?>
</div>
</div>
<?php
require METAGALLERY_PATH . 'resources/views/footer.php';
