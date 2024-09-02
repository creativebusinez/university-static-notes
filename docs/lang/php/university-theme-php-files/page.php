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

    <?php
    // Check if the current page has a parent page.
    $theParent = wp_get_post_parent_id(get_the_ID());
    if ($theParent) { ?>
      <div class="metabox metabox--position-up metabox--with-home-link">
        <!-- Display a metabox with a link to the parent page. -->

        <p>
          <a class="metabox__blog-home-link" href="<?php echo get_permalink($theParent); ?>">
            <i class="fa fa-home" aria-hidden="true"></i> Back to <?php echo get_the_title($theParent); ?>
          </a> 
          <span class="metabox__main"><?php the_title(); ?></span>
          <!-- Display the title of the current page. -->
        </p>
      </div>
    <?php } ?>

    <?php 
    // Check if the current page has child pages or is a child of another page.
    $testArray = get_pages(array(
      'child_of' => get_the_ID()
    ));

    if ($theParent || $testArray) { ?>
      <div class="page-links">
        <!-- Display a list of links to sibling and child pages. -->

        <h2 class="page-links__title">
          <a href="<?php echo get_permalink($theParent); ?>">
            <?php echo get_the_title($theParent); ?>
          </a>
        </h2>
        <!-- Link to the parent page. -->

        <ul class="min-list">
          <?php
          // Determine whether to display siblings or child pages.
          if ($theParent) {
            $findChildrenOf = $theParent;
          } else {
            $findChildrenOf = get_the_ID();
          }

          // Display the list of child pages.
          wp_list_pages(array(
            'title_li' => NULL,
            'child_of' => $findChildrenOf,
            'sort_column' => 'menu_order'
          ));
          ?>
        </ul>
      </div>
    <?php } ?>

    <div class="generic-content">
      <!-- Start of the generic content section. -->
      <?php the_content(); ?>
      <!-- Display the content of the current page. -->
    </div>
    <!-- End of the generic content section. -->

  </div>
  <!-- End of the container for the page content. -->

<?php }

get_footer();
// Include the footer template for the page.

?>
