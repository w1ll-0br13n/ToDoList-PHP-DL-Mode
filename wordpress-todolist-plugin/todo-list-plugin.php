<?php
/*
Plugin Name: ToDoList PHP-MySQL
Description: Complet to do list in PHP & MySQL with Dark and Light Mode.
Version: 1.0
Author: Godwill J. KEMMOE
Author URI: https://mozartdevs.com
*/

/* Enqueue CSS and JavaScript files */
function enqueue_app_assets() {
    wp_enqueue_style('app-css', plugins_url('assets/css/app.css', __FILE__));
    wp_enqueue_script('app-js', plugins_url('assets/js/app.js', __FILE__), array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'enqueue_app_assets');

// Create a shortcode to embed your app
function embed_app() {
    ob_start();
    include(plugin_dir_path(__FILE__) . 'index.php');
    return ob_get_clean();
}
add_shortcode('GJK-006-WP-P', 'embed_app');
?>
