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