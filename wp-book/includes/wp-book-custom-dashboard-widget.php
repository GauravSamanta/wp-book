<?php

// Function to add a custom dashboard widget
function add_custom_dashboard_widget() {
    wp_add_dashboard_widget(
        'custom_dashboard_widget',            // Widget slug/ID
        'Top 5 Book Categories',              // Widget title
        'display_custom_dashboard_widget'     // Callback function to display widget content
    );
}
add_action('wp_dashboard_setup', 'add_custom_dashboard_widget');

// Callback function to display custom dashboard widget content
function display_custom_dashboard_widget() {
    $categories = get_terms(array(
        'taxonomy' => 'book_category',      // Taxonomy name for book categories
        'orderby' => 'count',               // Order by category count
        'order' => 'DESC',                  // Descending order to get top categories
        'number' => 5,                      // Limit to top 5 categories
    ));

    if (!empty($categories) && !is_wp_error($categories)) {
        echo '<ul>';
        foreach ($categories as $category) {
            echo '<li>' . $category->name . ' (' . $category->count . ')</li>';
        }
        echo '</ul>';
    } else {
        echo 'No categories found.';
    }
}
