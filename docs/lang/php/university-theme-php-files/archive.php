<?php
// Include the header template for the page.
get_header();

// Display a banner at the top of the page with the archive title and description.
// The title and subtitle are dynamically generated based on the archive.
pageBanner(array(
  'title' => get_the_archive_title(),
  'subtitle' => get_the_archive_description()
));
?>

<div class="container container--narrow page-section">
  <!-- Start of the container for the page content. -->

  <?php
  // Loop through available posts.
  while (have_posts()) {
    the_post(); // Prepare the post data.
  ?>
    <!-- Start of an individual post item. -->
    <div class="post-item">
      <!-- Display the post title as a link to the post's permalink. -->
      <h2 class="headline headline--medium headline--post-title">
        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
      </h2>
      
      <!-- Display the post meta information: author, date, and categories. -->
      <div class="metabox">
        <p>
          Posted by <?php the_author_posts_link(); ?> on <?php the_time('n.j.y'); ?> in <?php echo get_the_category_list(', '); ?>
        </p>
      </div>

      <!-- Display the post excerpt and a button linking to the full post. -->
      <div class="generic-content">
        <?php the_excerpt(); ?>
        <p><a class="btn btn--blue" href="<?php the_permalink(); ?>">Continue reading &raquo;</a></p>
      </div>
    </div>
    <!-- End of an individual post item. -->
  <?php } // End of the posts loop. ?>

  <!-- Display pagination links for navigating through the posts. -->
  <?php echo paginate_links(); ?>
</div>
<!-- End of the container for the page content. -->

<?php
// Include the footer template for the page.
get_footer();
?>
