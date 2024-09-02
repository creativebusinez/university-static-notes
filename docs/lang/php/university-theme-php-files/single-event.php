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

    <div class="metabox metabox--position-up metabox--with-home-link">
      <!-- Metabox with a link to the Events archive page and the current event title. -->

      <p>
        <a class="metabox__blog-home-link" href="<?php echo esc_url(get_post_type_archive_link('event')); ?>">
          <i class="fa fa-home" aria-hidden="true"></i> Events Home
        </a>
        <span class="metabox__main"><?php the_title(); ?></span>
        <!-- Display the title of the current event. -->
      </p>
    </div>

    <div class="generic-content">
      <?php the_content(); ?>
      <!-- Display the content of the current event page. -->
    </div>

    <?php
    // Get the related programs from the custom field.
    $relatedPrograms = get_field('related_programs');

    if ($relatedPrograms) {
      echo '<hr class="section-break">';
      echo '<h2 class="headline headline--medium">Related Program(s)</h2>';
      // Display a headline for the related programs.

      echo '<ul class="link-list min-list">';
      // Start an unordered list for related programs.

      foreach ($relatedPrograms as $program) { ?>
        <li>
          <a href="<?php echo esc_url(get_the_permalink($program)); ?>">
            <?php echo esc_html(get_the_title($program)); ?>
          </a>
          <!-- Display the title of each related program as a link to the program page. -->
        </li>
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
