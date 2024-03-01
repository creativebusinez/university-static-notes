<?php
    // Start a while loop to iterate through all available posts
    while(have_posts()) {
        // Fetch or setup current post data for use in the loop
        the_post(); ?>

        <!-- Display the title of the current post -->
        <h2><?php the_title(); ?></h2>
        
        <?php 
        // Display content of the current post
        the_content(); ?>
    <?php 
    }
?>
