<?php

/**
 * Defines custom post types for the university website.
 */
function university_post_types() {
    // Event post type
    register_post_type('event', array(
        'supports' => array('title', 'editor', 'excerpt', 'thumbnail'),
        'rewrite' => array('slug' => 'events'),
        'has_archive' => true,
        'public' => true,
        'show_in_rest' => true,
        'labels' => array(
            'name' => 'Events',
            'add_new_item' => 'Add New Event',
            'edit_item' => 'Edit Event',
            'all_items' => 'All Events',
            'singular_name' => 'Event'
        ),
        'menu_icon' => 'dashicons-calendar',
    ));

    // Program post type
    register_post_type('program', [
        'show_in_rest' => true, // REST API support
        'supports' => ['title', 'editor'],// Post title and content
        'rewrite' => ['slug' => 'programs'], // URL slug
        'has_archive' => true,// Archive page
        'public' => true,// Publicly queryable
        'labels' => [// Labels
            'name' => 'Programs',// Name
            'add_new_item' => 'Add New Program',// Add new
            'edit_item' => 'Edit Program',// Edit
            'all_items' => 'All Programs',// All
            'singular_name' => 'Program'// singular
        ],
        'menu_icon' => 'dashicons-awards'// menu icon
    ]);

    // Professor post type
    register_post_type('professor', [
        'show_in_rest' => true, // REST API support
        'supports' => ['title', 'editor', 'thumbnail'],// Post title and content
        'public' => true,// Publicly queryable
        'labels' => [// Labels
            'name' => 'Professors',// Name
            'add_new_item' => 'Add New Professor',// Add new
            'edit_item' => 'Edit Professor',// Edit
            'all_items' => 'All Professors',// All
            'singular_name' => 'Professor'// singular
        ],
        'menu_icon' => 'dashicons-welcome-learn-more'// menu icon
    ]);
}

add_action('init', 'university_post_types');