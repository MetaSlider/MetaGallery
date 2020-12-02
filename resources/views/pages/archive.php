<?php
if (!defined('ABSPATH')) {
    die('No direct access.');
}

include METAGALLERY_PATH . 'resources/views/header.php';
?>
<div class="">
<?php include METAGALLERY_PATH . 'resources/views/navigation.php'; ?>
<div><?php var_dump($data); ?> </div>
</div>
<?php include METAGALLERY_PATH . 'resources/views/footer.php'; ?>
