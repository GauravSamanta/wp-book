<?php
// Create custom meta table on plugin activation
function wp_book_create_meta_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'book_meta';

    if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $table_name (
            meta_id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            post_id bigint(20) UNSIGNED NOT NULL,
            meta_key varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
            meta_value longtext COLLATE utf8mb4_unicode_ci,
            PRIMARY KEY  (meta_id),
            KEY post_id (post_id),
            KEY meta_key (meta_key(191))
        ) $charset_collate;";

        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        dbDelta($sql);
    }
}

// Save book meta data to custom meta table
function wp_book_save_meta_to_table( $post_id ) {
    global $wpdb;

    // Ensure this is not an autosave
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    // Ensure current user can edit post
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    // Define your meta fields here
    $meta_fields = array(
        'book_author_name',
        'book_price',
        'book_publisher',
        'book_year',
        'book_edition',
        'book_url'
    );

    // Prepare data for insertion
    $data_to_insert = array();
    foreach ( $meta_fields as $field ) {
        if ( isset( $_POST[$field] ) ) {
            $data_to_insert[$field] = sanitize_text_field( $_POST[$field] );
        }
    }

    // Insert or update meta data in custom table
    if ( ! empty( $data_to_insert ) ) {
        $table_name = $wpdb->prefix . 'book_meta';
        foreach ( $data_to_insert as $meta_key => $meta_value ) {
            $wpdb->replace( $table_name, array(
                'post_id' => $post_id,
                'meta_key' => $meta_key,
                'meta_value' => $meta_value,
            ), array(
                '%d',
                '%s',
                '%s',
            ) );
        }
    }
}
add_action( 'save_post', 'wp_book_save_meta_to_table' );