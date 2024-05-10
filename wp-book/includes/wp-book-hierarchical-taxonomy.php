<?php
// Register Custom Hierarchical Taxonomy "Book Category"
function wp_book_register_taxonomy_category() {
    $labels = array(
        'name'              => __('Book Categories', 'wp-book'),
        'singular_name'     => __('Book Category', 'wp-book'),
        'menu_name'         => __('Book Categories', 'wp-book'),
        'all_items'         => __('All Categories', 'wp-book'),
        'edit_item'         => __('Edit Category', 'wp-book'),
        'view_item'         => __('View Category', 'wp-book'),
        'update_item'       => __('Update Category', 'wp-book'),
        'add_new_item'      => __('Add New Category', 'wp-book'),
        'new_item_name'     => __('New Category Name', 'wp-book'),
        'parent_item'       => __('Parent Category', 'wp-book'),
        'parent_item_colon' => __('Parent Category:', 'wp-book'),
        'search_items'      => __('Search Categories', 'wp-book'),
        'not_found'         => __('No categories found', 'wp-book'),
        'not_found_in_trash'=> __('No categories found in Trash', 'wp-book'),
    );

    $args = array(
        'labels'            => $labels,
        'public'            => true,
        'hierarchical'      => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'rewrite'           => array( 'slug' => 'book-category' ),
    );

    register_taxonomy( 'book_category', 'book', $args );
}
add_action( 'init', 'wp_book_register_taxonomy_category' );