<?php

// Shortcode callback function for [book]
function wp_book_shortcode_callback( $atts ) {
    $atts = shortcode_atts( array(
        'id' => '',                 // Default is empty
        'author_name' => '',        // Default is empty
        'year' => '',               // Default is empty
        'category' => '',           // Default is empty
        'tag' => '',                // Default is empty
        'publisher' => '',          // Default is empty
    ), $atts );

    // Get the currency symbol from the admin settings
    $currency_symbol = get_option( 'wp_book_settings_options' )['currency'];

    $args = array(
        'post_type' => 'book',
        'posts_per_page' => -1,     // Retrieve all books matching the criteria
        'orderby' => 'title',       // Order by title, you can change this as needed
        'order' => 'ASC',           // Order direction, you can change this as needed
        'meta_query' => array(),    // Initialize meta query array
        'tax_query' => array(),     // Initialize tax query array
    );

    // Add meta query for specific attributes
    if ( ! empty( $atts['id'] ) ) {
        $args['meta_query'][] = array(
            'key' => '_book_id',    
            'value' => $atts['id'],
            'compare' => '=',
        );
    }

    if ( ! empty( $atts['author_name'] ) ) {
        $args['meta_query'][] = array(
            'key' => '_book_author_name',  
            'value' => $atts['author_name'],
            'compare' => 'LIKE',
        );
    }

    if ( ! empty( $atts['year'] ) ) {
        $args['meta_query'][] = array(
            'key' => '_book_year',  
            'value' => $atts['year'],
            'compare' => '=',
        );
    }

    // Add taxonomy query for category and tag
    if ( ! empty( $atts['category'] ) ) {
        $args['tax_query'][] = array(
            'taxonomy' => 'book_category',
            'field' => 'slug',
            'terms' => $atts['category'],
        );
    }

    if ( ! empty( $atts['tag'] ) ) {
        $args['tax_query'][] = array(
            'taxonomy' => 'book_tag',
            'field' => 'slug',
            'terms' => $atts['tag'],
        );
    }

    // Add publisher meta query
    if ( ! empty( $atts['publisher'] ) ) {
        $args['meta_query'][] = array(
            'key' => '_book_publisher',  
            'value' => $atts['publisher'],
            'compare' => 'LIKE',
        );
    }

    // Query books based on the constructed arguments
    $books_query = new WP_Query( $args );

    // Start building the output
    $output = '<div class="wp-book-shortcode">';

    if ( $books_query->have_posts() ) {
        while ( $books_query->have_posts() ) {
            $books_query->the_post();
            // Customize the output as needed, e.g., displaying book title, author, etc.
            $output .= '<h3>' . get_the_title() . '</h3>';
            $output .= '<p>Author: ' . get_post_meta( get_the_ID(), '_book_author_name', true ) . '</p>';
            $output .= '<p>Year: ' . get_post_meta( get_the_ID(), '_book_year', true ) . '</p>';
            $output .= '<p>Publisher: ' . get_post_meta( get_the_ID(), '_book_publisher', true ) . '</p>';
            $output .= '<p>Price: ' . get_post_meta( get_the_ID(), '_book_price', true ) . ' ' . $currency_symbol . '</p>';
            // Add more information if necessary
        }
        wp_reset_postdata();
    } else {
        $output .= '<p>No books found.</p>';
    }

    $output .= '</div>';

    return $output;
}
add_shortcode( 'book', 'wp_book_shortcode_callback' );
