<?php

get_header();
// Include the header template for the page.

while (have_posts()) {
  the_post();
  pageBanner();
  // Display the page banner.

  ?>

  <div class="container container--narrow page-section">
    <!-- Start of the container for the page content. -->

    <div class="generic-content">
      <!-- Start of the generic content section. -->

      <div class="row group">
        <!-- Start of a row with two columns: one-third and two-thirds. -->

        <div class="one-third">
          <?php the_post_thumbnail('professorPortrait'); ?>
          <!-- Display the professor's portrait thumbnail image. -->
        </div>

        <div class="two-thirds">
          <?php
          // Query to count the number of likes for this professor.
          $likeCount = new WP_Query(array(
            'post_type' => 'like',
            'meta_query' => array(
              array(
                'key' => 'liked_professor_id',
                'compare' => '=',
                'value' => get_the_ID()
              )
            )
          ));

          $existStatus = 'no';

          if (is_user_logged_in()) {
            // Check if the current user has already liked this professor.
            $existQuery = new WP_Query(array(
              'author' => get_current_user_id(),
              'post_type' => 'like',
              'meta_query' => array(
                array(
                  'key' => 'liked_professor_id',
                  'compare' => '=',
                  'value' => get_the_ID()
                )
              )
            ));

            if ($existQuery->found_posts) {
              $existStatus = 'yes';
            }
          }
          ?>

          <span class="like-box" data-like="<?php if (isset($existQuery->posts[0]->ID)) echo esc_attr($existQuery->posts[0]->ID); ?>" data-professor="<?php the_ID(); ?>" data-exists="<?php echo esc_attr($existStatus); ?>">
            <i class="fa fa-heart-o" aria-hidden="true"></i>
            <i class="fa fa-heart" aria-hidden="true"></i>
            <span class="like-count"><?php echo esc_html($likeCount->found_posts); ?></span>
            <!-- Display the like button and the count of likes. -->
          </span>
          <?php the_content(); ?>
          <!-- Display the content of the professor's page. -->
        </div>

      </div>
    </div>

    <?php
    // Get the related programs from the custom field.
    $relatedPrograms = get_field('related_programs');

    if ($relatedPrograms) {
      echo '<hr class="section-break">';
      echo '<h2 class="headline headline--medium">Subject(s) Taught</h2>';
      // Display a headline for the related programs.

      echo '<ul class="link-list min-list">';
      // Start an unordered list for related programs.

      foreach ($relatedPrograms as $program) { ?>
        <li><a href="<?php echo esc_url(get_the_permalink($program)); ?>"><?php echo esc_html(get_the_title($program)); ?></a></li>
        <!-- Display the title of each related program as a link to the program page. -->
      <?php }
      echo '</ul>';
      // End the unordered list.
    }

    ?>

  </div>
  <!-- End of the container for the page content. -->

<?php }

get_footer();
// Include the footer template for the page.

?>