<?php
/**
 * Plugin Name: WP Book
 * Description: A WordPress plugin for managing books, categories, and book-related features.
 * Version: 1.0.0
 * Author: Gaurav Samanta
 * Author URI: https://github.com/GauravSamanta/wp-book
 * Text Domain: wp-book
 * Domain Path: /languages/
 */

// Defining constants for paths
define( 'WP_BOOK_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'WP_BOOK_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

include_once WP_BOOK_PLUGIN_DIR . 'includes/wp-book-custom-post-type.php';
include_once WP_BOOK_PLUGIN_DIR . 'includes/wp-book-hierarchical-taxonomy.php';
include_once WP_BOOK_PLUGIN_DIR . 'includes/wp-book-non-hierarchical-taxonomy.php';
include_once WP_BOOK_PLUGIN_DIR . 'includes/wp-book-meta-boxes.php';
include_once WP_BOOK_PLUGIN_DIR . 'includes/wp-book-meta-table.php';
register_activation_hook( __FILE__, 'wp_book_create_meta_table' );

include_once WP_BOOK_PLUGIN_DIR . 'includes/wp-book-admin-settings.php';

include_once WP_BOOK_PLUGIN_DIR . 'includes/wp-book-shortcode.php';
include_once WP_BOOK_PLUGIN_DIR . 'includes/wp-book-custom-widget.php';
include_once WP_BOOK_PLUGIN_DIR . 'includes/wp-book-custom-dashboard-widget.php';


add_action(
    'plugins_loaded',
    function () {
        load_plugin_textdomain('wp-book', false, dirname(plugin_basename(__FILE__)).'/languages/');
    }
);