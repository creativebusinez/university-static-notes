<?php

get_header();
// Include the header template for the page.

pageBanner(array(
  'title' => 'Welcome to our blog!',
  'subtitle' => 'Keep up with our latest news.'
));
// Display a banner at the top of the page with the title and subtitle.

?>
<div class="container container--narrow page-section">
  <!-- Start of the container for the page content. -->

  <?php
  // Loop through available posts.
  while (have_posts()) {
    the_post(); // Prepare the post data.
  ?>
    <div class="post-item">
      <!-- Start of an individual post item. -->

      <h2 class="headline headline--medium headline--post-title">
        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
      </h2>
      <!-- Display the post title as a link to the post's permalink. -->

      <div class="metabox">
        <p>
          Posted by <?php the_author_posts_link(); ?> on <?php the_time('n.j.y'); ?> in <?php echo get_the_category_list(', '); ?>
        </p>
      </div>
      <!-- Display the post meta information: author, date, and categories. -->

      <div class="generic-content">
        <?php the_excerpt(); ?>
        <p><a class="btn btn--blue" href="<?php the_permalink(); ?>">Continue reading &raquo;</a></p>
        <!-- Display the post excerpt and a button linking to the full post. -->
      </div>

    </div>
    <!-- End of an individual post item. -->
  <?php } // End of the posts loop. ?>

  <?php
  // Display pagination links for navigating through the posts.
  echo paginate_links();
  ?>
</div>
<!-- End of the container for the page content. -->

<?php
get_footer();
// Include the footer template for the page.
?>
