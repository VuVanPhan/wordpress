<?php

require_once('admin/thestudenthouse_menu.php');
add_action('init', function () {
    Menu_Admin::get_instance();
});

//rewrite function post_author_meta_box to show author in course
// if(!function_exists('post_author_meta_box')){
    // function post_author_meta_box(){
        // echo '123';
    // }
// }
