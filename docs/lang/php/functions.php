<?php

// Define function to enqueue script and styles
function university_files() {
    wp_enqueue_script('main-university-js', get_theme_file_uri('/build/index.js'), array('jquery'), '1.0', true);
    wp_enqueue_style ('custom-google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
    wp_enqueue_style ('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
    wp_enqueue_style ('university_main_styles', get_theme_file_uri('/build/style-index.css'));
    wp_enqueue_style ('university_extra_styles', get_theme_file_uri('/build/index.css'));
}

// Hook the university_files function into the wp_enqueue_scripts action
add_action('wp_enqueue_scripts', 'university_files');

// Define function to add theme support and custom image sizes
function university_features() {
    // register_nav_menu('headerMenuLocation', 'Header Menu Location');
    // register_nav_menu('footerLocationOne', 'Footer Location One');
    // register_nav_menu('footerLocationTwo', 'Footer Location Two');
    add_theme_support('title-tag');
    // add_theme_support('post-thumbnails');
    // add_image_size('professorLandscape', 400, 260, true);
    // add_image_size('professorPortrait', 480, 650, true);
    // add_image_size('pageBanner', 1500, 350, true);
}

// Hook the university_features function into the after_setup_theme action
add_action('after_setup_theme', 'university_features');

