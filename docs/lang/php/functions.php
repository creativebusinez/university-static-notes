<?php

function pageBanner($args = NULL) {
    // if title is not set, use the default
    if (!isset($args['title'])) {
        $args['title'] = get_the_title(); // get_the_title() gets the title of the page
    }
    // if subtitle is not set, use the default
    if (!isset($args['subtitle'])) {
        $args['subtitle'] = get_field('page_banner_subtitle'); // get_field() gets the value of the field from the acf field group
    }
    // if photo is not set, use the default
    if (!isset($args['photo'])) {
        // if the page banner has a background image
        if (get_field('page_banner_background_image')) {
            // set the photo to the background image
            $args['photo'] = get_field('page_banner_background_image')['sizes']['pageBanner'];
        } else {
            // set the photo to the default
            $args['photo'] = get_theme_file_uri('/images/ocean.jpg');
        }
    }
    ?>
        <div class="page-banner">
        <div class="page-banner__bg-image" style="background-image: url(<?php echo $args['photo'] ?>);"></div>
            <div class="page-banner__content container container--narrow">
                <!-- Displaying the title of the page -->
                <h1 class="page-banner__title"><?php echo $args['title'] ?></h1>
                <div class="page-banner__intro">
                <p><?php echo $args['subtitle'] ?></p>
                </div>
            </div>
        </div>
    <?php
}

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
    add_theme_support('post-thumbnails');
    add_image_size('professorLandscape', 400, 260, true);
    add_image_size('professorPortrait', 480, 650, true);
    add_image_size('pageBanner', 1500, 350, true);
}

// Hook the university_features function into the after_setup_theme action
add_action('after_setup_theme', 'university_features');

function university_adjust_queries($query) {

    if (!is_admin() AND is_post_type_archive('program') AND is_main_query()) {
        $query->set('orderby', 'title');// order by title alphabetically
        $query->set('order', 'ASC');// order in ascending order
        $query->set('posts_per_page', -1);// set posts per page to -1 to get ininite amount of posts
    }

    if (!is_admin() AND is_post_type_archive('event') AND $query->is_main_query()) {
        //$query->set('posts_per_page', '1'); not a real use case, just for pagination test
        $today = date('Ymd');
        $query->set('meta_key', 'event_date'); // Required when ordering by a custom field
        $query->set('orderby', 'meta_value_num'); // Use 'meta_value' for non-numeric fields
        $query->set('order', 'ASC'); // Use 'ASC' or 'DESC'
        $query->set('meta_query', array(// Array of query parameters
            array( // Associative array
                'key' => 'event_date', // Custom field
                'compare' => '>=', // Operator
                'value' => $today,
                'type' => 'numeric' // 'numeric' or 'date'
            )
        ));
    }
}

add_action('pre_get_posts', 'university_adjust_queries');

