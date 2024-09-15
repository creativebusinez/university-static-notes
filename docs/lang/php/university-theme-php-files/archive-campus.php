<?php
// Include the header template for the page.
get_header();

// Display a banner at the top of the page with the title and subtitle.
pageBanner(array(
  'title' => 'Our Campuses', // Associative array with 'title' and 'subtitle' keys.
  'subtitle' => 'We have several conveniently located campuses.'
));
?>

<div class="container container--narrow page-section">
  <!-- Start of the container for the page content. -->

  <div class="acf-map">
    <!-- Start of the ACF (Advanced Custom Fields) map container. -->

    <?php
    // Loop through available posts.
    while (have_posts()) {
      the_post(); // Prepare the post data.

      // Get the map location custom field (an array with 'lat', 'lng', and 'address').
      $mapLocation = get_field('map_location');
    ?>
      <!-- Create a marker for each post with latitude and longitude data. -->
      <div class="marker" data-lat="<?php echo esc_attr($mapLocation['lat']); ?>" data-lng="<?php echo esc_attr($mapLocation['lng']); ?>">
        <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
        <?php echo esc_html($mapLocation['address']); ?>
      </div>
    <?php } // End of the posts loop. ?>
  </div>
  <!-- End of the ACF map container. -->

</div>
<!-- End of the container for the page content. -->

<?php
// Include the footer template for the page.
get_footer();
?>