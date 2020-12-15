<?php
/**
 * The main layout view
 */

if (!defined('ABSPATH')) {
    die('No direct access.');
}
?>

<div class="">
<?php
    if ($view) {
        include METAGALLERY_PATH . "resources/views/pages/{$view}.php";
    }
?>
</div>
