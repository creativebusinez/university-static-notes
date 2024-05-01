<?php 
    get_header();
    pageBanner(
        [
            'title' => 'Past Events',
            'subtitle' => 'A recap of our past events.'
        ]
    );
?>

    <!-- Creating a section for page banner -->
    <div class="page-banner">
        <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('/images/ocean.jpg'); ?>)"></div>
        <div class="page-banner__content container container--narrow">
            <!-- Displaying the title of the page -->
            <h1 class="page-banner__title">Past Events</h1>
            <div class="page-banner__intro">
                <p>Check out our past events.</p>
            </div>
        </div>
    </div>

    <!-- Section for content -->
    <div class="container container--narrow page-section">
        <?php
            $today = date('Ymd');
            $pastEvents = new WP_Query(array(
                'paged' => get_query_var('paged', 1), // for pagination, up to ten posts per page
                //'posts_per_page' => -1, // show all, for testing purposes
                //'posts_per_page' => 1, // show 1, for testing purposes
                //'posts_per_page' => 2, // show 2
                'post_type' => 'event', // event post type
                'meta_key' => 'event_date', // sort by date
                'orderby' => 'meta_value_num', // numeric
                'order' => 'ASC', // ascending
                'meta_query' => array(// array of query parameters
                    array(// associative array
                        'key' => 'event_date',// custom field
                        'compare' => '<=',// operator
                        'value' => $today,// current date
                        'type' => 'numeric'// 'numeric' or 'date'
                    )
                )
            ));

            while($pastEvents->have_posts()) {
                $pastEvents->the_post(); ?>
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
                            <p><?php echo wp_trim_words(get_the_content(), 18) ?> <a href="<?php the_permalink() ?>" class="nu gray">Learn more</a></p>
                        </div>
                    </div>
        <?php
                } // end while loop
        // add pagination
        echo paginate_links(
            array(
                'total' => $pastEvents->max_num_pages
            )
        );
        ?>
    </div>

<?php get_footer(); ?>