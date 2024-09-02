<?php

get_header();
// Include the header template for the page.

pageBanner(array(
  'title' => 'Past Events',
  'subtitle' => 'A recap of our past events.'
));
// Display a banner at the top of the page with the title and subtitle.

?>

<div class="container container--narrow page-section">
  <!-- Start of the container for the page content. -->

  <?php
  $today = date('Ymd');
  // Get today's date in 'Ymd' format.

  // Custom query to fetch past events.
  $pastEvents = new WP_Query(array(
    'paged' => get_query_var('paged', 1), // Handle pagination.
    'post_type' => 'event',
    'meta_key' => 'event_date',
    'orderby' => 'meta_value_num',
    'order' => 'ASC',
    'meta_query' => array(
      array(
        'key' => 'event_date',
        'compare' => '<',
        'value' => $today,
        'type' => 'numeric'
      )
    )
  ));

  // Loop through the past events.
  while ($pastEvents->have_posts()) {
    $pastEvents->the_post(); 
    get_template_part('template-parts/content-event');
    // Load the template part for displaying event content.
  }

  // Display pagination links for navigating through past events.
  echo paginate_links(array(
    'total' => $pastEvents->max_num_pages
  ));

  ?>
</div>
<!-- End of the container for the page content. -->

<?php get_footer();
// Include the footer template for the page.
?>
