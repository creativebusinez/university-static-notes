<div class="post-item">
  <!-- Container for a single post item. -->

  <li class="professor-card__list-item">
    <!-- List item styled as a professor card. -->

    <a class="professor-card" href="<?php the_permalink(); ?>">
      <!-- Link to the professor's page. -->

      <img class="professor-card__image" src="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'professorLandscape')); ?>" alt="<?php the_title_attribute(); ?>">
      <!-- Display the professor's landscape image with appropriate alt text. -->

      <span class="professor-card__name"><?php the_title(); ?></span>
      <!-- Display the name of the professor. -->
    </a>
  </li>
  <!-- End of the professor card list item. -->
</div>
