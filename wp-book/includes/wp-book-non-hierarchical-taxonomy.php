<?php
// Register Custom Non-Hierarchical Taxonomy "Book Tag"
function wp_book_register_taxonomy_tag() {
    $labels = array(
        'name'              => __('Book Tags', 'wp-book'),
        'singular_name'     => __('Book Tag', 'wp-book'),
        'menu_name'         => __('Book Tags', 'wp-book'),
        'all_items'         => __('All Tags', 'wp-book'),
        'edit_item'         => __('Edit Tag', 'wp-book'),
        'view_item'         => __('View Tag', 'wp-book'),
        'update_item'       => __('Update Tag', 'wp-book'),
        'add_new_item'      => __('Add New Tag', 'wp-book'),
        'new_item_name'     => __('New Tag Name', 'wp-book'),
        'search_items'      => __('Search Tags', 'wp-book'),
        'not_found'         => __('No tags found', 'wp-book'),
        'not_found_in_trash'=> __('No tags found in Trash', 'wp-book'),
    );

    $args = array(
        'labels'            => $labels,
        'public'            => true,
        'hierarchical'      => false,
        'show_ui'           => true,
        'show_admin_column' => true,
        'rewrite'           => array( 'slug' => 'book-tag' ),
    );

    register_taxonomy( 'book_tag', 'book', $args );
}
add_action( 'init', 'wp_book_register_taxonomy_tag' );