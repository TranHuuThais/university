<?php

// Enqueue styles and scripts
function theme_enqueue_assets()
{
    wp_enqueue_style('index_university_font_google', "https://fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i");
    wp_enqueue_style('index_university_bootstrap', "https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css");
    wp_enqueue_style('index_university', get_theme_file_uri('build/index.css'), array(), '1.0');
    wp_enqueue_style('index_university_extra', get_theme_file_uri('build/style-index.css'), array(), '1.0');
    wp_enqueue_script('index_university_script-1', get_theme_file_uri('build/mobile.js'), array(), '1.0', true);
    wp_enqueue_script('index_university_script', get_theme_file_uri('build/index.js'), array('jquery'), '1.0', true);
}
add_action('wp_enqueue_scripts', 'theme_enqueue_assets');

// Custom pagination
function custom_paginate_links()
{
    $args = array(
        'prev_text' => '<span class="pagination-previous">Trước</span>',
        'next_text' => '<span class="pagination-next">Sau</span>',
    );
    echo '<div class="custom-paginate-links">';
    echo paginate_links($args);
    echo '</div>';
}
