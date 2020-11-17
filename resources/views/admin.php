<?php
use Extendify\MetaGallery\App;

// wp_add_inline_script(App::$slug . '-alpine', "var userData = {$users}");
include dirname(__FILE__) . '/parts/header.php';
?>
<div class="">
<?php include dirname(__FILE__) . '/parts/navigation.php'; ?>
<?php
    $route = isset($_GET['route']) ? $_GET['route'] : 'start';
    // if ($route === 'gallery') {
    //     if (!isset($_GET['gallery'])) {
    //         wp_redirect(admin_url('admin.php?page=metagallery&route=create'));
    //     }
    // }
    if (file_exists($view = dirname(__FILE__) . "pages/{$route}.php")) {
        include $view;
    }
?>
</div>
<?php include dirname(__FILE__) . '/parts/footer.php'; ?>
