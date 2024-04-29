<?php
    // Calls the header.php file from your theme directory
    get_header();

    // Loops through the posts, until it has gone through them all
    while(have_posts()) {
        // Prepares the post for working with template tags
        the_post(); ?>
        <!-- Creating a section for page banner -->
        <div class="page-banner">
          <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('/images/ocean.jpg'); ?>)"></div>
          <div class="page-banner__content container container--narrow">
            <!-- Displaying the title of the page -->
            <h1 class="page-banner__title"><?php the_title(); ?></h1>
            <div class="page-banner__intro">
              <p>DONT FORGET TO REPLACE ME LATER</p>
            </div>
          </div>
        </div>

        <!-- Section for content -->
        <div class="container container--narrow page-section">
          <?php
            // Fetches the parent post ID of the current post or page 
            $theParent = wp_get_post_parent_id(get_the_ID());
            // Checks if the fetched post or page does have a parent
            if ($theParent) { ?>
              <div class="metabox metabox--position-up metabox--with-home-link">
                <p>
                  <!-- Hyperlink to go back to the parent page -->
                  <a class="metabox__blog-home-link" href="<?php echo get_permalink($theParent); ?>">
                    <i class="fa fa-home" aria-hidden="true"></i> Back to <?php echo get_the_title($theParent); ?>
                  </a> 
                  <span class="metabox__main"><?php the_title(); ?></span>
                </p>
              </div>
            <?php }
          ?>

        <?php 
        // Fetches the pages that are children to the current page
        $testArray = get_pages(array(
          'child_of' => get_the_ID()
        ));
        
        // Checks whether this page has a parent or is a parent itself
        if ($theParent or $testArray) { ?>
          <div class="page-links">
            <h2 class="page-links__title"><a href="<?php echo get_permalink($theParent); ?>""><?php echo get_the_title($theParent); ?></a></h2>
            <ul class="min-list">
              <?php
                // Another check for the parent page
                if ($theParent) {
                  $findChildrenOf = $theParent;
                } else {
                  $findChildrenOf = get_the_ID();
                }
                // Lists all child pages from either current page or its parent
                wp_list_pages(
                  array(
                    'title_li' => NULL,
                    'child_of' => $findChildrenOf,
                    'sort_column' => 'menu_order'
                  )
                );
              ?>
            </ul>
          </div>
        <?php } ?>

          <!-- Displays content of the page -->
          <div class="generic-content">
            <?php the_content(); ?>
          </div>
        </div>

    <?php } // Ends the loop 
    

    get_footer(); // Calls the footer.php file from your theme directory

?>