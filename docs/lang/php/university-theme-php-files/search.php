<?php

get_header();
// Include the header template for the page.

pageBanner(array(
  'title' => 'Search Results',
  'subtitle' => 'You searched for &ldquo;' . esc_html(get_search_query(false)) . '&rdquo;'
));
// Display a banner at the top of the page with the search results title and the searched query.

?>

<div class="container container--narrow page-section">
  <!-- Start of the container for the page content. -->

  <?php
  // Check if there are any posts that match the search query.
  if (have_posts()) {
    while (have_posts()) {
      the_post();
      // Loop through the posts and display the content for each.

      get_template_part('template-parts/content', get_post_type());
      // Load the template part for displaying the content based on the post type.
    }
    echo paginate_links();
    // Display pagination links for navigating through the search results.
  } else {
    echo '<h2 class="headline headline--small-plus">No results match that search.</h2>';
    // Display a message if no posts match the search query.
  }

  get_search_form();
  // Display the search form again for the user to perform a new search.
  ?>

</div>
<!-- End of the container for the page content. -->

<?php get_footer();
// Include the footer template for the page.
?>
