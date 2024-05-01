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
            <div class="generic-content">
                <div class="row group">
                    <div class="one-third">
                        <?php the_post_thumbnail('professorPortrait'); ?>
                    </div>
                    <div class="two-thirds">
                        <?php the_content(); ?>
                    </div>
                </div>
            </div>
            <?php
                $relatedPrograms = get_field('related_programs');
                    if ($relatedPrograms) {
                        echo '<hr class="section-break">';
                        echo '<h2 class="headline headline--medium">Subject(s) Taught</h2>';
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