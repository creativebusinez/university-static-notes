<?php
    //the_ID(); // Display the ID of the current post
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
                    <a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('program'); ?>">
                        <i class="fa fa-home" aria-hidden="true"></i> All Programs
                    </a>
                    <!-- Displaying the author, time, and category of the post -->
                    <span class="metabox__main"><?php the_title(); ?></span>
                </p>
            </div>
            <div class="generic-content"><?php the_content(); ?></div>
            <?php

$relatedProfessors = new WP_Query(array(
    'posts_per_page' => -1, // show all
    //'posts_per_page' => 2, // show 2
    'post_type' => 'professor', // event post type
    'orderby' => 'title', // by title
    'order' => 'ASC', // ascending
    'meta_query' => array(
        array( //filter by related program
            'key' => 'related_programs',
            'compare' => 'LIKE',
            'value' => '"' . get_the_ID() . '"'
        )
    )
));

if ($relatedProfessors->have_posts()) {
    echo '<hr class="section-break">';
    echo '<h2 class="headline headline--medium"> ' . get_the_title() . ' Professors</h2>';

    echo '<ul class="professor-cards">';
    while ($relatedProfessors->have_posts()) {
        $relatedProfessors->the_post(); ?>
        <li class="professor-card__list-item">
            <a class="professor-card" href="<?php the_permalink(); ?>">
                <img class="professor-card__image" src="<?php the_post_thumbnail_url('professorLandscape'); ?>">
                <span class="professor-card__name"><?php the_title(); ?></span>
            </a>
        </li>
        <?php }
    echo '</ul>';
    }

    wp_reset_postdata();

                $today = date('Ymd');
                $homepageEvents = new WP_Query(array(
                    //'posts_per_page' => -1, // show all
                    'posts_per_page' => 2, // show 2
                    'post_type' => 'event', // event post type
                    'meta_key' => 'event_date', // sort by date
                    'orderby' => 'meta_value_num', // numeric
                    'order' => 'ASC', // ascending
                    'meta_query' => array(
                        array( //filter by current date
                            'key' => 'event_date',
                            'compare' => '>=',
                            'value' => $today,
                            'type' => 'numeric'
                        ),
                        array( //filter by related program
                            'key' => 'related_programs',
                            'compare' => 'LIKE',
                            'value' => '"' . get_the_ID() . '"'
                        )
                    )
                ));

                if ($homepageEvents->have_posts()) {
                    echo '<hr class="section-break">';
                    echo '<h2 class="headline headline--medium">Upcoming ' . get_the_title() . ' Events</h2>';
    
                    while ($homepageEvents->have_posts()) {
                        $homepageEvents->the_post(); ?>
                        <div class="event-summary">
                            <a class="event-summary__date event-summary__date t-center" href="<?php the_permalink() ?>">
                            <span class="event-summary__month">
                                <?php // get the month
                                    $eventDate = new DateTime(get_field('event_date')); // get the date
                                    echo $eventDate->format('M'); // get the month
                                ?>
                            </span>
                            <span class="event-summary__day">
                                <?php // get the day
                                    echo $eventDate->format('d'); // get the day
                                ?>
                            </span>
                            </a>
                            <div class="event-summary__content">
                            <h5 class="event-summary__title headline headline--tiny"><a href="<?php the_permalink() ?>""><?php the_title() ?></a></h5>
                            <p><?php if (has_excerpt()) {
                                    echo get_the_excerpt(); 
                                } else {
                                    echo wp_trim_words(get_the_content(), 18);
                            } ?> <a href="<?php the_permalink() ?>" class="nu gray">Learn more</a>
                            </p>
                            </div>
                        </div>
                        <?php }
                    }
                    wp_reset_postdata();
                ?>
            </div>
        <?php 
        }
    // Display the footer
    get_footer();
?>