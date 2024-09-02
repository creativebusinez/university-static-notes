<?php

// Include the necessary PHP files for custom REST API routes.
require get_theme_file_path('/inc/like-route.php');
require get_theme_file_path('/inc/search-route.php');

function university_custom_rest() {
  // Register a custom REST field 'authorName' for the 'post' post type.
  register_rest_field('post', 'authorName', array(
    'get_callback' => function() {
      return get_the_author(); // Return the post author name.
    }
  ));

  // Register a custom REST field 'userNoteCount' for the 'note' post type.
  register_rest_field('note', 'userNoteCount', array(
    'get_callback' => function() {
      return count_user_posts(get_current_user_id(), 'note'); // Return the count of notes created by the current user.
    }
  ));
}

// Hook the custom REST API fields registration to 'rest_api_init' action.
add_action('rest_api_init', 'university_custom_rest');

function pageBanner($args = NULL) {
  
  // Set the default title if none is provided in the arguments.
  if (!isset($args['title'])) {
    $args['title'] = get_the_title();
  }

  // Set the default subtitle if none is provided in the arguments.
  if (!isset($args['subtitle'])) {
    $args['subtitle'] = get_field('page_banner_subtitle');
  }

  // Set the default background photo if none is provided in the arguments.
  if (!isset($args['photo'])) {
    if (get_field('page_banner_background_image') && !is_archive() && !is_home()) {
      $args['photo'] = get_field('page_banner_background_image')['sizes']['pageBanner'];
    } else {
      $args['photo'] = get_theme_file_uri('/images/ocean.jpg');
    }
  }

  // Output the page banner HTML.
  ?>
  <div class="page-banner">
    <div class="page-banner__bg-image" style="background-image: url(<?php echo esc_url($args['photo']); ?>);"></div>
    <div class="page-banner__content container container--narrow">
      <h1 class="page-banner__title"><?php echo esc_html($args['title']); ?></h1>
      <div class="page-banner__intro">
        <p><?php echo esc_html($args['subtitle']); ?></p>
      </div>
    </div>  
  </div>
<?php }

function university_files() {
  // Enqueue Google Maps API script.
  wp_enqueue_script('googleMap', '//maps.googleapis.com/maps/api/js?key=AIzaSyDin3iGCdZ7RPomFLyb2yqFERhs55dmfTI', NULL, '1.0', true);
  
  // Enqueue the main JavaScript file for the theme.
  wp_enqueue_script('main-university-js', get_theme_file_uri('/build/index.js'), array('jquery'), '1.0', true);
  
  // Enqueue custom Google Fonts.
  wp_enqueue_style('custom-google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
  
  // Enqueue Font Awesome for icons.
  wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
  
  // Enqueue the main stylesheet for the theme.
  wp_enqueue_style('university_main_styles', get_theme_file_uri('/build/style-index.css'));
  
  // Enqueue additional stylesheets for the theme.
  wp_enqueue_style('university_extra_styles', get_theme_file_uri('/build/index.css'));

  // Localize script with additional data for use in JavaScript.
  wp_localize_script('main-university-js', 'universityData', array(
    'root_url' => get_site_url(),
    'nonce' => wp_create_nonce('wp_rest')
  ));
}

// Hook the file enqueuing to 'wp_enqueue_scripts' action.
add_action('wp_enqueue_scripts', 'university_files');

function university_features() {
  // Add support for the title tag to be managed by WordPress.
  add_theme_support('title-tag');
  
  // Add support for post thumbnails.
  add_theme_support('post-thumbnails');
  
  // Register custom image sizes for the theme.
  add_image_size('professorLandscape', 400, 260, true);
  add_image_size('professorPortrait', 480, 650, true);
  add_image_size('pageBanner', 1500, 350, true);
}

// Hook the theme setup to 'after_setup_theme' action.
add_action('after_setup_theme', 'university_features');

function university_adjust_queries($query) {
  // Adjust queries for the 'campus' post type archive.
  if (!is_admin() && is_post_type_archive('campus') && $query->is_main_query()) {
    $query->set('posts_per_page', -1); // Display all campuses.
  }

  // Adjust queries for the 'program' post type archive.
  if (!is_admin() && is_post_type_archive('program') && $query->is_main_query()) {
    $query->set('orderby', 'title'); // Order programs alphabetically by title.
    $query->set('order', 'ASC');
    $query->set('posts_per_page', -1); // Display all programs.
  }

  // Adjust queries for the 'event' post type archive.
  if (!is_admin() && is_post_type_archive('event') && $query->is_main_query()) {
    $today = date('Ymd');
    $query->set('meta_key', 'event_date');
    $query->set('orderby', 'meta_value_num');
    $query->set('order', 'ASC');
    $query->set('meta_query', array(
      array(
        'key' => 'event_date',
        'compare' => '>=',
        'value' => $today,
        'type' => 'numeric'
      )
    ));
  }
}

// Hook the query adjustments to 'pre_get_posts' action.
add_action('pre_get_posts', 'university_adjust_queries');

function universityMapKey($api) {
  // Set the API key for Google Maps in ACF (Advanced Custom Fields).
  $api['key'] = 'yourKeyGoesHere';
  return $api;
}

// Hook the Google Maps API key setting to ACF filter.
add_filter('acf/fields/google_map/api', 'universityMapKey');

// Redirect subscriber accounts out of admin and onto the homepage.
add_action('admin_init', 'redirectSubsToFrontend');

function redirectSubsToFrontend() {
  $ourCurrentUser = wp_get_current_user();

  if (count($ourCurrentUser->roles) == 1 && $ourCurrentUser->roles[0] == 'subscriber') {
    wp_redirect(site_url('/'));
    exit;
  }
}

// Hide the admin bar for subscriber accounts.
add_action('wp_loaded', 'noSubsAdminBar');

function noSubsAdminBar() {
  $ourCurrentUser = wp_get_current_user();

  if (count($ourCurrentUser->roles) == 1 && $ourCurrentUser->roles[0] == 'subscriber') {
    show_admin_bar(false);
  }
}

// Customize the login screen URL.
add_filter('login_headerurl', 'ourHeaderUrl');

function ourHeaderUrl() {
  return esc_url(site_url('/'));
}

// Enqueue styles for the login screen.
add_action('login_enqueue_scripts', 'ourLoginCSS');

function ourLoginCSS() {
  wp_enqueue_style('custom-google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
  wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
  wp_enqueue_style('university_main_styles', get_theme_file_uri('/build/style-index.css'));
  wp_enqueue_style('university_extra_styles', get_theme_file_uri('/build/index.css'));
}

// Customize the login screen title attribute.
add_filter('login_headertitle', 'ourLoginTitle');

function ourLoginTitle() {
  return get_bloginfo('name');
}

// Force 'note' posts to be private.
add_filter('wp_insert_post_data', 'makeNotePrivate', 10, 2);

function makeNotePrivate($data, $postarr) {
  if ($data['post_type'] == 'note') {
    // Limit users to creating 5 notes.
    if (count_user_posts(get_current_user_id(), 'note') > 4 && !$postarr['ID']) {
      die("You have reached your note limit.");
    }

    // Sanitize the note content and title.
    $data['post_content'] = sanitize_textarea_field($data['post_content']);
    $data['post_title'] = sanitize_text_field($data['post_title']);
  }

  // Ensure the note post is private if it's not in the trash.
  if ($data['post_type'] == 'note' && $data['post_status'] != 'trash') {
    $data['post_status'] = "private";
  }
  
  return $data;
}
