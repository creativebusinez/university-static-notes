<?php
    // Display the header
    get_header();
    // Start a while loop to iterate through all available posts
    while(have_posts()) {
        // Fetch or setup current post data for use in the loop
        the_post();
        pageBanner();
        ?>
        <!-- Creating a section for page banner -->

        <!-- Section for content -->
        <div class="container container--narrow page-section">
            <div class="metabox metabox--position-up metabox--with-home-link">
                <p>
                    <!-- Hyperlink to go back to the parent page -->
                    <a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('event'); ?>">
                        <i class="fa fa-home" aria-hidden="true"></i> Events
                    </a>
                    <!-- Displaying the author, time, and category of the post -->
                    <span class="metabox__main"><?php the_title(); ?></span>
                </p>
            </div>
            <div class="generic-content"><?php the_content(); ?></div>
            <?php
                $relatedPrograms = get_field('related_programs');
                    if ($relatedPrograms) {
                        echo '<hr class="section-break">';
                        echo '<h2 class="headline headline--medium">Related Programs</h2>';
                        echo '<ul class="link-list min-list">';
                        foreach($relatedPrograms as $program) { ?>
                            <li><a href="<?php echo get_the_permalink($program); ?>"><?php echo get_the_title($program); ?></a></li>
                        <?php
                    // echo get_the_title($program);
                        }
                    }
            ?>   
        </div>
    <?php 
    }
    // Display the footer
    get_footer();
?>