<?php
// Include the header template for the page.
get_header();

// Display a banner at the top of the page with the title and subtitle.
pageBanner(array(
  'title' => 'All Events',
  'subtitle' => 'See what is going on in our world.'
));
?>

<div class="container container--narrow page-section">
  <!-- Start of the container for the page content. -->

  <?php
  // Loop through available posts.
  while (have_posts()) {
    the_post(); // Prepare the post data.
    
    // Include the template part for displaying event content.
    get_template_part('template-parts/content-event');
  }
  
  // Display pagination links for navigating through the posts.
  echo paginate_links();
  ?>

  <hr class="section-break">
  
  <!-- Provide a link to the past events archive. -->
  <p>Looking for a recap of past events? 
    <a href="<?php echo esc_url(site_url('/past-events')); ?>">Check out our past events archive</a>.
  </p>

</div>
<!-- End of the container for the page content. -->

<?php
// Include the footer template for the page.
get_footer();
?>
