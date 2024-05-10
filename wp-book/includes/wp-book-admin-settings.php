<?php

function wp_book_settings_page() {
    add_submenu_page(
        'edit.php?post_type=book',
        __( 'Book Settings', 'wp-book' ),
        __( 'Settings', 'wp-book' ),
        'manage_options',
        'wp-book-settings',
        'wp_book_render_settings_page'
    );
}
add_action( 'admin_menu', 'wp_book_settings_page' );

// Render custom admin settings page content
function wp_book_render_settings_page() {
    ?>
    <div class="wrap">
        <h2><?php _e( 'Book Settings', 'wp-book' ); ?></h2>
        <form method="post" action="options.php">
            <?php
            settings_fields( 'wp_book_settings_group' );
            do_settings_sections( 'wp_book_settings' );
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

// Register settings and fields for custom admin settings page
function wp_book_register_settings() {
    register_setting( 'wp_book_settings_group', 'wp_book_settings_options' );

    add_settings_section(
        'wp_book_settings_section',
        __( 'General Settings', 'wp-book' ),
        'wp_book_settings_section_callback',
        'wp_book_settings'
    );

    add_settings_field(
        'currency',
        __( 'Currency', 'wp-book' ),
        'wp_book_currency_field',
        'wp_book_settings',
        'wp_book_settings_section'
    );

    add_settings_field(
        'books_per_page',
        __( 'Books per Page', 'wp-book' ),
        'wp_book_books_per_page_field',
        'wp_book_settings',
        'wp_book_settings_section'
    );
}
add_action( 'admin_init', 'wp_book_register_settings' );

// Callback function for settings section
function wp_book_settings_section_callback() {
    echo '<p>' . __( 'Configure general settings for the WP Book plugin.', 'wp-book' ) . '</p>';
}

// Callback function for currency field
function wp_book_currency_field() {
    $options = get_option( 'wp_book_settings_options' );
    $currency = isset( $options['currency'] ) ? $options['currency'] : '';
    $diff_currency = array( 'USD', 'INR', 'CAD', 'EUR' );

    echo '<select id="currency" name="wp_book_settings_options[currency]">';
    foreach ( $diff_currency as $curr ) {
        $selected = $currency === $curr ? 'selected="selected"' : '';
        echo '<option value="' . esc_attr( $curr ) . '" ' . $selected . '>' . $curr . '</option>';
    }
    echo '</select>';
}

// Callback function for books per page field
function wp_book_books_per_page_field() {
    $options = get_option( 'wp_book_settings_options' );
    $books_per_page = isset( $options['books_per_page'] ) ? $options['books_per_page'] : '';

    echo '<input type="number" id="books_per_page" name="wp_book_settings_options[books_per_page]" value="' . esc_attr( $books_per_page ) . '" />';
}