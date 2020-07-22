<?php
use KevinBatdorf\App;

include dirname( __FILE__ ) . '/parts/header.php';
include dirname( __FILE__ ) . '/parts/navigation.php';
?>


<?php
    // If users tab
    try {
        $users = wp_remote_get( get_rest_url( null, App::$slug . '/v1/users' ) );
        $users = wp_remote_retrieve_body( $users );
        wp_add_inline_script(App::$slug . '-alpine', "var userData = {$users}");
    } catch ( \Exception $e ) {}
    include dirname( __FILE__ ) . '/pages/users/index.php'
?>
