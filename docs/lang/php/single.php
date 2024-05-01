<?php
    // Display the header
    get_header();
    // Start a while loop to iterate through all available posts
    while(have_posts()) {
        // Fetch or setup current post data for use in the loop
        the_post();
        pageBanner();
        ?>
        <!-- Section for content -->
        <div class="container container--narrow page-section">
            <div class="metabox metabox--position-up metabox--with-home-link">
                <p>
                    <!-- Hyperlink to go back to the parent page -->
                    <a class="metabox__blog-home-link" href="<?php echo site_url('/blog'); ?>">
                        <i class="fa fa-home" aria-hidden="true"></i> Blog
                    </a>
                    <!-- Displaying the author, time, and category of the post -->
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