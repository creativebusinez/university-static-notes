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
      <!-- Metabox with a link to the Programs archive page and the current program title. -->

      <p>
        <a class="metabox__blog-home-link" href="<?php echo esc_url(get_post_type_archive_link('program')); ?>">
          <i class="fa fa-home" aria-hidden="true"></i> All Programs
        </a> 
        <span class="metabox__main"><?php the_title(); ?></span>
        <!-- Display the title of the current program. -->
      </p>
    </div>

    <div class="generic-content">
      <?php the_field('main_body_content'); ?>
      <!-- Display the main body content of the current program page. -->
    </div>

    <?php 
    // Query for related professors associated with this program.
    $relatedProfessors = new WP_Query(array(
      'posts_per_page' => -1,
      'post_type' => 'professor',
      'orderby' => 'title',
      'order' => 'ASC',
      'meta_query' => array(
        array(
          'key' => 'related_programs',
          'compare' => 'LIKE',
          'value' => '"' . get_the_ID() . '"'
        )
      )
    ));

    if ($relatedProfessors->have_posts()) {
      echo '<hr class="section-break">';
      echo '<h2 class="headline headline--medium">' . esc_html(get_the_title()) . ' Professors</h2>';
      // Display a headline for the related professors.

      echo '<ul class="professor-cards">';
      // Start an unordered list for related professors.

      while ($relatedProfessors->have_posts()) {
        $relatedProfessors->the_post(); ?>
        <li class="professor-card__list-item">
          <a class="professor-card" href="<?php the_permalink(); ?>">
            <img class="professor-card__image" src="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'professorLandscape')); ?>">
            <span class="professor-card__name"><?php the_title(); ?></span>
          </a>
        </li>
      <?php }
      echo '</ul>';
      // End the unordered list.
    }

    wp_reset_postdata();
    // Reset the post data after the custom query.

    // Query for upcoming events related to this program.
    $today = date('Ymd');
    $homepageEvents = new WP_Query(array(
      'posts_per_page' => 2,
      'post_type' => 'event',
      'meta_key' => 'event_date',
      'orderby' => 'meta_value_num',
      'order' => 'ASC',
      'meta_query' => array(
        array(
          'key' => 'event_date',
          'compare' => '>=',
          'value' => $today,
          'type' => 'numeric'
        ),
        array(
          'key' => 'related_programs',
          'compare' => 'LIKE',
          'value' => '"' . get_the_ID() . '"'
        )
      )
    ));

    if ($homepageEvents->have_posts()) {
      echo '<hr class="section-break">';
      echo '<h2 class="headline headline--medium">Upcoming ' . esc_html(get_the_title()) . ' Events</h2>';
      // Display a headline for the upcoming events related to this program.

      while ($homepageEvents->have_posts()) {
        $homepageEvents->the_post();
        get_template_part('template-parts/content', 'event');
        // Load the template part for displaying event content.
      }
    }

    wp_reset_postdata();
    // Reset the post data after the custom query.

    // Get the related campuses from the custom field.
    $relatedCampuses = get_field('related_campus');

    if ($relatedCampuses) {
      echo '<hr class="section-break">';
      echo '<h2 class="headline headline--medium">' . esc_html(get_the_title()) . ' is Available At These Campuses:</h2>';
      // Display a headline for the campuses where this program is available.

      echo '<ul class="min-list link-list">';
      // Start an unordered list for related campuses.

      foreach ($relatedCampuses as $campus) { ?>
        <li><a href="<?php echo esc_url(get_the_permalink($campus)); ?>"><?php echo esc_html(get_the_title($campus)); ?></a></li>
        <!-- Display the title of each related campus as a link to the campus page. -->
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
