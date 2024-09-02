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
      <!-- Metabox with a link to the Campus archive page and the current page title. -->

      <p>
        <a class="metabox__blog-home-link" href="<?php echo esc_url(get_post_type_archive_link('campus')); ?>">
          <i class="fa fa-home" aria-hidden="true"></i> All Campuses
        </a> 
        <span class="metabox__main"><?php the_title(); ?></span>
        <!-- Display the title of the current campus page. -->
      </p>
    </div>

    <div class="generic-content">
      <?php the_content(); ?>
      <!-- Display the content of the current campus page. -->
    </div>

    <?php 
    // Get the map location custom field data.
    $mapLocation = get_field('map_location');
    ?>

    <div class="acf-map">
      <!-- Display a map using the ACF (Advanced Custom Fields) data. -->

      <div class="marker" data-lat="<?php echo esc_attr($mapLocation['lat']); ?>" data-lng="<?php echo esc_attr($mapLocation['lng']); ?>">
        <h3><?php the_title(); ?></h3>
        <!-- Display the title of the current campus. -->

        <?php echo esc_html($mapLocation['address']); ?>
        <!-- Display the address from the map location field. -->
      </div>
    </div>

    <?php 
    // Query for related programs that are associated with this campus.
    $relatedPrograms = new WP_Query(array(
      'posts_per_page' => -1,
      'post_type' => 'program',
      'orderby' => 'title',
      'order' => 'ASC',
      'meta_query' => array(
        array(
          'key' => 'related_campus',
          'compare' => 'LIKE',
          'value' => '"' . get_the_ID() . '"'
        )
      )
    ));

    if ($relatedPrograms->have_posts()) {
      echo '<hr class="section-break">';
      echo '<h2 class="headline headline--medium">Programs Available At This Campus</h2>';
      // Display a headline for the related programs.

      echo '<ul class="min-list link-list">';
      // Start an unordered list for related programs.

      while ($relatedPrograms->have_posts()) {
        $relatedPrograms->the_post(); ?>
        <li>
          <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
          <!-- Display the title of each related program as a link to the program page. -->
        </li>
      <?php }
      echo '</ul>';
      // End the unordered list.
    }

    wp_reset_postdata();
    // Reset the post data after the custom query.

    ?>

  </div>
  <!-- End of the container for the page content. -->

<?php }

get_footer();
// Include the footer template for the page.

?>
