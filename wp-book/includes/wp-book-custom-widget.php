<?php

class Book_Category_Widget extends WP_Widget {
    public function __construct() {
        parent::__construct(
            'book_category_widget',
            __('Book Category Widget', 'wp-book'),
            array(
                'description' => __('Display books of selected category in the sidebar.', 'wp-book'),
            )
        );
    }

    public function widget($args, $instance) {
        $title = apply_filters('widget_title', $instance['title']);
        $category_id = isset($instance['category']) ? $instance['category'] : '';

        echo $args['before_widget'];
        if (!empty($title)) {
            echo $args['before_title'] . $title . $args['after_title'];
        }

        $args = array(
            'post_type' => 'book',
            'posts_per_page' => 5, // Number of books to display
            'tax_query' => array(
                array(
                    'taxonomy' => 'book_category',
                    'field' => 'id',
                    'terms' => $category_id,
                ),
            ),
        );

        $books_query = new WP_Query($args);

        if ($books_query->have_posts()) {
            echo '<ul>';
            while ($books_query->have_posts()) {
                $books_query->the_post();
                echo '<li><a href="' . get_permalink() . '">' . get_the_title() . '</a></li>';
            }
            echo '</ul>';
            wp_reset_postdata();
        } else {
            echo '<p>No books found.</p>';
        }

        echo $args['after_widget'];
    }

    public function form($instance) {
        $title = isset($instance['title']) ? $instance['title'] : '';
        $category = isset($instance['category']) ? $instance['category'] : '';

        // Widget Title
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
        </p>
        <?php

        // Book Category Dropdown
        $categories = get_terms(array(
            'taxonomy' => 'book_category',
            'hide_empty' => false,
        ));
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('category'); ?>"><?php _e('Select Category:'); ?></label>
            <select id="<?php echo $this->get_field_id('category'); ?>" name="<?php echo $this->get_field_name('category'); ?>">
                <?php foreach ($categories as $category_item) : ?>
                    <option value="<?php echo esc_attr($category_item->term_id); ?>" <?php selected($category, $category_item->term_id); ?>><?php echo $category_item->name; ?></option>
                <?php endforeach; ?>
            </select>
        </p>
        <?php
    }

    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        $instance['category'] = (!empty($new_instance['category'])) ? $new_instance['category'] : '';

        return $instance;
    }
}

function register_book_category_widget() {
    register_widget('Book_Category_Widget');
}
add_action('widgets_init', 'register_book_category_widget');
