<?php

add_action('rest_api_init', 'universityLikeRoutes');
// Hook into the REST API initialization to register custom routes.

function universityLikeRoutes() {
  // Register a REST route for creating a "like".
  register_rest_route('university/v1', 'manageLike', array(
    'methods' => 'POST',
    'callback' => 'createLike'
  ));

  // Register a REST route for deleting a "like".
  register_rest_route('university/v1', 'manageLike', array(
    'methods' => 'DELETE',
    'callback' => 'deleteLike'
  ));
}

function createLike($data) {
  // Check if the user is logged in before allowing the creation of a "like".
  if (is_user_logged_in()) {
    // Sanitize the input data to prevent security issues.
    $professor = sanitize_text_field($data['professorId']);

    // Query to check if the user has already liked this professor.
    $existQuery = new WP_Query(array(
      'author' => get_current_user_id(),
      'post_type' => 'like',
      'meta_query' => array(
        array(
          'key' => 'liked_professor_id',
          'compare' => '=',
          'value' => $professor
        )
      )
    ));

    // If the professor hasn't been liked yet and the post type is 'professor', create a new "like".
    if ($existQuery->found_posts == 0 AND get_post_type($professor) == 'professor') {
      return wp_insert_post(array(
        'post_type' => 'like',
        'post_status' => 'publish',
        'post_title' => '2nd PHP Test',
        'meta_input' => array(
          'liked_professor_id' => $professor
        )
      ));
    } else {
      die("Invalid professor id");
      // Error message if the professor ID is invalid.
    }

  } else {
    die("Only logged in users can create a like.");
    // Error message if the user is not logged in.
  }
}

function deleteLike($data) {
  // Sanitize the input data to prevent security issues.
  $likeId = sanitize_text_field($data['like']);
  
  // Check if the current user is the author of the "like" and if the post type is 'like'.
  if (get_current_user_id() == get_post_field('post_author', $likeId) AND get_post_type($likeId) == 'like') {
    wp_delete_post($likeId, true);
    return 'Congrats, like deleted.';
    // Return a success message if the "like" is deleted.
  } else {
    die("You do not have permission to delete that.");
    // Error message if the user does not have permission to delete the "like".
  }
}
