<?php
// Include the header template for the page.
get_header();

// Display a banner at the top of the page with the title and subtitle.
pageBanner(array(
  'title' => 'All Programs',
  'subtitle' => 'There is something for everyone. Have a look around.'
));
?>

<div class="container container--narrow page-section">
  <!-- Start of the container for the page content. -->

  <ul class="link-list min-list">
    <!-- Start of the unordered list to display program links. -->

    <?php
    // Loop through available posts.
    while (have_posts()) {
      the_post(); // Prepare the post data.
    ?>
      <!-- Display each post title as a link to its permalink. -->
      <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
    <?php } // End of the posts loop. ?>
    
    <!-- Display pagination links for navigating through the posts. -->
    <?php echo paginate_links(); ?>
  </ul>
  <!-- End of the unordered list. -->

</div>
<!-- End of the container for the page content. -->

<?php
// Include the footer template for the page.
get_footer();
?>
