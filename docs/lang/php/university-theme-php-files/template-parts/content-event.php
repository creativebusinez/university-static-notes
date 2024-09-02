<div class="event-summary">
  <!-- Container for a single event summary item. -->

  <a class="event-summary__date t-center" href="#">
    <!-- Link containing the event date, centered. -->

    <span class="event-summary__month">
      <?php
      $eventDate = new DateTime(get_field('event_date'));
      echo esc_html($eventDate->format('M'));
      // Get and format the event date to display the month.
      ?>
    </span>

    <span class="event-summary__day">
      <?php echo esc_html($eventDate->format('d')); ?>
      <!-- Display the day of the event date. -->
    </span>  
  </a>

  <div class="event-summary__content">
    <!-- Container for the event content, including the title and description. -->

    <h5 class="event-summary__title headline headline--tiny">
      <a href="<?php the_permalink(); ?>">
        <?php the_title(); ?>
        <!-- Display the title of the event as a link to the event's permalink. -->
      </a>
    </h5>

    <p>
      <?php 
      if (has_excerpt()) {
        echo esc_html(get_the_excerpt());
        // Display the excerpt if it exists.
      } else {
        echo esc_html(wp_trim_words(get_the_content(), 18));
        // Display a trimmed version of the content if no excerpt is available.
      } 
      ?> 
      <a href="<?php the_permalink(); ?>" class="nu gray">Learn more</a>
      <!-- Link to the full event details with the label "Learn more". -->
    </p>
  </div>
</div>
