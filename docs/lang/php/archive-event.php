<?php get_header(); ?>

    <!-- Creating a section for page banner -->
    <div class="page-banner">
        <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('/images/ocean.jpg'); ?>)"></div>
        <div class="page-banner__content container container--narrow">
            <!-- Displaying the title of the page -->
            <h1 class="page-banner__title">All Events</h1>
            <div class="page-banner__intro">
                <p>See what is going on in our world.</p>
            </div>
        </div>
    </div>

    <!-- Section for content -->
    <div class="container container--narrow page-section">
        <?php
            while(have_posts()) {
                the_post(); ?>
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
        echo paginate_links();
        ?>
        <p>Past events <a href="<?php echo site_url('/past-events') ?>">archive</a></p>
    </div>

<?php get_footer(); ?>