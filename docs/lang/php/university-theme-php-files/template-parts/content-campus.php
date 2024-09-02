<div class="post-item">
  <!-- Container for a single post item. -->

  <h2 class="headline headline--medium headline--post-title">
    <a href="<?php the_permalink(); ?>">
      <?php the_title(); ?>
      <!-- Display the title of the post as a link to the post's permalink. -->
    </a>
  </h2>

  <div class="generic-content">
    <!-- Container for the post's excerpt and link. -->

    <?php the_excerpt(); ?>
    <!-- Display the excerpt of the post. -->

    <p>
      <a class="btn btn--blue" href="<?php the_permalink(); ?>">
        View campus &raquo;
        <!-- Button linking to the full post with the label "View campus". -->
      </a>
    </p>
  </div>

</div>
