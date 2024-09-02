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
      <!-- Metabox with a link to the Blog home and post details. -->

      <p>
        <a class="metabox__blog-home-link" href="<?php echo esc_url(site_url('/blog')); ?>">
          <i class="fa fa-home" aria-hidden="true"></i> Blog Home
        </a> 
        <span class="metabox__main">
          Posted by <?php the_author_posts_link(); ?> on <?php the_time('n.j.y'); ?> in <?php echo get_the_category_list(', '); ?>
          <!-- Display the author, date, and categories of the current post. -->
        </span>
      </p>
    </div>

    <div class="generic-content">
      <?php the_content(); ?>
      <!-- Display the content of the current blog post. -->
    </div>

  </div>
  <!-- End of the container for the page content. -->

<?php }

get_footer();
// Include the footer template for the page.

?>
