<?php

// Enqueue styles and scripts
function theme_enqueue_assets() {
    wp_enqueue_style('index_university_font_google', "https://fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i");
    wp_enqueue_style('index_university_bootstrap', "https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css");
    wp_enqueue_style('index_university', get_theme_file_uri('build/index.css'), array(), '1.0');
    wp_enqueue_style('index_university_extra', get_theme_file_uri('build/style-index.css'), array(), '1.0');
    wp_enqueue_script('index_university_script-1', get_theme_file_uri('build/mobile.js'), array(), '1.0', true);
    wp_enqueue_script('index_university_script', get_theme_file_uri('build/index.js'), array('jquery'), '1.0', true);
}
add_action('wp_enqueue_scripts', 'theme_enqueue_assets');

// Register navigation menus
function mytheme_register_nav_menu() {
    register_nav_menus(array(
        'primary_menu' => __('Menu chính', 'themeUniversity'),
        'footer_menu_1' => __('Menu Footer_1', 'themeUniversity'),
    ));
}
add_action('after_setup_theme', 'mytheme_register_nav_menu');

// Add support for post thumbnails
add_theme_support('post-thumbnails');


// Custom pagination
function custom_paginate_links() {
    $args = array(
        'prev_text' => '<span class="pagination-previous">Trước</span>',
        'next_text' => '<span class="pagination-next">Sau</span>',
    );
    echo '<div class="custom-paginate-links">';
    echo paginate_links($args);
    echo '</div>';
}

// Register custom post types
function create_custom_post_types() {
    // Event Post Type
    $event_labels = array(
        'name' => 'Sự kiện',
        'singular_name' => 'Sự kiện',
        'menu_name' => 'Sự kiện',
    );
    $event_args = array(
        'labels' => $event_labels,
        'public' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
        'show_in_rest' => true,
        'menu_icon' => 'dashicons-calendar',
    );
    register_post_type('event', $event_args);

    // Blog Post Type
    $blog_labels = array(
        'name' => 'Blogs',
        'singular_name' => 'Blog',
        'menu_name' => 'Blogs',
    );
    $blog_args = array(
        'labels' => $blog_labels,
        'public' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
        'show_in_rest' => true,
        'menu_icon' => 'dashicons-admin-post',
    );
    register_post_type('blog', $blog_args);

    // Slides Post Type
    $slides_labels = array(
        'name' => 'Slides',
        'singular_name' => 'Slide',
        'menu_name' => 'Slides',
        'add_new' => 'Add New',
        'add_new_item' => 'Add New Slide',
        'new_item' => 'New Slide',
        'edit_item' => 'Edit Slide',
        'view_item' => 'View Slide',
        'all_items' => 'All Slides',
        'search_items' => 'Search Slides',
        'not_found' => 'No slides found.',
        'not_found_in_trash' => 'No slides found in Trash.',
    );
    $slides_args = array(
        'labels' => $slides_labels,
        'public' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor', 'thumbnail'),
        'show_in_rest' => true,
        'menu_icon' => 'dashicons-format-gallery',
    );
    register_post_type('slides', $slides_args);

    // Custom Taxonomies
    $event_category_labels = array(
        'name' => _x('Danh mục Sự kiện', 'taxonomy general name', 'themeUniversity'),
        'singular_name' => _x('Danh mục Sự kiện', 'taxonomy singular name', 'themeUniversity'),
        'search_items' => __('Tìm kiếm Danh mục Sự kiện', 'themeUniversity'),
        'all_items' => __('Tất cả Danh mục Sự kiện', 'themeUniversity'),
        'parent_item' => __('Danh mục Sự kiện cha', 'themeUniversity'),
        'parent_item_colon' => __('Danh mục Sự kiện cha:', 'themeUniversity'),
        'edit_item' => __('Sửa Danh mục Sự kiện', 'themeUniversity'),
        'update_item' => __('Cập nhật Danh mục Sự kiện', 'themeUniversity'),
        'add_new_item' => __('Thêm Danh mục Sự kiện mới', 'themeUniversity'),
        'new_item_name' => __('Tên Danh mục Sự kiện mới', 'themeUniversity'),
        'menu_name' => __('Danh mục Sự kiện', 'themeUniversity'),
    );
    $event_category_args = array(
        'hierarchical' => true,
        'labels' => $event_category_labels,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'event-category'),
    );
    register_taxonomy('event_category', array('event'), $event_category_args);

    // Custom Taxonomies for Posts
    register_taxonomy(
        'custom_category',
        'post',
        array(
            'label' => __('Danh mục Tùy chỉnh'),
            'rewrite' => array('slug' => 'custom-category'),
            'hierarchical' => true,
        )
    );
    register_taxonomy(
        'custom_tag',
        'post',
        array(
            'label' => __('Thẻ Tùy chỉnh'),
            'rewrite' => array('slug' => 'custom-tag'),
            'hierarchical' => false,
        )
    );
}
add_action('init', 'create_custom_post_types');

// Add meta boxes for Events
function add_event_meta_boxes() {
    add_meta_box('event_date_metabox', 'Ngày Sự kiện', 'event_date_metabox_callback', 'event', 'normal', 'high');
    add_meta_box('event_location_metabox', 'Địa điểm Sự kiện', 'event_location_metabox_callback', 'event', 'normal', 'high');
    add_meta_box('event_time_metabox', 'Thời gian Sự kiện', 'event_time_metabox_callback', 'event', 'normal', 'high');
}
add_action('add_meta_boxes', 'add_event_meta_boxes');

function event_date_metabox_callback($post) {
    wp_nonce_field('save_event_meta_boxes', 'event_meta_nonce');
    $event_date = get_post_meta($post->ID, 'event_date', true);
    echo '<label for="event_date">Ngày Sự kiện:</label>';
    echo '<input type="date" id="event_date" name="event_date" value="' . esc_attr($event_date) . '">';
}

function event_location_metabox_callback($post) {
    wp_nonce_field('save_event_meta_boxes', 'event_meta_nonce');
    $event_location = get_post_meta($post->ID, 'event_location', true);
    echo '<label for="event_location">Địa điểm Sự kiện:</label>';
    echo '<input type="text" id="event_location" name="event_location" value="' . esc_attr($event_location) . '">';
}

function event_time_metabox_callback($post) {
    wp_nonce_field('save_event_meta_boxes', 'event_meta_nonce');
    $event_time = get_post_meta($post->ID, 'event_time', true);
    echo '<label for="event_time">Thời gian Sự kiện:</label>';
    echo '<input type="time" id="event_time" name="event_time" value="' . esc_attr($event_time) . '">';
}

function save_event_meta_boxes($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!isset($_POST['event_meta_nonce']) || !wp_verify_nonce($_POST['event_meta_nonce'], 'save_event_meta_boxes')) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['event_date'])) {
        update_post_meta($post_id, 'event_date', sanitize_text_field($_POST['event_date']));
    }
    if (isset($_POST['event_location'])) {
        update_post_meta($post_id, 'event_location', sanitize_text_field($_POST['event_location']));
    }
    if (isset($_POST['event_time'])) {
        update_post_meta($post_id, 'event_time', sanitize_text_field($_POST['event_time']));
    }
}
add_action('save_post', 'save_event_meta_boxes');

// Add meta boxes for Slides
function add_slides_meta_boxes() {
    add_meta_box('slide_link_metabox', 'Slide Link', 'slide_link_metabox_callback', 'slides', 'normal', 'high');
}
add_action('add_meta_boxes', 'add_slides_meta_boxes');

function slide_link_metabox_callback($post) {
    wp_nonce_field('save_slides_meta_boxes', 'slides_meta_nonce');
    $slide_link = get_post_meta($post->ID, 'slide_link', true);
    echo '<label for="slide_link">Slide Link:</label>';
    echo '<input type="url" id="slide_link" name="slide_link" value="' . esc_url($slide_link) . '">';
}

function save_slides_meta_boxes($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!isset($_POST['slides_meta_nonce']) || !wp_verify_nonce($_POST['slides_meta_nonce'], 'save_slides_meta_boxes')) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['slide_link'])) {
        update_post_meta($post_id, 'slide_link', esc_url_raw($_POST['slide_link']));
    }
}
add_action('save_post', 'save_slides_meta_boxes');

?>
