<?php
// Add Custom Meta Box for Book Information
function wp_book_meta_box_callback( $post ) {
    // Get existing values for fields if they exist i.e (Either value or false)
    $author_name = get_post_meta( $post->ID, '_book_author_name', true );
    $price = get_post_meta( $post->ID, '_book_price', true );
    $publisher = get_post_meta( $post->ID, '_book_publisher', true );
    $year = get_post_meta( $post->ID, '_book_year', true );
    $edition = get_post_meta( $post->ID, '_book_edition', true );
    $url = get_post_meta( $post->ID, '_book_url', true );

    // Output HTML for fields in save post editor window
    ?>
    <div class="wp-book-meta-box">
        <label for="book_author_name"><?php esc_html_e( 'Author Name:', 'wp-book' ); ?></label>
        <br>
        <input type="text" id="book_author_name" name="book_author_name" value="<?php echo esc_attr( $author_name ); ?>" />
        <br>
        <label for="book_price"><?php esc_html_e( 'Price:', 'wp-book' ); ?></label>
        <br>
        <input type="number" min="0" step="1" id="book_price" name="book_price" value="<?php echo esc_attr( $price ); ?>" />
        <br>
        <label for="book_publisher"><?php esc_html_e( 'Publisher:', 'wp-book' ); ?></label>
        <br>
        <input type="text" id="book_publisher" name="book_publisher" value="<?php echo esc_attr( $publisher ); ?>" />
        <br>
        <label for="book_year"><?php esc_html_e( 'Year:', 'wp-book' ); ?></label>
        <br>
        <input type="number" step="1" id="book_year" name="book_year" value="<?php echo esc_attr( $year ); ?>" />
        <br>
        <label for="book_edition"><?php esc_html_e( 'Edition:', 'wp-book' ); ?></label>
        <br>
        <input type="number" id="book_edition" name="book_edition" value="<?php echo esc_attr( $edition ); ?>" />
        <br>
        <label for="book_url"><?php esc_html_e( 'URL:', 'wp-book' ); ?></label>
        <br>
        <input type="url" id="book_url" name="book_url" value="<?php echo esc_url( $url ); ?>" />
    </div>
    <?php
}

function wp_book_add_meta_box() {
    add_meta_box( 'wp_book_meta_box', __('Book Information', 'wp-book'), 'wp_book_meta_box_callback', 'book', 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'wp_book_add_meta_box' );

// Save Meta Box Data
function wp_book_save_meta_box_data( $post_id ) {
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    $fields = array( 'book_author_name', 'book_price', 'book_publisher', 'book_year', 'book_edition', 'book_url' );

    foreach ( $fields as $field ) {
        if ( isset( $_POST[ $field ] ) ) {
            update_post_meta( $post_id, '_' . $field, sanitize_text_field( $_POST[ $field ] ) );
        }
    }
}
add_action( 'save_post', 'wp_book_save_meta_box_data' );