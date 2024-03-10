<?php
    // Display the header
    get_header();
    // Start a while loop to iterate through all available posts
    while(have_posts()) {
        // Fetch or setup current post data for use in the loop
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
            <div class="metabox metabox--position-up metabox--with-home-link">
                <p>
                    <!-- Hyperlink to go back to the parent page -->
                    <a class="metabox__blog-home-link" href="<?php echo site_url('/blog'); ?>">
                    <i class="fa fa-home" aria-hidden="true"></i> Blog
                    </a>
                    <!-- Displaying the time and category of the post -->
                    <span class="metabox__main">Posted by <?php the_author_posts_link(); ?> on <?php the_time('n.j.y'); ?> in <?php echo get_the_category_list(', '); ?></span>
                </p>
            </div>
            <div class="generic-content"><?php the_content(); ?></div>
        </div>
    <?php 
    }
    // Display the footer
    get_footer();
?>